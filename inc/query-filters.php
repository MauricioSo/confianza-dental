<?php
/**
 * Query helpers and main-query filters.
 *
 * Provides a single query-args builder for CPT listings and filters the
 * main query on CPT archives so hidden / inactive items never leak.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── QUERY ARGS BUILDER ────────────────────────────────────────

/**
 * Builds a WP_Query args array for a Confianza Dental CPT query.
 *
 * Standardizes published-only, menu-order-first sorting, and optional
 * meta_query injection. Used by every CPT archive and home block.
 *
 * @param string                         $post_type  Post type slug (tratamiento, profesional).
 * @param int                            $limit      Posts per page. -1 for unlimited.
 * @param array<int, array<string,mixed>> $meta_query Optional meta_query clauses.
 * @return array<string, mixed> WP_Query args ready to pass to `new WP_Query()`.
 */
function zendent_build_query_args(string $post_type, int $limit = -1, array $meta_query = []): array
{
    $args = [
        'post_type'      => $post_type,
        'posts_per_page' => $limit,
        'post_status'    => 'publish',
        // menu_order first lets admins pin items; date breaks ties.
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
    ];

    if ($meta_query) {
        $args['meta_query'] = $meta_query;
    }

    return $args;
}

// ── MAIN QUERY FILTERS ────────────────────────────────────────

/**
 * Filters the main query on CPT archives.
 *
 * - tratamiento / profesional: hide items with `_zendent_visible = 0`.
 *   Items with no meta key set are treated as visible.
 *
 * Skips admin context and non-main queries.
 *
 * @param WP_Query $query Current query.
 */
function zendent_filter_archive_queries(WP_Query $query): void
{
    if (is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive()) {
        return;
    }

    if ($query->get('post_type') === 'profesional') {
        $query->set('meta_query', [[
            'relation' => 'OR',
            [
                'key'     => '_zendent_visible',
                'value'   => '1',
                'compare' => '=',
            ],
            [
                'key'     => '_zendent_visible',
                'compare' => 'NOT EXISTS',
            ],
        ]]);
    }

    if ($query->get('post_type') === 'tratamiento') {
        $query->set('meta_query', [[
            'relation' => 'OR',
            [
                'key'     => '_zendent_visible',
                'value'   => '1',
                'compare' => '=',
            ],
            [
                'key'     => '_zendent_visible',
                'compare' => 'NOT EXISTS',
            ],
        ]]);
    }

}

// ── HOOK REGISTRATION ─────────────────────────────────────────
add_action('pre_get_posts', 'zendent_filter_archive_queries');
