// assets/js/backend-ui.js

/**
 * pw/backend-ui — Interactive behaviors for the PW design system.
 *
 * Handles:
 *   - Theme toggle (dark/light) with localStorage persistence
 *   - Tab / UnderlineNav navigation (click + keyboard)
 *   - Segmented control
 *   - Toggle switch state
 *   - Dismissible notices
 *   - Tooltip show/hide
 *
 * No dependencies. Vanilla JS. Scoped to #pw-backend-ui-app.
 */

(function () {
	"use strict";

	const SCOPE = "#pw-backend-ui-app";
	const THEME_KEY = "pw-bui-theme";
	const THEME_DEFAULT = "dark";

	// =========================================================================
	// HELPERS
	// =========================================================================

	function getRoot() {
		return document.querySelector(SCOPE);
	}

	function $$(selector) {
		const root = getRoot();
		return root ? Array.from(root.querySelectorAll(selector)) : [];
	}

	function delegate(event, selector, handler) {
		const root = getRoot();
		if (!root) return;
		root.addEventListener(event, function (e) {
			const target = e.target.closest(selector);
			if (target && root.contains(target)) {
				handler.call(target, e);
			}
		});
	}

	// =========================================================================
	// THEME
	// =========================================================================

	function getTheme() {
		try {
			return localStorage.getItem(THEME_KEY) || THEME_DEFAULT;
		} catch (e) {
			return THEME_DEFAULT;
		}
	}

	function setTheme(theme) {
		const root = getRoot();
		if (!root) return;

		root.setAttribute("data-pw-theme", theme);

		try {
			localStorage.setItem(THEME_KEY, theme);
		} catch (e) {
			/* silently fail in private browsing */
		}

		document.dispatchEvent(
			new CustomEvent("pw-bui:theme-changed", {
				detail: { theme: theme },
			}),
		);
	}

	function initTheme() {
		const root = getRoot();
		if (!root) return;

		// Apply persisted theme immediately
		const saved = getTheme();
		root.setAttribute("data-pw-theme", saved);

		// Wire the toggle button
		delegate("click", ".pw-bui-theme-toggle", function () {
			const current = getRoot().getAttribute("data-pw-theme") || THEME_DEFAULT;
			setTheme(current === "dark" ? "light" : "dark");
		});
	}

	// =========================================================================
	// TABS (UnderlineNav)
	// =========================================================================

	function initTabs() {
		delegate("click", "[data-pw-tab]", function () {
			const slug = this.getAttribute("data-pw-tab");
			const tabNav = this.closest('[role="tablist"]');
			if (!tabNav) return;

			// Deactivate all in same nav
			tabNav.querySelectorAll("[data-pw-tab]").forEach(function (tab) {
				tab.classList.remove("pw-bui-tab--active");
				tab.setAttribute("aria-selected", "false");
			});

			// Activate clicked
			this.classList.add("pw-bui-tab--active");
			this.setAttribute("aria-selected", "true");

			// Show/hide panels
			$$("[data-pw-tab-panel]").forEach(function (panel) {
				const isTarget = panel.getAttribute("data-pw-tab-panel") === slug;
				panel.hidden = !isTarget;
				panel.setAttribute("aria-hidden", String(!isTarget));
			});

			document.dispatchEvent(
				new CustomEvent("pw-bui:tab-changed", {
					detail: { slug: slug },
				}),
			);
		});

		// Keyboard: left/right arrows
		delegate("keydown", "[data-pw-tab]", function (e) {
			if (e.key !== "ArrowLeft" && e.key !== "ArrowRight") return;
			e.preventDefault();

			const tabs = Array.from(
				this.closest('[role="tablist"]').querySelectorAll("[data-pw-tab]"),
			);
			const idx = tabs.indexOf(this);
			const nextIdx =
				e.key === "ArrowRight"
					? (idx + 1) % tabs.length
					: (idx - 1 + tabs.length) % tabs.length;

			tabs[nextIdx].focus();
			tabs[nextIdx].click();
		});
	}

	// =========================================================================
	// SEGMENTED CONTROL
	// =========================================================================

	function initSegmented() {
		delegate("click", "[data-pw-segment]", function () {
			const value = this.getAttribute("data-pw-segment");
			const control = this.closest("[data-pw-segmented]");
			if (!control) return;

			control.querySelectorAll("[data-pw-segment]").forEach(function (btn) {
				btn.classList.remove("pw-bui-segmented__btn--active");
				btn.setAttribute("aria-selected", "false");
			});

			this.classList.add("pw-bui-segmented__btn--active");
			this.setAttribute("aria-selected", "true");

			// Update hidden input if present
			const input = control.querySelector('input[type="hidden"]');
			if (input) input.value = value;

			document.dispatchEvent(
				new CustomEvent("pw-bui:segment-changed", {
					detail: {
						name: control.getAttribute("data-pw-segmented"),
						value: value,
					},
				}),
			);
		});
	}

	// =========================================================================
	// TOGGLE SWITCH
	// =========================================================================

	function initToggles() {
		delegate("click", ".pw-bui-toggle", function () {
			if (this.hasAttribute("disabled")) return;

			const isChecked = this.getAttribute("aria-checked") === "true";
			const newState = !isChecked;
			const name = this.getAttribute("data-name");
			const value = this.getAttribute("data-value");

			this.setAttribute("aria-checked", String(newState));

			// Update hidden input
			const input = this.closest(".pw-bui-toggle-wrap")
				? this.closest(".pw-bui-toggle-wrap").querySelector(
						'input[type="hidden"]',
					)
				: this.parentElement.querySelector('input[name="' + name + '"]');

			if (input) input.value = newState ? value || "1" : "";

			document.dispatchEvent(
				new CustomEvent("pw-bui:toggle-changed", {
					detail: { name: name, checked: newState, value: value },
				}),
			);
		});
	}

	// =========================================================================
	// DISMISSIBLE NOTICES
	// =========================================================================

	function initDismissible() {
		delegate("click", ".pw-bui-notice__dismiss", function () {
			const notice = this.closest("[data-pw-dismissible]");
			if (!notice) return;

			notice.classList.add("pw-bui-dismissing");
			setTimeout(function () {
				notice.remove();
			}, 220);
		});
	}

	// =========================================================================
	// TOOLTIP (keyboard / focus fallback — hover handled by CSS)
	// =========================================================================

	function initTooltips() {
		delegate("focusin", "[data-pw-tooltip]", function () {
			let tip = this.querySelector(".pw-bui-tooltip");
			if (!tip) {
				tip = document.createElement("span");
				tip.className = "pw-bui-tooltip";
				tip.textContent = this.getAttribute("data-pw-tooltip");
				this.appendChild(tip);
			}
			tip.classList.add("pw-bui-tooltip--visible");
		});

		delegate("focusout", "[data-pw-tooltip]", function () {
			const tip = this.querySelector(".pw-bui-tooltip");
			if (tip) tip.classList.remove("pw-bui-tooltip--visible");
		});
	}

	// =========================================================================
	// INIT
	// =========================================================================

	function init() {
		initTheme();
		initTabs();
		initSegmented();
		initToggles();
		initDismissible();
		initTooltips();

		document.dispatchEvent(new CustomEvent("pw-bui:ready"));
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", init);
	} else {
		init();
	}
})();
