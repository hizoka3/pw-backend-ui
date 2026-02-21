// assets/js/backend-ui.js

/**
 * pw/backend-ui — Interactive behaviors for the PW Design System.
 *
 * Handles:
 *   - Theme toggle (dark / light) with localStorage persistence
 *   - Tab navigation (click + keyboard)
 *   - Toggle switch state
 *   - Segmented control
 *   - Dismissible notices / banners
 *   - Tooltip (CSS-driven, JS for dynamic positioning)
 *
 * No dependencies. Vanilla JS. Scoped to #pw-backend-ui-app.
 */

(function () {
	"use strict";

	const SCOPE = "#pw-backend-ui-app";
	const STORAGE_KEY = "pw-bui-theme";
	const DARK_CLASS = "dark";
	const ATTR_THEME = "data-pw-theme";

	// =========================================================================
	// HELPERS
	// =========================================================================

	function scope() {
		return document.querySelector(SCOPE);
	}

	function $$(selector) {
		const root = scope();
		return root ? Array.from(root.querySelectorAll(selector)) : [];
	}

	function delegate(event, selector, handler) {
		const root = scope();
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
			return localStorage.getItem(STORAGE_KEY) || "dark";
		} catch (e) {
			return "dark";
		}
	}

	function setTheme(theme) {
		const root = scope();
		if (!root) return;

		root.setAttribute(ATTR_THEME, theme);

		try {
			localStorage.setItem(STORAGE_KEY, theme);
		} catch (e) {
			/* ignore */
		}

		// Update toggle icon + aria-label
		const toggleBtn = root.querySelector("[data-pw-theme-toggle]");
		if (toggleBtn) {
			toggleBtn.setAttribute(
				"aria-label",
				theme === "dark" ? "Switch to light mode" : "Switch to dark mode",
			);
			toggleBtn.setAttribute(
				"title",
				theme === "dark" ? "Light mode" : "Dark mode",
			);

			const iconDark = toggleBtn.querySelector(".pw-bui-icon-moon");
			const iconLight = toggleBtn.querySelector(".pw-bui-icon-sun");

			if (iconDark) iconDark.style.display = theme === "dark" ? "none" : "";
			if (iconLight) iconLight.style.display = theme === "light" ? "none" : "";
		}

		document.dispatchEvent(
			new CustomEvent("pw-bui:theme-changed", {
				detail: { theme },
			}),
		);
	}

	function applyInitialTheme() {
		const root = scope();
		if (!root) return;

		const saved = getTheme();
		// If theme was already set server-side via data-pw-theme attr, respect it on first load.
		// Otherwise apply saved preference.
		const current = root.getAttribute(ATTR_THEME);
		setTheme(current || saved);
	}

	function initThemeToggle() {
		applyInitialTheme();

		delegate("click", "[data-pw-theme-toggle]", function () {
			const root = scope();
			const current = root ? root.getAttribute(ATTR_THEME) : "dark";
			setTheme(current === "dark" ? "light" : "dark");
		});
	}

	// =========================================================================
	// TABS
	// =========================================================================

	function initTabs() {
		delegate("click", "[data-pw-tab]", function (e) {
			e.preventDefault();
			const slug = this.getAttribute("data-pw-tab");
			const tabNav = this.closest('[role="tablist"]');
			if (!tabNav) return;

			tabNav.querySelectorAll("[data-pw-tab]").forEach(function (tab) {
				tab.classList.remove("pw-bui-active");
				tab.setAttribute("aria-selected", "false");
				tab.removeAttribute("tabindex");
			});

			this.classList.add("pw-bui-active");
			this.setAttribute("aria-selected", "true");
			this.setAttribute("tabindex", "0");

			$$("[data-pw-tab-panel]").forEach(function (panel) {
				if (panel.getAttribute("data-pw-tab-panel") === slug) {
					panel.classList.remove("pw-bui-hidden");
					panel.removeAttribute("aria-hidden");
				} else {
					panel.classList.add("pw-bui-hidden");
					panel.setAttribute("aria-hidden", "true");
				}
			});

			document.dispatchEvent(
				new CustomEvent("pw-bui:tab-changed", {
					detail: { slug },
				}),
			);
		});

		// Keyboard: left / right arrows
		delegate("keydown", "[data-pw-tab]", function (e) {
			if (e.key !== "ArrowLeft" && e.key !== "ArrowRight") return;

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
	// TOGGLE SWITCH
	// =========================================================================

	function initToggles() {
		delegate("click", ".pw-bui-toggle-btn", function () {
			if (this.hasAttribute("disabled")) return;

			const isChecked = this.getAttribute("aria-checked") === "true";
			const newState = !isChecked;
			const name = this.getAttribute("data-name");
			const value = this.getAttribute("data-value");

			this.setAttribute("aria-checked", newState.toString());

			const input = this.parentElement.querySelector(
				'input[type="hidden"][name="' + name + '"]',
			);
			if (input) {
				input.value = newState ? value : "";
			}

			document.dispatchEvent(
				new CustomEvent("pw-bui:toggle-changed", {
					detail: { name, checked: newState, value },
				}),
			);
		});
	}

	// =========================================================================
	// SEGMENTED CONTROL
	// =========================================================================

	function initSegmented() {
		delegate("click", ".pw-bui-segmented-item", function () {
			const group = this.closest(".pw-bui-segmented");
			if (!group) return;

			group.querySelectorAll(".pw-bui-segmented-item").forEach(function (item) {
				item.setAttribute("aria-pressed", "false");
			});

			this.setAttribute("aria-pressed", "true");

			const name = group.getAttribute("data-name");
			const value = this.getAttribute("data-value");

			// Update hidden input if present
			const input = group.parentElement
				? group.parentElement.querySelector(
						'input[type="hidden"][name="' + name + '"]',
					)
				: null;
			if (input) input.value = value;

			document.dispatchEvent(
				new CustomEvent("pw-bui:segmented-changed", {
					detail: { name, value },
				}),
			);
		});
	}

	// =========================================================================
	// DISMISSIBLE (notices, banners)
	// =========================================================================

	function initDismissible() {
		delegate("click", ".pw-bui-dismiss, .pw-bui-banner-dismiss", function () {
			const notice = this.closest("[data-pw-dismissible]");
			if (!notice) return;

			notice.classList.add("pw-bui-dismissing");

			setTimeout(function () {
				notice.remove();
			}, 220);
		});
	}

	// =========================================================================
	// INIT
	// =========================================================================

	function init() {
		initThemeToggle();
		initTabs();
		initToggles();
		initSegmented();
		initDismissible();

		document.dispatchEvent(new CustomEvent("pw-bui:ready"));
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", init);
	} else {
		init();
	}
})();
