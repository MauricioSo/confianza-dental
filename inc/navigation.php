<?php
/**
 * Navigation helpers: primary menu, footer menu, site logo.
 *
 * Each helper renders a fallback when no menu or logo is assigned in the
 * admin, so the theme works out of the box without manual setup.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── PRIMARY NAV ───────────────────────────────────────────────

/**
 * Renders the primary site navigation.
 *
 * Uses the `primary` menu location when assigned; otherwise falls back to a
 * canonical FREE link list.
 */
function zendent_render_primary_nav(): void
{
    if (has_nav_menu('primary')) {
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'site-nav__menu',
        ]);
        return;
    }

    echo '<ul class="site-nav__menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">Inicio</a></li>';
    echo '<li><a href="' . esc_url(get_post_type_archive_link('tratamiento')) . '">Tratamientos</a></li>';
    echo '<li><a href="' . esc_url(get_post_type_archive_link('profesional')) . '">Profesionales</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contacto/')) . '">Contacto</a></li>';
    echo '</ul>';
}

// ── FOOTER NAV ────────────────────────────────────────────────

/**
 * Renders the footer navigation.
 *
 * Same FREE link list as the primary nav.
 */
function zendent_render_footer_nav(): void
{
    if (has_nav_menu('footer')) {
        wp_nav_menu([
            'theme_location' => 'footer',
            'container'      => false,
            'menu_class'     => 'footer-nav',
        ]);
        return;
    }

    echo '<div class="footer-nav">';
    echo '<a href="' . esc_url(home_url('/')) . '">Inicio</a>';
    echo '<a href="' . esc_url(get_post_type_archive_link('tratamiento')) . '">Tratamientos</a>';
    echo '<a href="' . esc_url(get_post_type_archive_link('profesional')) . '">Profesionales</a>';
    echo '<a href="' . esc_url(home_url('/contacto/')) . '">Contacto</a>';
    echo '</div>';
}

// ── SITE LOGO ─────────────────────────────────────────────────

/**
 * Returns the site logo HTML.
 *
 * Uses the WordPress custom logo when assigned; otherwise renders a
 * text-based brand link with a heart glyph.
 *
 * @return string Logo HTML (caller must echo).
 */
function zendent_render_site_logo(): string
{
    if (has_custom_logo()) {
        return get_custom_logo();
    }

    $name = zendent_get_option('clinic_name', get_bloginfo('name'));

    return '<a class="brand" href="' . esc_url(home_url('/')) . '"><span class="brand-mark" aria-hidden="true">&#10084;</span><span class="brand-copy"><span class="brand-text">' . esc_html($name) . '</span><span class="brand-claim">' . esc_html(zendent_get_option('clinic_claim')) . '</span></span></a>';
}
