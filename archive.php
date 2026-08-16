<?php

get_header();

$post_type = get_query_var('post_type');
$post_type = is_array($post_type) ? reset($post_type) : $post_type;
$post_type = $post_type ?: get_post_type();
$title_map = [
    'tratamiento' => [zendent_get_option('treatments_title'), zendent_get_option('treatments_subtitle'), 'Tratamientos'],
    'profesional' => [zendent_get_option('professionals_title'), zendent_get_option('professionals_subtitle'), 'Profesionales'],
];

[$title, $subtitle, $eyebrow] = $title_map[$post_type] ?? [post_type_archive_title('', false), get_the_archive_description(), 'Archivo'];
?>

<section class="archive-header">
    <div class="container">
        <?php zendent_render_page_intro($eyebrow, $title, wp_strip_all_tags((string) $subtitle), 1); ?>
        <?php if ($post_type === 'tratamiento' && zendent_get_option('treatments_intro')) : ?>
            <p class="archive-note"><?php echo esc_html(zendent_get_option('treatments_intro')); ?></p>
        <?php endif; ?>
        <?php if ($post_type === 'profesional' && zendent_get_option('professionals_intro')) : ?>
            <p class="archive-note"><?php echo esc_html(zendent_get_option('professionals_intro')); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="archive-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php if ($post_type === 'profesional') : ?>
                        <?php zendent_render_professional_card(get_the_ID()); ?>
                    <?php else : ?>
                        <?php zendent_render_treatment_card(get_the_ID()); ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="empty-state">
                <p><?php echo esc_html(zendent_get_option('empty_state_text')); ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
get_footer();
