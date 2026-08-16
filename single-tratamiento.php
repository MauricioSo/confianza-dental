<?php

get_header();

while (have_posts()) : the_post();
    $benefits = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', (string) zendent_get_post_meta_value(get_the_ID(), '_zendent_benefits', ''))));

    $cta_label = zendent_get_option('primary_cta_label', 'Reservar evaluacion');
    $cta_url   = zendent_get_option('primary_cta_url', '#contacto');
    ?>
    <div class="container" style="padding-top:24px"><?php zendent_render_breadcrumbs(); ?></div>
    <section class="single-header">
        <div class="container single-hero">
            <div>
                <span class="section-tag"><?php echo esc_html(zendent_get_option('single_treatment_eyebrow')); ?></span>
                <h1><?php the_title(); ?></h1>
                <p><?php echo esc_html(get_the_excerpt()); ?></p>
                <div class="contact-actions">
                    <?php echo zendent_render_button($cta_label, $cta_url); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php echo zendent_render_button(zendent_get_option('whatsapp_cta_text'), zendent_build_whatsapp_link('Hola, quiero informacion sobre ' . get_the_title()), 'secondary'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
            <div class="single-cover">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', ['loading' => 'eager']); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container detail-grid" style="grid-template-columns:1.4fr .8fr">
            <article class="page-panel entry-content">
                <?php the_content(); ?>
                <?php if ($benefits) : ?>
                    <h2><?php echo esc_html(zendent_get_option('single_treatment_benefits_title')); ?></h2>
                    <ul class="benefit-list">
                        <?php foreach ($benefits as $benefit) : ?>
                            <li><?php echo esc_html($benefit); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if (zendent_get_post_meta_value(get_the_ID(), '_zendent_audience')) : ?>
                    <h2><?php echo esc_html(zendent_get_option('single_treatment_audience_title')); ?></h2>
                    <p><?php echo esc_html(zendent_get_post_meta_value(get_the_ID(), '_zendent_audience')); ?></p>
                <?php endif; ?>
                <?php if (zendent_get_post_meta_value(get_the_ID(), '_zendent_additional_block')) : ?>
                    <h2><?php echo esc_html(zendent_get_option('single_treatment_additional_title')); ?></h2>
                    <p><?php echo esc_html(zendent_get_post_meta_value(get_the_ID(), '_zendent_additional_block')); ?></p>
                <?php endif; ?>
            </article>
            <aside class="detail-panel">
                <h3><?php echo esc_html(zendent_get_option('single_treatment_summary_title')); ?></h3>
                <ul class="meta-list">
                    <li><strong><?php echo esc_html(zendent_get_option('single_treatment_duration_label')); ?></strong><span><?php echo esc_html(zendent_get_post_meta_value(get_the_ID(), '_zendent_duration', zendent_get_option('single_treatment_duration_fallback'))); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('single_treatment_contact_label')); ?></strong><span><?php echo esc_html(zendent_get_option('phone_primary')); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_whatsapp')); ?></strong><span><?php echo esc_html(zendent_get_option('whatsapp')); ?></span></li>
                </ul>
            </aside>
        </div>
    </section>

<?php endwhile; ?>

<?php
get_footer();
