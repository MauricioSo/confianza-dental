<?php
/**
 * Free feature registry for the public Confianza Dental theme.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

function zendent_feature_registry(): array
{
    return [
        'treatments',
        'professionals',
        'basic_testimonials',
        'basic_faq',
        'contact_form',
        'whatsapp_basic',
        'basic_hero',
        'basic_trust_block',
        'map_basic',
        'seo_basic',
        'clinic_page',
        'contact_page',
        'not_found_helper',
    ];
}

function zendent_has_feature(string $feature): bool
{
    return in_array($feature, zendent_feature_registry(), true);
}

function zendent_get_active_tier(): string
{
    return 'free';
}

function zendent_features_by_tier(): array
{
    return ['free' => zendent_feature_registry()];
}
