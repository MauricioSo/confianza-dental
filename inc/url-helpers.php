<?php
/**
 * URL and button helpers.
 *
 * All URL normalization, WhatsApp link building, and CTA button rendering
 * lives here so templates never inline HTML for these primitives.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── URL NORMALIZATION ─────────────────────────────────────────

/**
 * Normalizes a URL the user typed in the Customizer.
 *
 * Rules:
 *   - Empty string becomes '#'.
 *   - Anchors (#contacto), protocols (http, https, tel:, mailto:) are kept.
 *   - Anything else is treated as a site-relative path and converted to home_url().
 *
 * @param string $url Raw URL.
 * @return string Normalized URL.
 */
function zendent_normalize_url(string $url): string
{
    if ($url === '') {
        return '#';
    }

    if (str_starts_with($url, '#') || str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'tel:') || str_starts_with($url, 'mailto:')) {
        return $url;
    }

    return home_url($url);
}

/**
 * Builds a wa.me link with an optional pre-filled message.
 *
 * Strips every non-digit from the configured WhatsApp number, then appends
 * a URL-encoded message. When no message is provided, falls back to the
 * global `whatsapp_cta_text` setting.
 *
 * @param string|null $message Optional pre-fill. Falls back to global setting.
 * @return string Ready-to-use https://wa.me/... link, or '#' when no number is set.
 */
function zendent_build_whatsapp_link(?string $message = null): string
{
    $raw = preg_replace('/\D+/', '', (string) zendent_get_option('whatsapp'));
    if (! $raw) {
        return '#';
    }

    $text = $message ?: zendent_get_option('whatsapp_cta_text', 'Hola, quisiera reservar una evaluacion dental.');

    return 'https://wa.me/' . $raw . '?text=' . rawurlencode($text);
}

// ── RENDERERS ─────────────────────────────────────────────────

/**
 * Renders a CTA button as an anchor element.
 *
 * @param string $label   Visible label. Empty label returns empty string.
 * @param string $url     Target URL (will be normalized via zendent_normalize_url).
 * @param string $variant Visual variant: 'primary' (default), 'secondary', 'ghost', 'white'.
 * @return string HTML anchor element. Empty string when label is empty.
 */
function zendent_render_button(string $label, string $url, string $variant = 'primary'): string
{
    if (! $label) {
        return '';
    }

    $class = 'button';
    if ($variant === 'secondary') {
        $class .= ' button-secondary';
    } elseif ($variant === 'ghost') {
        $class .= ' button-ghost';
    } elseif ($variant === 'white') {
        $class .= ' button-white';
    }

    $url   = esc_url(zendent_normalize_url($url));
    $label = esc_html($label);

    // Primary and white variants show an arrow icon inside the button.
    if ($variant === 'primary' || $variant === 'white') {
        return '<a class="' . esc_attr($class) . '" href="' . $url . '"><span>' . $label . '</span><span class="button-arrow" aria-hidden="true">&#8599;</span></a>';
    }

    return '<a class="' . esc_attr($class) . '" href="' . $url . '">' . $label . '</a>';
}
