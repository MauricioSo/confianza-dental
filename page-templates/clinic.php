<?php
/*
Template Name: Clinica
*/

get_header();

while (have_posts()) : the_post();
    ?>
    <section class="page-hero">
        <div class="container">
            <?php zendent_render_page_intro(zendent_get_option('clinic_eyebrow'), get_the_title(), zendent_get_option('clinic_subtitle'), 1); ?>
        </div>
    </section>
    <section class="section">
        <div class="container page-layout">
            <article class="page-panel entry-content">
                <p><?php echo esc_html(zendent_get_option('clinic_intro')); ?></p>
                <?php the_content(); ?>
                <h2><?php echo esc_html(zendent_get_option('clinic_values_title')); ?></h2>
                <ul class="benefit-list">
                    <li><?php echo esc_html(zendent_get_option('clinic_value_1')); ?></li>
                    <li><?php echo esc_html(zendent_get_option('clinic_value_2')); ?></li>
                    <li><?php echo esc_html(zendent_get_option('clinic_value_3')); ?></li>
                    <li><?php echo esc_html(zendent_get_option('clinic_value_4')); ?></li>
                </ul>
            </article>
            <aside class="detail-panel">
                <h3><?php echo esc_html(zendent_get_option('clinic_sidebar_title')); ?></h3>
                <ul class="meta-list">
                    <li><strong><?php echo esc_html(zendent_get_option('label_phone')); ?></strong><span><?php echo esc_html(zendent_get_option('phone_primary')); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_whatsapp')); ?></strong><span><?php echo esc_html(zendent_get_option('whatsapp')); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_schedule')); ?></strong><span><?php echo nl2br(esc_html(zendent_get_option('schedule'))); ?></span></li>
                </ul>
            </aside>
        </div>
    </section>
    <?php if (zendent_get_option('clinic_image_1') || zendent_get_option('clinic_image_2') || zendent_get_option('clinic_image_3')) : ?>
        <section class="section section-soft">
            <div class="container feature-grid">
                <?php foreach (['clinic_image_1', 'clinic_image_2', 'clinic_image_3'] as $index => $image_key) : ?>
                    <?php if (zendent_get_option($image_key)) : ?>
                        <div class="feature-grid__media<?php echo $index === 0 ? ' is-tall' : ''; ?>"><img src="<?php echo esc_url(zendent_get_option($image_key)); ?>" alt="Instalaciones de la clinica" loading="lazy"></div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
    <section class="section">
        <div class="container trust-banner">
            <div class="trust-banner__overlay"></div>
            <div class="trust-banner__content">
                <span class="section-tag"><?php echo esc_html(zendent_get_option('trust_eyebrow')); ?></span>
                <h2><?php echo esc_html(zendent_get_option('clinic_cta_title')); ?></h2>
                <p><?php echo esc_html(zendent_get_option('clinic_cta_text')); ?></p>
                <div class="cta-actions">
                    <?php echo zendent_render_button(zendent_get_option('clinic_cta_label'), zendent_get_option('clinic_cta_url'), 'white'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
        </div>
    </section>
<?php endwhile; ?>

<?php
get_footer();
