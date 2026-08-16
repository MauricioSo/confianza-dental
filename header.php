<?php

if (! defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a href="#main-content" class="skip-link"><?php esc_html_e('Saltar al contenido principal', 'zendent'); ?></a>
<div class="site-shell">
    <header class="site-header">
        <div class="container site-header__inner">
            <?php echo zendent_render_site_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="site-nav">
                <span class="screen-reader-text"><?php esc_html_e('Abrir menu', 'zendent'); ?></span>
                <svg width="22" height="16" viewBox="0 0 22 16" fill="none" aria-hidden="true">
                    <rect width="22" height="2" rx="1" fill="currentColor"></rect>
                    <rect y="7" width="22" height="2" rx="1" fill="currentColor"></rect>
                    <rect y="14" width="22" height="2" rx="1" fill="currentColor"></rect>
                </svg>
            </button>
            <nav id="site-nav" class="site-nav" data-nav>
                <?php zendent_render_primary_nav(); ?>
                <?php echo zendent_render_button(zendent_get_option('primary_cta_label'), zendent_get_option('primary_cta_url')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </nav>
        </div>
    </header>
    <main id="main-content">
