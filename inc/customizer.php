<?php
/**
 * Customizer integration: panels, sections, fields, and registration.
 *
 * Organizes every theme option into 5 panels (general → particular):
 *   1. Sistema de diseño global
 *   2. Datos globales
 *   3. Páginas
 *   4. Componentes
 *   5. Textos globales
 *
 * This public distribution registers only FREE controls.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── PANEL DEFINITIONS ─────────────────────────────────────────

/**
 * Returns the 5-panel hierarchy used by the Customizer.
 *
 * @return array<string, array{title:string, priority:int, description:string}>
 */
function zendent_get_customizer_panels(): array
{
    return [
        'zendent_design_panel' => [
            'title'       => 'Sistema de diseno global',
            'priority'    => 20,
            'description' => 'Define la base visual del sitio antes de personalizar cada pagina.',
        ],
        'zendent_global_data_panel' => [
            'title'       => 'Datos globales',
            'priority'    => 21,
            'description' => 'Centraliza los datos de contacto, ubicacion y canales que se repiten en todo el sitio.',
        ],
        'zendent_pages_panel' => [
            'title'       => 'Paginas',
            'priority'    => 22,
            'description' => 'Edita el contenido principal pagina por pagina, de la portada a las paginas internas.',
        ],
        'zendent_components_panel' => [
            'title'       => 'Componentes',
            'priority'    => 23,
            'description' => 'Configura bloques reutilizables para mantener consistencia y acelerar ajustes.',
        ],
        'zendent_texts_panel' => [
            'title'       => 'Textos globales',
            'priority'    => 24,
            'description' => 'Agrupa etiquetas, mensajes y textos reutilizables que no pertenecen a una sola pagina.',
        ],
    ];
}

// ── SECTION DEFINITIONS ───────────────────────────────────────

/**
 * Returns the section map for the Customizer.
 *
 * Each entry binds a section to a panel, gives it a title/description, and
 * lists the field keys it owns.
 *
 * @return array<string, array{panel:string, title:string, priority:int, description:string, fields:array<int, string>}>
 */
function zendent_get_customizer_sections(): array
{
    return [
        'design_style' => [
            'panel'       => 'zendent_design_panel',
            'title'       => 'Marca y estilo',
            'priority'    => 10,
            'description' => 'Ajusta nombre comercial, claim, tipografia, colores y estilo visual del tema.',
            'fields'      => ['clinic_name', 'clinic_claim', 'font_scheme', 'button_style', 'enable_animations', 'brand_primary', 'brand_secondary', 'brand_accent'],
        ],
        'global_contact' => [
            'panel'       => 'zendent_global_data_panel',
            'title'       => 'Contacto principal',
            'priority'    => 10,
            'description' => 'Estos datos alimentan botones, fichas de contacto y bloques visibles en todo el sitio.',
            'fields'      => ['phone_primary', 'phone_secondary', 'whatsapp', 'email', 'address', 'schedule'],
        ],
        'global_channels' => [
            'panel'       => 'zendent_global_data_panel',
            'title'       => 'Redes y ubicacion',
            'priority'    => 20,
            'description' => 'Configura redes sociales y el enlace general de Google Maps para el sitio.',
            'fields'      => ['instagram', 'facebook', 'tiktok', 'google_maps_url'],
        ],
        'page_home' => [
            'panel'       => 'zendent_pages_panel',
            'title'       => 'Inicio',
            'priority'    => 10,
            'description' => 'Personaliza el hero y la estructura principal de la portada.',
            'fields'      => ['home_eyebrow', 'home_title', 'home_subtitle', 'home_primary_cta_label', 'home_primary_cta_url', 'home_secondary_cta_label', 'home_secondary_cta_url', 'home_trust_text', 'home_featured_treatments_eyebrow', 'home_featured_professionals_eyebrow'],
        ],
        'page_home_images' => [
            'panel'       => 'zendent_pages_panel',
            'title'       => 'Inicio: imagenes',
            'priority'    => 20,
            'description' => 'Administra las imagenes que sostienen el hero y el bloque visual de la portada.',
            'fields'      => ['hero_primary_image', 'hero_secondary_image'],
        ],
        'page_contact' => [
            'panel'       => 'zendent_pages_panel',
            'title'       => 'Contacto y reserva',
            'priority'    => 30,
            'description' => 'Controla la pagina de contacto, el formulario, la reserva y el bloque de mapa.',
            'fields'      => ['contact_title', 'contact_subtitle', 'contact_page_eyebrow', 'contact_eyebrow', 'contact_form_title', 'contact_form_text', 'contact_form_name_label', 'contact_form_email_label', 'contact_form_phone_label', 'contact_form_message_label', 'contact_form_submit_label', 'contact_form_success_message', 'contact_form_error_message', 'contact_form_required_message', 'contact_help_text', 'map_title', 'map_text', 'map_embed', 'label_phone', 'label_whatsapp', 'label_email', 'label_address', 'label_schedule', 'contact_sidebar_title'],
        ],
        'page_clinic' => [
            'panel'       => 'zendent_pages_panel',
            'title'       => 'Clinica',
            'priority'    => 40,
            'description' => 'Edita la narrativa institucional, las imagenes y el CTA de la pagina Clinica.',
            'fields'      => ['clinic_eyebrow', 'clinic_subtitle', 'clinic_intro', 'clinic_values_title', 'clinic_value_1', 'clinic_value_2', 'clinic_value_3', 'clinic_value_4', 'clinic_image_1', 'clinic_image_2', 'clinic_image_3', 'clinic_cta_title', 'clinic_cta_text', 'clinic_cta_label', 'clinic_cta_url', 'clinic_sidebar_title'],
        ],
        'page_treatments' => [
            'panel'       => 'zendent_pages_panel',
            'title'       => 'Tratamientos',
            'priority'    => 50,
            'description' => 'Ajusta el hero, la introduccion y el CTA del archivo de tratamientos.',
            'fields'      => ['treatments_title', 'treatments_subtitle', 'treatments_intro'],
        ],
        'page_professionals' => [
            'panel'       => 'zendent_pages_panel',
            'title'       => 'Profesionales',
            'priority'    => 60,
            'description' => 'Define como se presenta el equipo y el CTA del archivo de profesionales.',
            'fields'      => ['professionals_title', 'professionals_subtitle', 'professionals_intro'],
        ],
        'component_trust' => [
            'panel'       => 'zendent_components_panel',
            'title'       => 'Bloque de confianza',
            'priority'    => 10,
            'description' => 'Agrupa badges, certificaciones, imagen principal y estadisticas de confianza.',
            'fields'      => ['trust_image', 'trust_eyebrow', 'trust_title', 'trust_text', 'trust_cta_label', 'trust_cta_url', 'trust_badge_1', 'trust_badge_2', 'trust_badge_3', 'trust_badge_4'],
        ],
        'component_testimonials_faq' => [
            'panel'       => 'zendent_components_panel',
            'title'       => 'Testimonios y FAQ',
            'priority'    => 20,
            'description' => 'Edita los encabezados de estos bloques reutilizables en portada y plantillas.',
            'fields'      => ['testimonials_eyebrow', 'testimonials_title', 'testimonials_text', 'faq_eyebrow', 'faq_title', 'faq_text'],
        ],
        'component_final_cta' => [
            'panel'       => 'zendent_components_panel',
            'title'       => 'CTA final',
            'priority'    => 30,
            'description' => 'Configura el cierre comercial del sitio con titulo, texto y dos llamados a la accion.',
            'fields'      => ['final_cta_eyebrow', 'final_cta_title', 'final_cta_text', 'final_cta_primary_label', 'final_cta_primary_url', 'final_cta_secondary_label', 'final_cta_secondary_url'],
        ],
        'text_global_ctas' => [
            'panel'       => 'zendent_texts_panel',
            'title'       => 'CTAs y mensajes globales',
            'priority'    => 10,
            'description' => 'Usa esta seccion para botones globales y mensajes breves que aparecen en distintos lugares.',
            'fields'      => ['primary_cta_label', 'primary_cta_url', 'secondary_cta_label', 'secondary_cta_url', 'whatsapp_cta_text', 'contact_short_message', 'footer_text'],
        ],
        'text_templates' => [
            'panel'       => 'zendent_texts_panel',
            'title'       => 'Textos de plantillas',
            'priority'    => 20,
            'description' => 'Reune textos tecnicos y etiquetas reutilizadas en singles, sidebars, tarjetas y 404.',
            'fields'      => ['generic_page_eyebrow', 'generic_sidebar_title', 'single_treatment_eyebrow', 'single_treatment_benefits_title', 'single_treatment_audience_title', 'single_treatment_additional_title', 'single_treatment_summary_title', 'single_treatment_duration_label', 'single_treatment_duration_fallback', 'single_treatment_contact_label', 'single_treatment_faq_eyebrow', 'single_treatment_faq_title', 'single_professional_default_specialty', 'single_professional_default_specialty_long', 'single_professional_cta_fallback', 'single_professional_profile_title', 'single_professional_specialty_label', 'single_professional_phone_label', 'single_professional_whatsapp_label', 'card_treatment_label', 'card_treatment_link_label', 'card_professional_link_label', 'index_detail_link_label', 'not_found_title', 'not_found_text', 'not_found_primary_text', 'not_found_primary_url', 'not_found_secondary_text', 'not_found_secondary_url'],
        ],
    ];
}

// ── FIELD METADATA ────────────────────────────────────────────

/**
 * Returns the WP control type for a Customizer field key.
 *
 * Type is decided by hardcoded field lists (image, color, url, textarea, etc.).
 * Unknown fields fall back to 'text'.
 *
 * @param string $field Field key.
 * @return string Control type slug.
 */
function zendent_get_customizer_control_type(string $field): string
{
    if (in_array($field, ['clinic_image_1', 'clinic_image_2', 'clinic_image_3', 'hero_primary_image', 'hero_secondary_image', 'trust_image'], true)) {
        return 'image';
    }

    if (in_array($field, ['brand_primary', 'brand_secondary', 'brand_accent'], true)) {
        return 'color';
    }

    if (in_array($field, ['instagram', 'facebook', 'tiktok', 'google_maps_url', 'primary_cta_url', 'secondary_cta_url', 'home_primary_cta_url', 'home_secondary_cta_url', 'trust_cta_url', 'final_cta_primary_url', 'final_cta_secondary_url', 'clinic_cta_url', 'not_found_primary_url', 'not_found_secondary_url'], true)) {
        return 'url';
    }

    if (in_array($field, ['schedule', 'contact_form_text', 'contact_help_text', 'footer_text', 'home_subtitle', 'home_trust_text', 'treatments_subtitle', 'treatments_intro', 'professionals_subtitle', 'professionals_intro', 'contact_subtitle', 'trust_text', 'final_cta_text', 'clinic_cta_text', 'clinic_subtitle', 'clinic_intro', 'testimonials_text', 'faq_text', 'not_found_text', 'map_text', 'map_embed'], true)) {
        return 'textarea';
    }

    if (in_array($field, ['font_scheme', 'button_style'], true)) {
        return 'select';
    }

    if ($field === 'enable_animations') {
        return 'checkbox';
    }

    return 'text';
}

/**
 * Returns the sanitize callback name for a Customizer field key.
 *
 * @param string $field Field key.
 * @return string Callable name (function name as string).
 */
function zendent_get_customizer_sanitize_callback(string $field): string
{
    if ($field === 'enable_animations') {
        return 'zendent_sanitize_checkbox';
    }

    if (in_array($field, ['clinic_image_1', 'clinic_image_2', 'clinic_image_3', 'hero_primary_image', 'hero_secondary_image', 'trust_image'], true)) {
        return 'esc_url_raw';
    }

    if (in_array($field, ['brand_primary', 'brand_secondary', 'brand_accent'], true)) {
        return 'sanitize_hex_color';
    }

    if (in_array($field, ['instagram', 'facebook', 'tiktok', 'google_maps_url', 'primary_cta_url', 'secondary_cta_url', 'home_primary_cta_url', 'home_secondary_cta_url', 'trust_cta_url', 'final_cta_primary_url', 'final_cta_secondary_url', 'clinic_cta_url', 'not_found_primary_url', 'not_found_secondary_url'], true)) {
        return 'esc_url_raw';
    }

    if ($field === 'map_embed') {
        return 'zendent_sanitize_embed';
    }

    if (in_array($field, ['schedule', 'contact_form_text', 'contact_help_text', 'footer_text', 'home_subtitle', 'home_trust_text', 'treatments_subtitle', 'treatments_intro', 'professionals_subtitle', 'professionals_intro', 'contact_subtitle', 'trust_text', 'final_cta_text', 'clinic_cta_text', 'clinic_subtitle', 'clinic_intro', 'testimonials_text', 'faq_text', 'not_found_text', 'map_text'], true)) {
        return 'zendent_sanitize_textarea';
    }

    return 'sanitize_text_field';
}

// ── FIELD LABELS ──────────────────────────────────────────────

/**
 * Returns a human-readable label for a field key, used in both Customizer
 * and the admin settings page.
 *
 * @param string $key Field key.
 * @return string Label (falls back to title-cased key).
 */
function zendent_get_field_label(string $key): string
{
    $labels = [
        'clinic_name' => 'Nombre de la clinica',
        'clinic_claim' => 'Claim o bajada',
        'phone_primary' => 'Telefono principal',
        'phone_secondary' => 'Telefono secundario',
        'whatsapp' => 'WhatsApp',
        'email' => 'Email',
        'address' => 'Direccion',
        'schedule' => 'Horario',
        'instagram' => 'Instagram',
        'facebook' => 'Facebook',
        'tiktok' => 'TikTok',
        'google_maps_url' => 'Enlace Google Maps',
        'primary_cta_label' => 'CTA principal',
        'primary_cta_url' => 'URL CTA principal',
        'secondary_cta_label' => 'CTA secundario',
        'secondary_cta_url' => 'URL CTA secundario',
        'whatsapp_cta_text' => 'Texto de WhatsApp',
        'contact_short_message' => 'Mensaje corto de contacto',
        'footer_text' => 'Texto del footer',
        'home_title' => 'Titulo de inicio',
        'home_subtitle' => 'Subtitulo de inicio',
        'home_eyebrow' => 'Eyebrow de inicio',
        'home_primary_cta_label' => 'Boton principal home',
        'home_primary_cta_url' => 'URL boton principal home',
        'home_secondary_cta_label' => 'Boton secundario home',
        'home_secondary_cta_url' => 'URL boton secundario home',
        'home_trust_text' => 'Texto de confianza home',
        'hero_primary_image' => 'Imagen principal hero',
        'hero_secondary_image' => 'Imagen secundaria hero',
        'treatments_title' => 'Titulo pagina tratamientos',
        'treatments_subtitle' => 'Subtitulo pagina tratamientos',
        'professionals_title' => 'Titulo pagina profesionales',
        'professionals_subtitle' => 'Subtitulo pagina profesionales',
        'contact_title' => 'Titulo pagina contacto',
        'contact_subtitle' => 'Subtitulo pagina contacto',
        'contact_help_text' => 'Texto de ayuda contacto',
        'map_embed' => 'Embed de mapa',
        'brand_primary' => 'Color principal',
        'brand_secondary' => 'Color secundario',
        'brand_accent' => 'Color de acento',
        'font_scheme' => 'Tipografia',
        'button_style' => 'Estilo de botones',
        'trust_eyebrow' => 'Eyebrow confianza',
        'trust_title' => 'Titulo confianza',
        'trust_text' => 'Texto confianza',
        'trust_cta_label' => 'Boton confianza',
        'trust_cta_url' => 'URL boton confianza',
        'final_cta_eyebrow' => 'Eyebrow CTA final',
        'final_cta_title' => 'Titulo CTA final',
        'final_cta_text' => 'Texto CTA final',
        'final_cta_primary_label' => 'Boton principal CTA final',
        'final_cta_primary_url' => 'URL boton principal CTA final',
        'final_cta_secondary_label' => 'Boton secundario CTA final',
        'final_cta_secondary_url' => 'URL boton secundario CTA final',
        'clinic_cta_title' => 'Titulo CTA clinica',
        'clinic_cta_text' => 'Texto CTA clinica',
        'clinic_cta_label' => 'Boton CTA clinica',
        'clinic_cta_url' => 'URL CTA clinica',
    ];

    return $labels[$key] ?? ucwords(str_replace('_', ' ', $key));
}

// ── REGISTRATION ──────────────────────────────────────────────

/**
 * Registers every panel, section, setting, and control with WP_Customize_Manager.
 *
 * Also relocates native sections (title_tagline, static_front_page) into the
 * theme's panel hierarchy so the editor sees one coherent structure.
 *
 * The public distribution exposes only the free theme controls.
 */
function zendent_register_customizer(WP_Customize_Manager $wp_customize): void
{
    foreach (zendent_get_customizer_panels() as $panel_id => $panel) {
        $wp_customize->add_panel($panel_id, [
            'title'       => __($panel['title'], 'zendent'),
            'priority'    => $panel['priority'],
            'description' => __($panel['description'], 'zendent'),
        ]);
    }

    // Relocate native "title_tagline" into the design panel for coherence.
    $title_tagline = $wp_customize->get_section('title_tagline');
    if ($title_tagline instanceof WP_Customize_Section) {
        $title_tagline->title       = __('Logo y favicon', 'zendent');
        $title_tagline->description = __('Administra el logo, nombre del sitio, descripcion corta e icono del navegador.', 'zendent');
        $title_tagline->panel       = 'zendent_design_panel';
        $title_tagline->priority    = 5;
    }

    // Relabel the nav_menus panel without moving it.
    $nav_menus = $wp_customize->get_panel('nav_menus');
    if ($nav_menus instanceof WP_Customize_Panel) {
        $nav_menus->title       = __('Menus', 'zendent');
        $nav_menus->description = __('Organiza los enlaces principales y del footer desde un lugar separado del contenido visual.', 'zendent');
        $nav_menus->priority    = 30;
    }

    // Relocate native "static_front_page" into the pages panel.
    $static_front_page = $wp_customize->get_section('static_front_page');
    if ($static_front_page instanceof WP_Customize_Section) {
        $static_front_page->title       = __('Portada y blog', 'zendent');
        $static_front_page->description = __('Elige que pagina actua como portada y cual muestra las entradas del blog.', 'zendent');
        $static_front_page->panel       = 'zendent_pages_panel';
        $static_front_page->priority    = 5;
    }

    foreach (zendent_get_customizer_sections() as $slug => $section) {
        $section_id = 'zendent_' . $slug;

        $wp_customize->add_section($section_id, [
            'title'       => __($section['title'], 'zendent'),
            'panel'       => $section['panel'],
            'priority'    => $section['priority'],
            'description' => __($section['description'], 'zendent'),
        ]);

        foreach ($section['fields'] as $field) {
            $setting_id     = 'zendent_' . $field;
            $default        = zendent_get_default_settings()[$field] ?? '';
            $type           = zendent_get_customizer_control_type($field);
            $description_parts = [];

            $control_args = [
                'label'       => zendent_get_field_label($field),
                'section'     => $section_id,
                'type'        => $type,
                'description' => implode(' · ', $description_parts),
            ];

            $wp_customize->add_setting($setting_id, [
                'default'           => $default,
                'type'              => 'theme_mod',
                'sanitize_callback' => zendent_get_customizer_sanitize_callback($field),
                'transport'         => 'refresh',
            ]);

            // Color and image controls need their dedicated classes.
            if ($type === 'color') {
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $setting_id, [
                    'label'       => zendent_get_field_label($field),
                    'section'     => $section_id,
                    'settings'    => $setting_id,
                    'description' => $control_args['description'],
                ]));
                continue;
            }

            if ($type === 'image') {
                $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $setting_id, [
                    'label'       => zendent_get_field_label($field),
                    'section'     => $section_id,
                    'settings'    => $setting_id,
                    'description' => $control_args['description'],
                ]));
                continue;
            }

            if ($type === 'select') {
                $choices = $field === 'font_scheme'
                    ? ['modern' => 'Bricolage + DM Sans', 'system' => 'Sistema']
                    : ['pill' => 'Pill', 'rounded' => 'Rounded'];

                $wp_customize->add_control($setting_id, [
                    'label'       => $control_args['label'],
                    'section'     => $control_args['section'],
                    'type'        => 'select',
                    'choices'     => $choices,
                    'description' => $control_args['description'],
                ]);
                continue;
            }

            if ($type === 'checkbox') {
                $wp_customize->add_control($setting_id, [
                    'label'       => $control_args['label'],
                    'section'     => $control_args['section'],
                    'type'        => 'checkbox',
                    'description' => $control_args['description'],
                ]);
                continue;
            }

            $wp_customize->add_control($setting_id, $control_args);
        }
    }
}

// ── HOOK REGISTRATION ─────────────────────────────────────────
add_action('customize_register', 'zendent_register_customizer');
