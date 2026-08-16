<?php
/**
 * Confianza Dental · Theme bootstrap.
 *
 * This file is intentionally slim: it only defines the version constant and
 * loads the modular pieces under `inc/`. All logic lives in those modules,
 * grouped by concern and ordered: dependencies → constants → readers →
 * renderers → handlers → hook registration.
 *
 * Modules loaded (in dependency order):
 *   1. settings-data.php   defaults + getters + sanitizers (foundation)
 *   2. url-helpers.php     URL normalization, WhatsApp, buttons
 *   3. features.php        Free feature registry
 *   5. render.php          cards, intros, FAQ, breadcrumbs, badges, map
 *   6. navigation.php      primary nav, footer nav, logo
 *   7. post-types.php      CPT registration + metaboxes + save handler
 *   8. customizer.php      Customizer panels, sections, fields, register
 *   9. contact-form.php    native contact form + handler
 *  11. query-filters.php   query args builder + main query filters
 *  12. block-patterns.php  editor block patterns
 *  12. setup.php           theme supports, assets, head injections
 *
 * @package ConfianzaDental
 * @author  Mauricio Soto
 * @license GPL-3.0-or-later
 */

if (! defined('ABSPATH')) {
    exit;
}

define('ZENDENT_VERSION', '1.1.3');

// ── MODULE LOADER ─────────────────────────────────────────────
$zendent_modules = [
    'settings-data.php',
    'url-helpers.php',
    'features.php',
    'render.php',
    'navigation.php',
    'post-types.php',
    'customizer.php',
    'contact-form.php',
    'query-filters.php',
    'block-patterns.php',
    'setup.php',
];

foreach ($zendent_modules as $zendent_module) {
    require_once get_template_directory() . '/inc/' . $zendent_module;
}
