<?php
/**
 * Custom Post Types and meta boxes.
 *
 * Registers: tratamiento, profesional, testimonio, faq.
 * Registers meta boxes for each and handles the save_post callback.
 *
 * The public distribution contains only the free content types and fields.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── META READERS ──────────────────────────────────────────────

/**
 * Reads a single post meta value with a default fallback.
 *
 * Treats both empty string and empty array as "missing" so defaults kick in.
 *
 * @param int    $post_id Post ID.
 * @param string $key     Meta key (with leading underscore).
 * @param mixed  $default Returned when meta is missing.
 * @return mixed
 */
function zendent_get_post_meta_value(int $post_id, string $key, $default = '')
{
    $value = get_post_meta($post_id, $key, true);
    if ($value === '' || $value === []) {
        return $default;
    }

    return $value;
}

// ── POST TYPE REGISTRATION ────────────────────────────────────

/**
 * Registers every CPT used by the theme.
 *
 * Hooked on `init`.
 */
function zendent_register_post_types(): void
{
    register_post_type('tratamiento', [
        'labels' => [
            'name'          => __('Treatments', 'zendent'),
            'singular_name' => __('Treatment', 'zendent'),
            'add_new_item'  => __('Add treatment', 'zendent'),
            'edit_item'     => __('Edit treatment', 'zendent'),
        ],
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-plus-alt2',
        'rewrite'       => ['slug' => 'tratamientos'],
        'supports'      => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'show_in_rest'  => true,
    ]);

    register_post_type('profesional', [
        'labels' => [
            'name'          => __('Professionals', 'zendent'),
            'singular_name' => __('Professional', 'zendent'),
            'add_new_item'  => __('Add professional', 'zendent'),
            'edit_item'     => __('Edit professional', 'zendent'),
        ],
        'public'        => true,
        'has_archive'   => true,
        'menu_icon'     => 'dashicons-groups',
        'rewrite'       => ['slug' => 'profesionales'],
        'supports'      => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'show_in_rest'  => true,
    ]);

    register_post_type('testimonio', [
        'labels' => [
            'name'          => __('Testimonials', 'zendent'),
            'singular_name' => __('Testimonial', 'zendent'),
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-format-status',
        'supports'     => ['title', 'editor', 'page-attributes'],
    ]);

    register_post_type('faq', [
        'labels' => [
            'name'          => __('FAQs', 'zendent'),
            'singular_name' => __('FAQ', 'zendent'),
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'menu_icon'    => 'dashicons-editor-help',
        'supports'     => ['title', 'editor', 'page-attributes'],
    ]);
}

// ── META BOX REGISTRATION ─────────────────────────────────────

/**
 * Registers every meta box used by the theme's CPTs.
 */
function zendent_register_meta_boxes(): void
{
    add_meta_box('zendent-treatment-meta',   __('Treatment data', 'zendent'),  'zendent_render_treatment_meta',   'tratamiento', 'normal', 'high');
    add_meta_box('zendent-professional-meta', __('Professional data', 'zendent'), 'zendent_render_professional_meta', 'profesional', 'normal', 'high');
    add_meta_box('zendent-testimonial-meta', __('Testimonial data', 'zendent'), 'zendent_render_testimonial_meta', 'testimonio',  'normal', 'high');
    add_meta_box('zendent-faq-meta',         __('FAQ data', 'zendent'),         'zendent_render_faq_meta',          'faq',         'normal', 'high');
}

// ── META BOX RENDERERS ────────────────────────────────────────

/**
 * Renders a single meta field with label, value, and type-aware input.
 *
 * @param string                $name    Field name attribute.
 * @param string                $label   Visible label.
 * @param string                $type    Input type: text, textarea, checkbox, multiselect, date, number, url.
 * @param mixed                 $value   Current value.
 * @param array<int|string,string> $options Options for select/multiselect.
 */
function zendent_render_meta_field(string $name, string $label, string $type = 'text', $value = '', array $options = []): void
{
    echo '<p><label style="display:block;font-weight:600;margin-bottom:6px">' . esc_html($label) . '</label>';
    if ($type === 'textarea') {
        echo '<textarea style="width:100%;min-height:110px" name="' . esc_attr($name) . '">' . esc_textarea((string) $value) . '</textarea>';
    } elseif ($type === 'checkbox') {
        echo '<label><input type="checkbox" name="' . esc_attr($name) . '" value="1" ' . checked((bool) $value, true, false) . '> ' . esc_html__('Active', 'zendent') . '</label>';
    } elseif ($type === 'multiselect') {
        echo '<select multiple name="' . esc_attr($name) . '[]" style="width:100%;min-height:120px">';
        foreach ($options as $option_value => $option_label) {
            $selected = is_array($value) && in_array((string) $option_value, array_map('strval', $value), true);
            echo '<option value="' . esc_attr((string) $option_value) . '" ' . selected($selected, true, false) . '>' . esc_html($option_label) . '</option>';
        }
        echo '</select>';
    } else {
        echo '<input type="' . esc_attr($type) . '" style="width:100%" name="' . esc_attr($name) . '" value="' . esc_attr((string) $value) . '">';
    }
    echo '</p>';
}

/**
 * Renders the treatment meta box.
 */
function zendent_render_treatment_meta(WP_Post $post): void
{
    wp_nonce_field('zendent_save_meta', 'zendent_meta_nonce');
    zendent_render_meta_field('zendent_duration', 'Approximate duration', 'text', zendent_get_post_meta_value($post->ID, '_zendent_duration'));
    zendent_render_meta_field('zendent_benefits', 'Benefits (one line per item)', 'textarea', zendent_get_post_meta_value($post->ID, '_zendent_benefits'));
    zendent_render_meta_field('zendent_audience', 'Who it is for', 'textarea', zendent_get_post_meta_value($post->ID, '_zendent_audience'));
    zendent_render_meta_field('zendent_additional_block', 'Free additional block', 'textarea', zendent_get_post_meta_value($post->ID, '_zendent_additional_block'));

    zendent_render_meta_field('zendent_visible', 'Visible in listings', 'checkbox', (bool) zendent_get_post_meta_value($post->ID, '_zendent_visible', '1'));
}

/**
 * Renders the professional meta box.
 */
function zendent_render_professional_meta(WP_Post $post): void
{
    wp_nonce_field('zendent_save_meta', 'zendent_meta_nonce');
    zendent_render_meta_field('zendent_specialty', 'Specialty', 'text', zendent_get_post_meta_value($post->ID, '_zendent_specialty'));
    zendent_render_meta_field('zendent_short_bio', 'Short bio', 'textarea', zendent_get_post_meta_value($post->ID, '_zendent_short_bio'));

    zendent_render_meta_field('zendent_visible', 'Visible in listings', 'checkbox', (bool) zendent_get_post_meta_value($post->ID, '_zendent_visible', '1'));
}

/**
 * Renders the testimonial meta box.
 */
function zendent_render_testimonial_meta(WP_Post $post): void
{
    wp_nonce_field('zendent_save_meta', 'zendent_meta_nonce');
    zendent_render_meta_field('zendent_role', 'Optional role', 'text', zendent_get_post_meta_value($post->ID, '_zendent_role'));
    zendent_render_meta_field('zendent_rating', 'Optional rating', 'number', zendent_get_post_meta_value($post->ID, '_zendent_rating'));
}

/**
 * Renders the FAQ meta box.
 */
function zendent_render_faq_meta(WP_Post $post): void
{
    wp_nonce_field('zendent_save_meta', 'zendent_meta_nonce');
}

// ── SAVE HANDLER ──────────────────────────────────────────────

/**
 * Persists meta box values on save_post, with nonce + capability checks.
 *
 * Ignores autosave and unauthorized saves. Sanitizes per field type.
 *
 * @param int $post_id Post ID being saved.
 */
function zendent_handle_meta_box_save(int $post_id): void
{
    if (! isset($_POST['zendent_meta_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['zendent_meta_nonce'])), 'zendent_save_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (! current_user_can('edit_post', $post_id)) {
        return;
    }

    $map = [
        'zendent_duration'                   => '_zendent_duration',
        'zendent_benefits'                   => '_zendent_benefits',
        'zendent_audience'                   => '_zendent_audience',
        'zendent_additional_block'           => '_zendent_additional_block',
        'zendent_specialty'                  => '_zendent_specialty',
        'zendent_short_bio'                  => '_zendent_short_bio',
        'zendent_visible'                    => '_zendent_visible',
        'zendent_role'                       => '_zendent_role',
        'zendent_rating'                     => '_zendent_rating',
    ];

    foreach ($map as $field => $meta_key) {
        // Checkbox fields: '1' when present, '0' otherwise.
        if (in_array($field, ['zendent_visible'], true)) {
            update_post_meta($post_id, $meta_key, isset($_POST[$field]) ? '1' : '0');
            continue;
        }

        // Ignore fields that are not present in the submitted metabox.
        if (! isset($_POST[$field])) {
            continue;
        }

        // Per-field sanitization: textarea fields preserve limited HTML.
        $raw = wp_unslash($_POST[$field]);
        if (in_array($field, ['zendent_benefits', 'zendent_audience', 'zendent_additional_block', 'zendent_short_bio'], true)) {
            update_post_meta($post_id, $meta_key, wp_kses_post($raw));
        } else {
            update_post_meta($post_id, $meta_key, sanitize_text_field($raw));
        }
    }
}

// ── HOOK REGISTRATION ─────────────────────────────────────────
add_action('init', 'zendent_register_post_types');
add_action('add_meta_boxes', 'zendent_register_meta_boxes');
add_action('save_post', 'zendent_handle_meta_box_save');
