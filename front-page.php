<?php

get_header();

$treatments_count = 3;
$professionals_count = 3;
$testimonials_count = 3;
$faq_count = 4;

$treatments_meta = [['key' => '_zendent_visible', 'value' => '1', 'compare' => '=']];
$treatments = new WP_Query(zendent_build_query_args('tratamiento', $treatments_count, $treatments_meta));

$professionals_meta = [[
    'key' => '_zendent_visible',
    'value' => '1',
    'compare' => '=',
]];
$professionals = new WP_Query(zendent_build_query_args('profesional', $professionals_count, $professionals_meta));

$testimonials = get_posts(zendent_build_query_args('testimonio', $testimonials_count));
$faqs = get_posts(zendent_build_query_args('faq', $faq_count));
$block_order = ['treatments', 'professionals', 'trust', 'testimonials', 'faq', 'contact', 'map', 'cta'];

$_hero_secondary_custom = zendent_get_option('hero_secondary_image');
$hero_secondary_image   = (! $_hero_secondary_custom || str_contains($_hero_secondary_custom, 'unsplash.com'))
    ? 'https://images.unsplash.com/photo-1629909615184-74f495363b67?w=600&h=450&fit=crop&auto=format'
    : $_hero_secondary_custom;
$_hero_primary_custom = zendent_get_option('hero_primary_image');
$hero_primary_image   = (! $_hero_primary_custom || str_contains($_hero_primary_custom, 'unsplash.com'))
    ? get_template_directory_uri() . '/assets/images/hero-dentista.avif'
    : $_hero_primary_custom;
$hero_phone = preg_replace('/\s+/', '', (string) zendent_get_option('phone_primary'));
?>

<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="section-tag"><?php echo esc_html(zendent_get_option('home_eyebrow')); ?></span>
            <h1><?php echo esc_html(zendent_get_option('home_title')); ?></h1>
            <p><?php echo esc_html(zendent_get_option('home_subtitle')); ?></p>
            <div class="hero-actions">
                <?php echo zendent_render_button(zendent_get_option('home_primary_cta_label'), zendent_get_option('home_primary_cta_url')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php echo zendent_render_button(zendent_get_option('home_secondary_cta_label'), zendent_get_option('home_secondary_cta_url'), 'secondary'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
            <div class="hero-contact">
                <?php if ($hero_phone) : ?>
                    <a href="<?php echo esc_url('tel:' . $hero_phone); ?>">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M13 10.33c0 .24-.06.47-.17.7-.12.22-.28.43-.49.62a2.38 2.38 0 01-1.6.58c-.42 0-.88-.1-1.37-.3a13.4 13.4 0 01-1.38-.77 22.3 22.3 0 01-1.31-1.06A22.1 22.1 0 015.37 8.8a13.4 13.4 0 01-.76-1.36C4.4 6.96 4.3 6.5 4.3 6.07c0-.42.09-.82.26-1.19.17-.37.43-.71.79-.97.4-.29.83-.43 1.28-.43.18 0 .36.04.52.11.17.07.32.18.44.34l1.5 2.1c.12.16.2.32.26.46.06.14.09.27.09.39 0 .15-.04.3-.13.45-.08.14-.2.29-.35.43l-.48.5c-.07.07-.1.16-.1.26 0 .05.01.1.03.15l.07.17c.12.22.33.5.61.84.29.34.6.69.93 1.03.34.34.67.65 1.01.94.33.28.61.49.83.6l.17.07c.04.01.09.02.15.02.1 0 .19-.04.26-.11l.48-.49c.15-.15.3-.27.44-.35.14-.08.29-.13.45-.13.12 0 .25.02.39.08.14.06.29.14.45.26l2.12 1.52c.16.12.27.27.34.44.06.17.1.34.1.53z" fill="currentColor"/></svg>
                        <?php echo esc_html(zendent_get_option('phone_primary')); ?>
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url(zendent_build_whatsapp_link()); ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.77-.87-2.04-.97-.28-.1-.47-.15-.67.15s-.77.97-.95 1.17c-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.48-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37s-1.04 1.01-1.04 2.47 1.07 2.87 1.22 3.07c.15.2 2.1 3.2 5.09 4.49.71.31 1.27.49 1.7.62.72.23 1.37.2 1.88.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/><path d="M12 0C5.37 0 0 5.37 0 12c0 2.1.55 4.1 1.53 5.83L0 24l6.35-1.5A11.95 11.95 0 0012 24c6.63 0 12-5.37 12-12S18.63 0 12 0zm0 21.82a9.82 9.82 0 01-5-1.36l-.36-.21-3.77.89.9-3.67-.23-.38A9.82 9.82 0 012.18 12 9.82 9.82 0 0112 2.18 9.82 9.82 0 0121.82 12 9.82 9.82 0 0112 21.82z"/></svg>
                    <?php echo esc_html(zendent_get_option('whatsapp_cta_text')); ?>
                </a>
            </div>
            <?php
            $testimonial = zendent_get_hero_testimonial();
            if ($testimonial) :
            ?>
            <div class="hero-testimonial">
                <blockquote class="testimonial-quote">
                    <p><?php echo esc_html($testimonial['quote']); ?></p>
                </blockquote>
                <div class="testimonial-author">
                    <strong><?php echo esc_html($testimonial['author']); ?></strong>
                    <?php if ($testimonial['role']) : ?>
                        <span><?php echo esc_html($testimonial['role']); ?></span>
                    <?php endif; ?>
                </div>
            </div>
            <?php else : ?>
            <div class="hero-meta">
                <div class="hero-avatars" aria-hidden="true"><span>P</span><span>A</span><span>M</span><span>+</span></div>
                <div>
                    <strong class="pill-value">Claro</strong>
                    <span class="pill-label"><?php echo esc_html(zendent_get_option('home_trust_text')); ?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="hero-figure">
            <div class="hero-figure__main">
                <img src="<?php echo esc_url($hero_primary_image); ?>" alt="Atencion dental profesional" loading="eager" fetchpriority="high" width="900" height="600">
            </div>
            <div class="hero-figure__thumb">
                <img src="<?php echo esc_url($hero_secondary_image); ?>" alt="Consulta dental" loading="lazy" width="600" height="450">
            </div>
        </div>
    </div>
</section>

<?php
$sections = [
    'treatments' => function () use ($treatments): void {
        if (! $treatments->have_posts()) {
            return;
        }
        ?>
        <section class="section section-soft">
            <div class="container">
                <?php zendent_render_page_intro(zendent_get_option('home_featured_treatments_eyebrow'), zendent_get_option('treatments_title'), zendent_get_option('treatments_subtitle'), 2); ?>
                <div class="card-grid">
                    <?php while ($treatments->have_posts()) : $treatments->the_post(); ?>
                        <?php zendent_render_treatment_card(get_the_ID()); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
        <?php
    },
    'professionals' => function () use ($professionals): void {
        if (! $professionals->have_posts()) {
            return;
        }
        ?>
        <section class="section">
            <div class="container">
                <?php zendent_render_page_intro(zendent_get_option('home_featured_professionals_eyebrow'), zendent_get_option('professionals_title'), zendent_get_option('professionals_subtitle'), 2); ?>
                <div class="card-grid">
                    <?php while ($professionals->have_posts()) : $professionals->the_post(); ?>
                        <?php zendent_render_professional_card(get_the_ID()); ?>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
        <?php
    },
    'trust' => function (): void {
        $_trust_doctor_custom = zendent_get_option('trust_image');
        $trust_doctor_image   = ($_trust_doctor_custom && ! str_contains($_trust_doctor_custom, 'unsplash.com'))
            ? $_trust_doctor_custom
            : 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=700&h=900&fit=crop&auto=format&crop=top';
        ?>
        <section class="section">
            <div class="container">
                <div class="trust-banner">
                    <div class="trust-banner__overlay"></div>
                    <div class="trust-banner__content">
                        <span class="section-tag"><?php echo esc_html(zendent_get_option('trust_eyebrow')); ?></span>
                        <h2><?php echo esc_html(zendent_get_option('trust_title')); ?></h2>
                        <p><?php echo esc_html(zendent_get_option('trust_text')); ?></p>
                        <div class="cta-actions">
                            <?php echo zendent_render_button(zendent_get_option('trust_cta_label'), zendent_get_option('trust_cta_url'), 'white'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    </div>
                    <div class="trust-banner__doctor">
                        <img src="<?php echo esc_url($trust_doctor_image); ?>" alt="Dentista profesional" loading="lazy">
                    </div>
                </div>
            </div>
        </section>
        <?php
    },
    'testimonials' => function () use ($testimonials): void {
        if (! $testimonials) {
            return;
        }
        ?>
        <section class="section section-soft">
            <div class="container">
                <?php zendent_render_page_intro(zendent_get_option('testimonials_eyebrow'), zendent_get_option('testimonials_title'), zendent_get_option('testimonials_text'), 2); ?>
                <div class="testimonial-grid">
                    <?php foreach ($testimonials as $testimonial) : ?>
                        <?php zendent_render_testimonial_card($testimonial->ID); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    },
    'faq' => function () use ($faqs): void {
        if (! $faqs) {
            return;
        }
        ?>
        <section class="section">
            <div class="container">
                <?php zendent_render_page_intro(zendent_get_option('faq_eyebrow'), zendent_get_option('faq_title'), zendent_get_option('faq_text'), 2); ?>
                <?php zendent_render_faq_list($faqs); ?>
            </div>
        </section>
        <?php
    },
    'contact' => function (): void {
        ?>
        <section class="section section-soft" id="contacto">
            <div class="container contact-grid">
                <div>
                    <?php zendent_render_page_intro(zendent_get_option('contact_eyebrow'), zendent_get_option('contact_title'), zendent_get_option('contact_subtitle'), 2); ?>
                    <div class="contact-actions">
                        <?php echo zendent_render_button(zendent_get_option('contact_form_submit_label'), '#contacto'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php echo zendent_render_button(zendent_get_option('whatsapp_cta_text'), zendent_build_whatsapp_link(), 'secondary'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                </div>
                <div class="contact-panel">
                    <ul class="contact-list">
                        <li><strong><?php echo esc_html(zendent_get_option('label_phone')); ?></strong><span><a href="<?php echo esc_url('tel:' . preg_replace('/\s+/', '', (string) zendent_get_option('phone_primary'))); ?>"><?php echo esc_html(zendent_get_option('phone_primary')); ?></a></span></li>
                        <li><strong><?php echo esc_html(zendent_get_option('label_whatsapp')); ?></strong><span><a href="<?php echo esc_url(zendent_build_whatsapp_link()); ?>"><?php echo esc_html(zendent_get_option('whatsapp')); ?></a></span></li>
                        <li><strong><?php echo esc_html(zendent_get_option('label_email')); ?></strong><span><a href="mailto:<?php echo esc_attr(zendent_get_option('email')); ?>"><?php echo esc_html(zendent_get_option('email')); ?></a></span></li>
                        <li><strong><?php echo esc_html(zendent_get_option('label_address')); ?></strong><span><?php echo esc_html(zendent_get_option('address')); ?></span></li>
                        <li><strong><?php echo esc_html(zendent_get_option('label_schedule')); ?></strong><span><?php echo nl2br(esc_html(zendent_get_option('schedule'))); ?></span></li>
                    </ul>
                    <p style="margin-top:24px"><?php echo esc_html(zendent_get_option('contact_help_text')); ?></p>
                </div>
            </div>
            <div class="container" style="margin-top:20px;">
                <?php zendent_render_contact_form(); ?>
            </div>
        </section>
        <?php
    },
    'map' => function (): void {
        ?>
        <section class="section">
            <div class="container">
                <?php zendent_render_map(); ?>
            </div>
        </section>
        <?php
    },
    'cta' => function (): void {
        ?>
        <section class="section">
            <div class="container cta-banner" data-animate-in>
                <div class="cta-banner__overlay"></div>
                <div class="cta-banner__content">
                    <span class="section-tag"><?php echo esc_html(zendent_get_option('final_cta_eyebrow')); ?></span>
                    <h2><?php echo esc_html(zendent_get_option('final_cta_title')); ?></h2>
                    <p><?php echo esc_html(zendent_get_option('final_cta_text')); ?></p>
                    <div class="cta-actions">
                        <?php echo zendent_render_button(zendent_get_option('final_cta_primary_label'), zendent_get_option('final_cta_primary_url')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <?php echo zendent_render_button(zendent_get_option('final_cta_secondary_label'), zendent_get_option('final_cta_secondary_url'), 'secondary'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    },
];

foreach ($block_order as $block) {
    if (isset($sections[$block])) {
        $sections[$block]();
    }
}

get_footer();
