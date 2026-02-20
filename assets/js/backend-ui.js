// assets/js/backend-ui.js

/**
 * pw/backend-ui — Interactive behaviors for the design system.
 *
 * Handles:
 *   - Tab navigation (click + keyboard)
 *   - Toggle switch state
 *   - Dismissible notices
 *
 * No dependencies. Vanilla JS. Scoped to #pw-backend-ui-app.
 */

( function () {
    'use strict';

    const SCOPE = '#pw-backend-ui-app';

    // =========================================================================
    // HELPERS
    // =========================================================================

    /**
     * Safe querySelectorAll scoped to the design system wrapper.
     *
     * @param {string} selector
     * @returns {Element[]}
     */
    function $$ ( selector ) {
        const root = document.querySelector( SCOPE );
        return root ? Array.from( root.querySelectorAll( selector ) ) : [];
    }

    /**
     * Delegate event listener within scope.
     *
     * @param {string}   event
     * @param {string}   selector
     * @param {Function} handler
     */
    function delegate ( event, selector, handler ) {
        const root = document.querySelector( SCOPE );
        if ( ! root ) return;

        root.addEventListener( event, function ( e ) {
            const target = e.target.closest( selector );
            if ( target && root.contains( target ) ) {
                handler.call( target, e );
            }
        } );
    }

    // =========================================================================
    // TABS
    // =========================================================================

    function initTabs () {
        delegate( 'click', '[data-pw-tab]', function () {
            const slug   = this.getAttribute( 'data-pw-tab' );
            const tabNav = this.closest( '[role="tablist"]' );
            if ( ! tabNav ) return;

            // Deactivate all tabs in the same nav
            tabNav.querySelectorAll( '[data-pw-tab]' ).forEach( function ( tab ) {
                tab.classList.remove( 'pw-border-brand-600', 'pw-text-brand-600' );
                tab.classList.add( 'pw-border-transparent', 'pw-text-surface-500' );
                tab.setAttribute( 'aria-selected', 'false' );
            } );

            // Activate clicked tab
            this.classList.remove( 'pw-border-transparent', 'pw-text-surface-500' );
            this.classList.add( 'pw-border-brand-600', 'pw-text-brand-600' );
            this.setAttribute( 'aria-selected', 'true' );

            // Show/hide panels
            $$( '[data-pw-tab-panel]' ).forEach( function ( panel ) {
                if ( panel.getAttribute( 'data-pw-tab-panel' ) === slug ) {
                    panel.classList.remove( 'pw-hidden' );
                    panel.removeAttribute( 'aria-hidden' );
                } else {
                    panel.classList.add( 'pw-hidden' );
                    panel.setAttribute( 'aria-hidden', 'true' );
                }
            } );

            // Dispatch custom event for plugins to listen to
            document.dispatchEvent( new CustomEvent( 'pw-bui:tab-changed', {
                detail: { slug: slug }
            } ) );
        } );

        // Keyboard navigation (left/right arrows)
        delegate( 'keydown', '[data-pw-tab]', function ( e ) {
            if ( e.key !== 'ArrowLeft' && e.key !== 'ArrowRight' ) return;

            const tabs = Array.from(
                this.closest( '[role="tablist"]' ).querySelectorAll( '[data-pw-tab]' )
            );
            const idx     = tabs.indexOf( this );
            const nextIdx = e.key === 'ArrowRight'
                ? ( idx + 1 ) % tabs.length
                : ( idx - 1 + tabs.length ) % tabs.length;

            tabs[ nextIdx ].focus();
            tabs[ nextIdx ].click();
        } );
    }

    // =========================================================================
    // TOGGLE SWITCH
    // =========================================================================

    function initToggles () {
        delegate( 'click', '.pw-bui-toggle', function () {
            if ( this.hasAttribute( 'disabled' ) ) return;

            const isChecked = this.getAttribute( 'aria-checked' ) === 'true';
            const newState  = ! isChecked;
            const name      = this.getAttribute( 'data-name' );
            const value     = this.getAttribute( 'data-value' );
            const knob      = this.querySelector( 'span' );

            // Update visual state
            this.setAttribute( 'aria-checked', newState.toString() );

            if ( newState ) {
                this.classList.remove( 'pw-bg-surface-200' );
                this.classList.add( 'pw-bg-brand-600' );
                knob.classList.remove( 'pw-translate-x-0' );
                knob.classList.add( 'pw-translate-x-5' );
            } else {
                this.classList.remove( 'pw-bg-brand-600' );
                this.classList.add( 'pw-bg-surface-200' );
                knob.classList.remove( 'pw-translate-x-5' );
                knob.classList.add( 'pw-translate-x-0' );
            }

            // Update hidden input
            var input = this.parentElement.querySelector( 'input[name="' + name + '"]' );
            if ( input ) {
                input.value = newState ? value : '';
            }

            // Dispatch custom event
            document.dispatchEvent( new CustomEvent( 'pw-bui:toggle-changed', {
                detail: { name: name, checked: newState, value: value }
            } ) );
        } );
    }

    // =========================================================================
    // DISMISSIBLE NOTICES
    // =========================================================================

    function initDismissible () {
        delegate( 'click', '.pw-bui-dismiss', function () {
            var notice = this.closest( '[data-pw-dismissible]' );
            if ( ! notice ) return;

            notice.classList.add( 'pw-bui-dismissing' );

            // Remove from DOM after animation
            setTimeout( function () {
                notice.remove();
            }, 200 );
        } );
    }

    // =========================================================================
    // INIT
    // =========================================================================

    function init () {
        initTabs();
        initToggles();
        initDismissible();

        document.dispatchEvent( new CustomEvent( 'pw-bui:ready' ) );
    }

    // Run when DOM is ready
    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', init );
    } else {
        init();
    }

} )();
