<?php
/**
 * Theme setup: theme supports, assets, image sizes, navigation menus.
 *
 * Wired to `after_setup_theme` and `wp_enqueue_scripts`.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── THEME SUPPORTS ────────────────────────────────────────────

/**
 * Registers theme supports, image sizes, and nav menu locations.
 *
 * Hooked on `after_setup_theme`.
 */
function zendent_setup_theme(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
    add_theme_support('custom-logo');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/theme.css');
    load_theme_textdomain('zendent', get_template_directory() . '/languages');

    // Custom image sizes used by cards and hero.
    add_image_size('zendent-card', 600, 400, true);
    add_image_size('zendent-hero', 1200, 800, false);

    register_nav_menus([
        'primary' => __('Menu principal', 'zendent'),
        'footer'  => __('Menu footer', 'zendent'),
    ]);
}

// ── ASSET ENQUEUE ─────────────────────────────────────────────

/**
 * Enqueues the main stylesheet, fonts, and theme script.
 *
 * Hooked on `wp_enqueue_scripts`.
 */
function zendent_enqueue_theme_assets(): void
{
    wp_enqueue_style('zendent-fonts', 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;700&display=swap', [], null);
    wp_enqueue_style('zendent-style', get_template_directory_uri() . '/assets/css/theme.css', ['zendent-fonts'], ZENDENT_VERSION);
    wp_enqueue_script('zendent-script', get_template_directory_uri() . '/assets/js/theme.js', [], ZENDENT_VERSION, ['in_footer' => true, 'strategy' => 'defer']);
}

/**
 * Removes dashicons for anonymous visitors to save ~36 KB on the frontend.
 *
 * Hooked on `wp_enqueue_scripts` at priority 100 (after everything else).
 */
function zendent_strip_dashicons_for_guests(): void
{
    if (! is_user_logged_in()) {
        wp_dequeue_style('dashicons');
    }
}

/**
 * Forces Bookly to load assets only on pages containing its shortcode.
 *
 * Bookly's default 'enqueue' mode loads ~260 KB on every page. Switching to
 * 'print' defers loading until the shortcode is actually rendered.
 *
 * Hooked on `init`. No-op when Bookly is not active.
 */
function zendent_optimize_bookly_assets(): void
{
    if (defined('ABSPATH') && get_option('bookly_gen_link_assets_method') === 'enqueue') {
        update_option('bookly_gen_link_assets_method', 'print');
    }
}

// ── HEAD INJECTIONS ───────────────────────────────────────────

/**
 * Prints preconnect hints for Google Fonts.
 *
 * Hooked on `wp_head` priority 1.
 */
function zendent_print_font_preconnect(): void
{
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}

/**
 * Prints a `<link rel="preload">` for the hero image when on the front page,
 * or for the post thumbnail when on a singular template.
 *
 * Hooked on `wp_head` priority 2.
 */
function zendent_preload_hero_image(): void
{
    if (is_front_page()) {
        $custom = zendent_get_option('hero_primary_image');
        $src = (! $custom || str_contains($custom, 'unsplash.com'))
            ? get_template_directory_uri() . '/assets/images/hero-dentista.avif'
            : $custom;
        echo '<link rel="preload" as="image" href="' . esc_url($src) . '" fetchpriority="high">' . "\n";
        return;
    }

    if (is_singular()) {
        $post_id = get_the_ID();
        if ($post_id && has_post_thumbnail($post_id)) {
            $src = get_the_post_thumbnail_url($post_id, 'large');
            if ($src) {
                echo '<link rel="preload" as="image" href="' . esc_url($src) . '" fetchpriority="high">' . "\n";
            }
        }
    }
}

/**
 * Prints canonical, Open Graph, and Schema.org JSON-LD on the front end.
 *
 * Schema is a `Dentist` entity with the global contact info from settings.
 *
 * Hooked on `wp_head` priority 3.
 */
function zendent_print_head_meta(): void
{
    // Canonical URL.
    $canonical = get_permalink() ?: home_url(add_query_arg([]));
    if (is_front_page()) {
        $canonical = home_url('/');
    }
    echo '<link rel="canonical" href="' . esc_url($canonical) . '">' . "\n";

    // Open Graph metadata.
    $og_title       = wp_get_document_title();
    $og_description = get_bloginfo('description');
    $og_url         = $canonical;
    $og_type        = is_singular() ? 'article' : 'website';
    $og_image       = '';

    if (is_singular() && has_post_thumbnail()) {
        $og_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    } elseif (has_post_thumbnail((int) get_option('page_on_front'))) {
        $og_image = get_the_post_thumbnail_url((int) get_option('page_on_front'), 'large');
    }

    echo '<meta property="og:type" content="' . esc_attr($og_type) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($og_title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($og_description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($og_url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    if ($og_image) {
        echo '<meta property="og:image" content="' . esc_url($og_image) . '">' . "\n";
    }

    // Schema.org JSON-LD — only on front page and pages.
    if (is_front_page() || is_page()) {
        $schema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Dentist',
            'name'        => zendent_get_option('clinic_name', get_bloginfo('name')),
            'url'         => home_url('/'),
            'telephone'   => zendent_get_option('phone_primary'),
            'email'       => zendent_get_option('email'),
            'address'     => [
                '@type'         => 'PostalAddress',
                'streetAddress' => zendent_get_option('address'),
            ],
            'openingHours' => array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) zendent_get_option('schedule'))))),
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
    }
}

/**
 * Injects the brand tokens (colors, fonts, button radius) as a `:root` CSS block.
 *
 * Reads the design settings and produces the runtime custom properties
 * consumed by theme.css.
 *
 * Hooked on `wp_enqueue_scripts` priority 20 (after the stylesheet registers).
 */
function zendent_print_inline_branding(): void
{
    $font_scheme    = zendent_get_option('font_scheme', 'modern');
    $heading_font   = $font_scheme === 'system' ? 'Arial, Helvetica, sans-serif' : '"Bricolage Grotesque", sans-serif';
    $body_font      = $font_scheme === 'system' ? 'Arial, Helvetica, sans-serif' : '"DM Sans", sans-serif';
    $button_radius  = zendent_get_option('button_style') === 'rounded' ? '16px' : '999px';

    $css = ':root{' .
        '--brand-primary:' . sanitize_hex_color(zendent_get_option('brand_primary', '#4A44D4')) . ';' .
        '--brand-secondary:' . sanitize_hex_color(zendent_get_option('brand_secondary', '#7B77E0')) . ';' .
        '--brand-accent:' . sanitize_hex_color(zendent_get_option('brand_accent', '#EEEDFE')) . ';' .
        '--heading-font:' . $heading_font . ';' .
        '--body-font:' . $body_font . ';' .
        '--button-radius:' . $button_radius . ';' .
    '}';

    wp_add_inline_style('zendent-style', $css);
}

/**
 * Adds a body class when animations are disabled (CSS hook).
 *
 * @param array<int, string> $classes Current body classes.
 * @return array<int, string>
 */
function zendent_filter_body_classes(array $classes): array
{
    if (zendent_get_option('enable_animations') !== '1') {
        $classes[] = 'animations-disabled';
    }
    return $classes;
}

// ── HOOK REGISTRATION ─────────────────────────────────────────
add_action('after_setup_theme', 'zendent_setup_theme');
add_action('wp_enqueue_scripts', 'zendent_enqueue_theme_assets');
add_action('wp_enqueue_scripts', 'zendent_strip_dashicons_for_guests', 100);
add_action('init', 'zendent_optimize_bookly_assets');
add_action('wp_head', 'zendent_print_font_preconnect', 1);
add_action('wp_head', 'zendent_preload_hero_image', 2);
add_action('wp_head', 'zendent_print_head_meta', 3);
add_action('wp_enqueue_scripts', 'zendent_print_inline_branding', 20);
add_filter('body_class', 'zendent_filter_body_classes');
