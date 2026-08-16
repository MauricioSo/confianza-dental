<?php
/**
 * Settings data layer: defaults, getters, and sanitizers.
 *
 * Single source of truth for theme settings. Customizer, settings page,
 * and templates all read through `zendent_get_option()`.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── DEFAULTS ──────────────────────────────────────────────────

/**
 * Default values for every theme setting.
 *
 * Used as fallback when no option or theme_mod is stored. Editing this
 * array is the canonical way to change defaults site-wide.
 *
 * @return array<string, mixed> Map of setting_key => default_value.
 */
function zendent_get_default_settings(): array
{
    return [
        // ── Brand identity / Identidad ─────────────────────────
        'clinic_name'             => get_bloginfo('name') ?: 'Confianza Dental',
        'clinic_claim'            => get_bloginfo('description') ?: 'Atencion dental moderna, clara y confiable.',
        'brand_primary'           => '#4A44D4',
        'brand_secondary'         => '#7B77E0',
        'brand_accent'            => '#EEEDFE',
        'font_scheme'             => 'modern',
        'button_style'            => 'pill',
        'enable_animations'       => '1',

        // ── Global contact / Contacto global ──────────────────
        'phone_primary'           => '+56 9 1234 5678',
        'phone_secondary'         => '',
        'whatsapp'                => '+56912345678',
        'whatsapp_cta_text'       => 'Escribenos por WhatsApp',
        'email'                   => 'contact@example.com',
        'address'                 => 'Av. Salud 245, Ciudad de ejemplo',
        'schedule'                => "Lunes a Viernes: 09:00 a 19:00\nSabado: 09:00 a 13:00",

        // ── Global channels / Canales ─────────────────────────
        'instagram'               => '',
        'facebook'                => '',
        'tiktok'                  => '',
        'google_maps_url'         => '',

        // ── Global CTAs / CTAs globales ───────────────────────
        'primary_cta_label'       => 'Reservar evaluacion',
        'primary_cta_url'         => '#contacto',
        'secondary_cta_label'     => 'Ver tratamientos',
        'secondary_cta_url'       => '/tratamientos/',
        'contact_short_message'   => 'Respondemos rapido y te orientamos segun tu caso.',
        'footer_text'             => 'Web profesional para clinicas dentales. Rapida, clara y facil de mantener.',

        // ── Home / Inicio ─────────────────────────────────────
        'home_eyebrow'            => 'Clinica dental moderna',
        'home_title'              => 'Descubre tu mejor sonrisa con atencion profesional y cercana.',
        'home_subtitle'           => 'Tratamientos modernos, equipo multidisciplinario y una experiencia ordenada para pacientes que buscan confianza real.',
        'home_trust_text'         => 'Mas de 20 anos acompanando a pacientes con tratamientos claros, tecnologia actual y seguimiento responsable.',
        'home_primary_cta_label'  => 'Agendar evaluacion',
        'home_primary_cta_url'    => '#contacto',
        'home_secondary_cta_label' => 'Ver tratamientos',
        'home_secondary_cta_url'  => '/tratamientos/',

        // ── Home assembly / Ensamblaje home ─────────────────
        'home_featured_treatments_eyebrow'                => 'Tratamientos destacados',
        'home_featured_professionals_eyebrow'             => 'Equipo profesional',

        // ── Home images / Imagenes home ──────────────────────
        'hero_primary_image'                              => get_template_directory_uri() . '/assets/images/confianza-dental/hero-primary.png',
        'hero_secondary_image'                            => get_template_directory_uri() . '/assets/images/confianza-dental/hero-secondary.png',

        // ── Treatments archive / Archivo tratamientos ────────
        'treatments_title'        => 'Tratamientos',
        'treatments_subtitle'     => 'Soluciones dentales pensadas para diagnostico claro, tratamiento preciso y seguimiento profesional.',
        'treatments_intro'        => 'Mostramos cada tratamiento con una estructura simple para que el paciente entienda alcance, beneficios y siguiente paso.',

        // ── Professionals archive / Archivo profesionales ─────
        'professionals_title'     => 'Profesionales',
        'professionals_subtitle'  => 'Conoce al equipo que acompana cada etapa del tratamiento con especialidad y cercania.',
        'professionals_intro'     => 'Un equipo claro, visible y ordenado para transmitir confianza desde la primera visita.',
        'empty_state_text'        => 'No hay contenido disponible todavia.',

        // ── Contact page / Contacto ──────────────────────────
        'contact_title'           => 'Contacto y reserva',
        'contact_subtitle'        => 'Elige el canal mas comodo para resolver dudas, pedir evaluacion o coordinar tu visita.',
        'contact_eyebrow'         => 'Contacto rapido',
        'contact_page_eyebrow'    => 'Reserva',
        'contact_help_text'       => 'Si ya tienes una urgencia dental, escribenos por WhatsApp y te orientamos de inmediato.',
        'contact_sidebar_title'   => 'Canales de contacto',
        'label_phone'             => 'Telefono',
        'label_whatsapp'          => 'WhatsApp',
        'label_email'             => 'Email',
        'label_address'           => 'Direccion',
        'label_schedule'          => 'Horario',

        // ── Contact form / Formulario contacto ───────────────
        'contact_form_title'           => 'Envianos tu solicitud',
        'contact_form_text'            => 'Completa el formulario y te contactaremos para orientar tu reserva o resolver tus dudas.',
        'contact_form_name_label'      => 'Nombre',
        'contact_form_email_label'     => 'Email',
        'contact_form_phone_label'     => 'Telefono',
        'contact_form_message_label'   => 'Mensaje',
        'contact_form_submit_label'    => 'Enviar solicitud',
        'contact_form_success_message' => 'Tu mensaje fue enviado correctamente. Te contactaremos pronto.',
        'contact_form_error_message'   => 'No pudimos enviar tu mensaje. Intenta nuevamente en unos minutos.',
        'contact_form_required_message' => 'Completa nombre, email y mensaje para continuar.',

        // ── Map / Mapa ────────────────────────────────────────
        'map_title'               => 'Ubicacion',
        'map_text'                => 'Configura el embed del mapa en el Customizer para mostrar la ubicacion exacta de la clinica.',
        'map_embed'               => '',

        // ── Trust block / Bloque confianza ───────────────────
        'trust_eyebrow'           => 'Por que elegirnos',
        'trust_title'             => 'Una experiencia dental seria, ordenada y enfocada en resultados sostenibles.',
        'trust_text'              => 'Combinamos tecnologia de vanguardia, seguimiento profesional y una comunicacion simple para que el paciente entienda cada paso.',
        'trust_cta_label'         => 'Hablar con la clinica',
        'trust_cta_url'           => '#contacto',
        'trust_image'             => get_template_directory_uri() . '/assets/images/confianza-dental/trust-consultation.png',
        'trust_badge_1'           => 'Diagnostico claro',
        'trust_badge_2'           => 'Equipo multidisciplinario',
        'trust_badge_3'           => 'Explicaciones claras',
        'trust_badge_4'           => 'Respuesta por WhatsApp',

        // ── Clinic page / Clinica ─────────────────────────────
        'clinic_eyebrow'          => 'Clinica',
        'clinic_subtitle'         => 'Una clinica ordenada, profesional y cercana, pensada para tratamientos explicados con claridad.',
        'clinic_intro'            => 'Presentamos una forma de atencion sobria, clara y enfocada en confianza real.',
        'clinic_values_title'     => 'Nuestro enfoque de atencion',
        'clinic_value_1'          => 'Trato humano y profesional',
        'clinic_value_2'          => 'Claridad en cada tratamiento',
        'clinic_value_3'          => 'Enfoque integral del caso',
        'clinic_value_4'          => 'Experiencia del equipo clinico',
        'clinic_image_1'          => get_template_directory_uri() . '/assets/images/confianza-dental/clinic-reception.png',
        'clinic_image_2'          => get_template_directory_uri() . '/assets/images/confianza-dental/clinic-room.png',
        'clinic_image_3'          => get_template_directory_uri() . '/assets/images/confianza-dental/clinic-conversation.png',
        'clinic_cta_title'        => 'Conoce nuestra forma de atender',
        'clinic_cta_text'         => 'Te explicamos tratamientos, tiempos y alternativas con lenguaje claro y una propuesta realista.',
        'clinic_cta_label'        => 'Solicitar evaluacion',
        'clinic_cta_url'          => '#contacto',
        'clinic_sidebar_title'    => 'Datos clave',

        // ── Final CTA / CTA final ─────────────────────────────
        'final_cta_eyebrow'       => 'Comienza hoy',
        'final_cta_title'         => 'Agenda tu evaluacion y recibe una propuesta clara para tu tratamiento.',
        'final_cta_text'          => 'Un primer contacto simple, sin friccion y con informacion util para tomar una decision con confianza.',
        'final_cta_primary_label' => 'Reservar evaluacion',
        'final_cta_primary_url'   => '#contacto',
        'final_cta_secondary_label' => 'Ver tratamientos',
        'final_cta_secondary_url' => '/tratamientos/',

        // ── Testimonials / Testimonios ───────────────────────
        'testimonials_eyebrow'    => 'Testimonios',
        'testimonials_title'      => 'Pacientes que encontraron claridad, confianza y acompanamiento.',
        'testimonials_text'       => 'Historias breves que fortalecen la decision de contacto y muestran una experiencia consistente.',

        // ── FAQ ───────────────────────────────────────────────
        'faq_eyebrow'             => 'FAQ',
        'faq_title'               => 'Resolvemos dudas frecuentes antes de la primera visita.',
        'faq_text'                => 'Una estructura simple para reducir friccion y mejorar la confianza antes del contacto.',

        // ── Single treatment / Ficha tratamiento ─────────────
        'single_treatment_eyebrow'                          => 'Tratamiento',
        'single_treatment_benefits_title'                  => 'Beneficios',
        'single_treatment_audience_title'                  => 'Para quien aplica',
        'single_treatment_additional_title'                => 'Informacion adicional',
        'single_treatment_summary_title'                   => 'Resumen clinico',
        'single_treatment_duration_label'                  => 'Duracion aproximada',
        'single_treatment_duration_fallback'               => 'A definir en evaluacion',
        'single_treatment_contact_label'                   => 'Contacto directo',
        'single_treatment_faq_eyebrow'                     => 'Preguntas frecuentes',
        'single_treatment_faq_title'                       => 'Dudas frecuentes sobre este tratamiento.',

        // ── Single professional / Ficha profesional ─────────
        'single_professional_default_specialty'            => 'Profesional',
        'single_professional_default_specialty_long'       => 'Atencion dental integral',
        'single_professional_cta_fallback'                 => 'Reservar consulta',
        'single_professional_profile_title'                => 'Perfil',
        'single_professional_specialty_label'              => 'Especialidad',
        'single_professional_phone_label'                  => 'Telefono de contacto',
        'single_professional_whatsapp_label'               => 'WhatsApp',

        // ── Card labels / Etiquetas cards ───────────────────
        'card_treatment_label'        => 'Tratamiento',
        'card_treatment_link_label'   => 'Ver tratamiento',
        'card_professional_link_label' => 'Ver perfil',
        'index_detail_link_label'     => 'Ver detalle',

        // ── Generic page / Pagina generica ──────────────────
        'generic_page_eyebrow'   => 'Pagina',
        'generic_sidebar_title'  => 'Contacto rapido',

        // ── 404 ───────────────────────────────────────────────
        'not_found_title'          => 'Pagina no encontrada',
        'not_found_text'           => 'La URL que intentaste abrir no existe o fue movida. Te ayudamos a retomar el camino.',
        'not_found_primary_text'   => 'Volver al inicio',
        'not_found_primary_url'    => '/',
        'not_found_secondary_text' => 'Ver tratamientos',
        'not_found_secondary_url'  => '/tratamientos/',
    ];
}

// ── SETTINGS READERS ──────────────────────────────────────────

/**
 * Returns the fully merged settings array: defaults ← option ← theme_mods.
 *
 * Resolution order (highest priority wins):
 *   1. theme_mod (Customizer live value)
 *   2. zendent_settings option (legacy admin page)
 *   3. default value from zendent_get_default_settings()
 *
 * Result is cached statically for the rest of the request.
 *
 * @return array<string, mixed>
 */
function zendent_get_settings(): array
{
    static $cache = null;
    if ($cache !== null) {
        return $cache;
    }

    $defaults       = zendent_get_default_settings();
    $legacy_settings = get_option('zendent_settings', []);
    $settings       = wp_parse_args(is_array($legacy_settings) ? $legacy_settings : [], $defaults);

    // Customizer theme_mods override legacy options, which override defaults.
    foreach ($defaults as $key => $default) {
        $sentinel = '__zendent_unset__';
        $mod = get_theme_mod('zendent_' . $key, $sentinel);
        if ($mod !== $sentinel) {
            $settings[$key] = $mod;
        }
    }

    $cache = $settings;
    return $cache;
}

/**
 * Returns a single setting value by key.
 *
 * Convenience wrapper around zendent_get_settings(). Use this in templates
 * instead of get_theme_mod() directly.
 *
 * @param string $key     Setting key (without the `zendent_` prefix).
 * @param mixed  $default Fallback when the key is unknown.
 * @return mixed
 */
function zendent_get_option(string $key, $default = '')
{
    $settings = zendent_get_settings();
    return $settings[$key] ?? $default;
}

// ── SANITIZERS ────────────────────────────────────────────────

/**
 * Sanitizes a checkbox value to '1' or '0' (stored as string).
 *
 * @param mixed $value Raw input.
 * @return string '1' when truthy, '0' otherwise.
 */
function zendent_sanitize_checkbox($value): string
{
    return $value ? '1' : '0';
}

/**
 * Sanitizes rich textarea content. Allows a safe subset of HTML.
 *
 * @param mixed $value Raw input.
 * @return string
 */
function zendent_sanitize_textarea($value): string
{
    return wp_kses_post((string) $value);
}

/**
 * Returns the allowlist of HTML used by the map embed sanitizer.
 *
 * Map embeds are iframes (Google Maps, etc.). This is the only place
 * where iframes are accepted; everywhere else wp_kses_post strips them.
 *
 * @return array<string, array<string, bool>>
 */
function zendent_allowed_embed_html(): array
{
    return [
        'iframe' => [
            'src'             => true,
            'width'           => true,
            'height'          => true,
            'style'           => true,
            'loading'         => true,
            'allowfullscreen' => true,
            'referrerpolicy'  => true,
        ],
        'div'   => ['class' => true, 'style' => true],
        'p'     => ['class' => true],
        'small' => [],
        'a'     => ['href' => true, 'target' => true, 'rel' => true],
    ];
}

/**
 * Sanitizes a map embed (iframe). The only field that accepts iframes.
 *
 * @param mixed $value Raw embed code.
 * @return string Sanitized HTML.
 */
function zendent_sanitize_embed($value): string
{
    return wp_kses((string) $value, zendent_allowed_embed_html());
}
