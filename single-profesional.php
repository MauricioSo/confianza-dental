<?php

get_header();

while (have_posts()) : the_post();
    $cta_label = zendent_get_option('primary_cta_label', zendent_get_option('single_professional_cta_fallback'));
    $cta_url   = zendent_get_option('primary_cta_url', '#contacto');
    ?>
    <div class="container" style="padding-top:24px"><?php zendent_render_breadcrumbs(); ?></div>
    <section class="single-header">
        <div class="container single-hero">
            <div>
                <span class="section-tag"><?php echo esc_html(zendent_get_post_meta_value(get_the_ID(), '_zendent_specialty', zendent_get_option('single_professional_default_specialty'))); ?></span>
                <h1><?php the_title(); ?></h1>
                <p><?php echo esc_html(zendent_get_post_meta_value(get_the_ID(), '_zendent_short_bio', get_the_excerpt())); ?></p>
                <div class="contact-actions">
                    <?php echo zendent_render_button($cta_label, $cta_url); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <?php echo zendent_render_button(zendent_get_option('whatsapp_cta_text'), zendent_build_whatsapp_link('Hola, quiero reservar con ' . get_the_title()), 'secondary'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
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
        <div class="container detail-grid" style="grid-template-columns:1.3fr .9fr">
            <article class="page-panel entry-content">
                <?php the_content(); ?>
            </article>
            <aside class="detail-panel">
                <h3><?php echo esc_html(zendent_get_option('single_professional_profile_title')); ?></h3>
                <ul class="meta-list">
                    <li><strong><?php echo esc_html(zendent_get_option('single_professional_specialty_label')); ?></strong><span><?php echo esc_html(zendent_get_post_meta_value(get_the_ID(), '_zendent_specialty', zendent_get_option('single_professional_default_specialty_long'))); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('single_professional_phone_label')); ?></strong><span><?php echo esc_html(zendent_get_option('phone_primary')); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('single_professional_whatsapp_label')); ?></strong><span><?php echo esc_html(zendent_get_option('whatsapp')); ?></span></li>
                </ul>
            </aside>
        </div>
    </section>

    <section class="section">
        <div class="container trust-banner">
            <div class="trust-banner__overlay"></div>
            <div class="trust-banner__content">
                <span class="section-tag"><?php echo esc_html(zendent_get_option('trust_eyebrow')); ?></span>
                <h2><?php echo esc_html(zendent_get_option('trust_title')); ?></h2>
                <p><?php echo esc_html(zendent_get_option('trust_text')); ?></p>
                <div class="cta-actions">
                    <?php echo zendent_render_button(zendent_get_option('trust_cta_label'), zendent_get_option('trust_cta_url'), 'white'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
        </div>
    </section>
<?php endwhile; ?>

<?php
get_footer();
