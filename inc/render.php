<?php
/**
 * Render helpers: cards, intros, FAQ, breadcrumbs, schedule badges, maps.
 *
 * Each function here outputs HTML directly (echo). They never mutate state.
 * Templates should call these instead of inlining markup.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── PAGE INTRO ────────────────────────────────────────────────

/**
 * Renders the standard section intro header (eyebrow + title + text).
 *
 * @param string $eyebrow Small label above the title. Empty skips it.
 * @param string $title   Section title (escaped).
 * @param string $text    Optional supporting paragraph (escaped).
 * @param int    $level   Heading level 1-6. Default 2.
 */
function zendent_render_page_intro(string $eyebrow, string $title, string $text = '', int $level = 2): void
{
    $level = max(1, min(6, $level));
    echo '<header class="section-intro">';
    if ($eyebrow) {
        echo '<p class="section-tag">' . esc_html($eyebrow) . '</p>';
    }
    echo '<h' . $level . '>' . esc_html($title) . '</h' . $level . '>';
    if ($text) {
        echo '<p>' . esc_html($text) . '</p>';
    }
    echo '</header>';
}

// ── CARDS ─────────────────────────────────────────────────────

/**
 * Renders a single treatment card.
 *
 * @param int $post_id Treatment post ID.
 */
function zendent_render_treatment_card(int $post_id): void
{
    echo '<article class="card">';
    if (has_post_thumbnail($post_id)) {
        echo '<a class="card-media" href="' . esc_url(get_permalink($post_id)) . '">';
        echo get_the_post_thumbnail($post_id, 'large', ['loading' => 'lazy']);
        echo '</a>';
    }
    echo '<div class="card-body">';
    echo '<span class="card-kicker">' . esc_html(zendent_get_option('card_treatment_label')) . '</span>';
    echo '<h3><a href="' . esc_url(get_permalink($post_id)) . '">' . esc_html(get_the_title($post_id)) . '</a></h3>';
    echo '<p>' . esc_html(get_the_excerpt($post_id)) . '</p>';
    echo '<a class="text-link" href="' . esc_url(get_permalink($post_id)) . '">' . esc_html(zendent_get_option('card_treatment_link_label')) . '</a>';
    echo '</div>';
    echo '</article>';
}

/**
 * Renders a single professional card, with specialty as kicker.
 *
 * @param int $post_id Professional post ID.
 */
function zendent_render_professional_card(int $post_id): void
{
    echo '<article class="card professional-card">';
    if (has_post_thumbnail($post_id)) {
        echo '<a class="card-media professional-media" href="' . esc_url(get_permalink($post_id)) . '">';
        echo get_the_post_thumbnail($post_id, 'large', ['loading' => 'lazy']);
        echo '</a>';
    }
    echo '<div class="card-body">';
    echo '<span class="card-kicker">' . esc_html(zendent_get_post_meta_value($post_id, '_zendent_specialty', 'Equipo clinico')) . '</span>';
    echo '<h3><a href="' . esc_url(get_permalink($post_id)) . '">' . esc_html(get_the_title($post_id)) . '</a></h3>';
    echo '<p>' . esc_html(zendent_get_post_meta_value($post_id, '_zendent_short_bio', get_the_excerpt($post_id))) . '</p>';
    echo '<a class="text-link" href="' . esc_url(get_permalink($post_id)) . '">' . esc_html(zendent_get_option('card_professional_link_label')) . '</a>';
    echo '</div>';
    echo '</article>';
}

/**
 * Renders a single testimonial card with star rating.
 *
 * Rating is clamped to 1-5 stars and rendered as Unicode ★ characters.
 *
 * @param int $post_id Testimonial post ID.
 */
function zendent_render_testimonial_card(int $post_id): void
{
    $rating  = (int) zendent_get_post_meta_value($post_id, '_zendent_rating', 5);
    $content = get_post_field('post_content', $post_id);
    echo '<article class="testimonial">';
    echo '<div class="testimonial-rating">' . esc_html(str_repeat('★', max(1, min(5, $rating)))) . '</div>';
    echo '<p>' . esc_html(wp_strip_all_tags($content)) . '</p>';
    echo '<strong>' . esc_html(get_the_title($post_id)) . '</strong>';
    $role = zendent_get_post_meta_value($post_id, '_zendent_role');
    if ($role) {
        echo '<span>' . esc_html($role) . '</span>';
    }
    echo '</article>';
}

// ── FAQ LIST ──────────────────────────────────────────────────

/**
 * Renders an accessible FAQ accordion.
 *
 * Each item is a button + collapsible region, linked via aria-controls.
 * Keyboard handling lives in assets/js/theme.js.
 *
 * @param array<int, WP_Post> $posts FAQ posts.
 */
function zendent_render_faq_list(array $posts): void
{
    if (! $posts) {
        return;
    }

    echo '<div class="faq-list" data-accordion>';
    foreach ($posts as $faq) {
        $answer_id = 'faq-answer-' . $faq->ID;
        echo '<article class="faq-item">';
        echo '<button class="faq-question" type="button" aria-expanded="false" aria-controls="' . esc_attr($answer_id) . '">' . esc_html(get_the_title($faq)) . '<span aria-hidden="true">+</span></button>';
        echo '<div class="faq-answer" id="' . esc_attr($answer_id) . '" role="region"><div>' . wp_kses_post(wpautop($faq->post_content)) . '</div></div>';
        echo '</article>';
    }
    echo '</div>';
}

// ── BREADCRUMBS ───────────────────────────────────────────────

/**
 * Renders an accessible breadcrumb nav, except on the front page.
 *
 * Reads the current context (singular CPT, archive, page) to build the trail.
 */
function zendent_render_breadcrumbs(): void
{
    if (is_front_page()) {
        return;
    }

    echo '<nav aria-label="' . esc_attr__('Ruta de navegación', 'zendent') . '"><ol class="breadcrumbs">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Inicio', 'zendent') . '</a></li>';

    if (is_singular('tratamiento')) {
        echo '<li><a href="' . esc_url(get_post_type_archive_link('tratamiento')) . '">' . esc_html__('Tratamientos', 'zendent') . '</a></li>';
        echo '<li aria-current="page">' . esc_html(get_the_title()) . '</li>';
    } elseif (is_singular('profesional')) {
        echo '<li><a href="' . esc_url(get_post_type_archive_link('profesional')) . '">' . esc_html__('Profesionales', 'zendent') . '</a></li>';
        echo '<li aria-current="page">' . esc_html(get_the_title()) . '</li>';
    } elseif (is_post_type_archive()) {
        echo '<li aria-current="page">' . esc_html(post_type_archive_title('', false)) . '</li>';
    } elseif (is_page()) {
        echo '<li aria-current="page">' . esc_html(get_the_title()) . '</li>';
    }

    echo '</ol></nav>';
}

// ── SCHEDULE BADGE ────────────────────────────────────────────

/**
 * Renders a compact schedule badge (dot + summarized hours).
 *
 * Reads the multi-line `schedule` setting and joins lines with `·`.
 */
function zendent_render_schedule_badge(): void
{
    $schedule = zendent_get_option('schedule');
    if (! $schedule) {
        return;
    }

    $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $schedule)));
    echo '<div class="schedule-badge">';
    echo '<span class="schedule-badge__dot" aria-hidden="true"></span>';
    echo '<span class="schedule-badge__text">' . esc_html(implode(' &middot; ', $lines)) . '</span>';
    echo '</div>';
}

// ── MAP ───────────────────────────────────────────────────────

/**
 * Renders the location map panel.
 *
 * Outputs the configured embed iframe, or a fallback "map pending"
 * message when no embed is stored.
 *
 * @param string $context_class Optional extra class for the wrapper.
 */
function zendent_render_map(string $context_class = ''): void
{
    $class_name = 'page-panel map-panel';
    if ($context_class) {
        $class_name .= ' ' . $context_class;
    }

    echo '<div class="' . esc_attr($class_name) . '">';
    echo '<h3>' . esc_html(zendent_get_option('map_title')) . '</h3>';
    if (zendent_get_option('map_text')) {
        echo '<p>' . esc_html(zendent_get_option('map_text')) . '</p>';
    }
    if (zendent_get_option('map_embed')) {
        // Sanitized as embed on save; allows only iframes from zendent_allowed_embed_html.
        echo '<div class="map-embed">' . zendent_get_option('map_embed') . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    } else {
        echo '<p><strong>Mapa pendiente.</strong> Agrega el embed en Apariencia > Personalizar > Paginas > Contacto y reserva.</p>';
    }
    echo '</div>';
}

// ── HERO TESTIMONIAL ──────────────────────────────────────────

/**
 * Returns a single random testimonial formatted for the hero block.
 *
 * When no testimonials exist, returns a built-in demo testimonial so the
 * hero never looks empty in a fresh install.
 *
 * @return array{quote:string,author:string,role:string}|null
 */
function zendent_get_hero_testimonial(): ?array
{
    $testimonials = get_posts([
        'post_type'      => 'testimonio',
        'posts_per_page' => -1,
        'orderby'        => 'rand',
        'numberposts'    => 1,
    ]);

    if (empty($testimonials)) {
        return [
            'quote'  => 'Serious, organized and very attentive professionals. The experience was excellent from the first consultation.',
            'author' => 'Satisfied client',
            'role'   => 'Patient',
        ];
    }

    $post = $testimonials[0];
    return [
        'quote'  => wp_trim_excerpt('', $post->ID) ?: $post->post_content,
        'author' => get_post_meta($post->ID, '_zendent_author', true) ?: $post->post_title,
        'role'   => get_post_meta($post->ID, '_zendent_role', true) ?: 'Patient',
    ];
}
