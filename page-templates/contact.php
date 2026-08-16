<?php
/*
Template Name: Contacto / Reserva
*/

get_header();

while (have_posts()) : the_post();
    ?>
    <section class="page-hero">
        <div class="container">
            <?php zendent_render_page_intro(zendent_get_option('contact_page_eyebrow'), zendent_get_option('contact_title'), zendent_get_option('contact_subtitle'), 1); ?>
        </div>
    </section>
    <section class="section">
        <div class="container contact-grid">
            <article class="page-panel entry-content">
                <?php the_content(); ?>
                <?php zendent_render_contact_form('contact-form-panel-inline'); ?>
            </article>
            <aside class="detail-panel">
                <h3><?php echo esc_html(zendent_get_option('contact_sidebar_title')); ?></h3>
                <ul class="meta-list">
                    <li><strong><?php echo esc_html(zendent_get_option('label_phone')); ?></strong><span><a href="<?php echo esc_url('tel:' . preg_replace('/\s+/', '', (string) zendent_get_option('phone_primary'))); ?>"><?php echo esc_html(zendent_get_option('phone_primary')); ?></a></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_whatsapp')); ?></strong><span><a href="<?php echo esc_url(zendent_build_whatsapp_link()); ?>"><?php echo esc_html(zendent_get_option('whatsapp')); ?></a></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_email')); ?></strong><span><a href="mailto:<?php echo esc_attr(zendent_get_option('email')); ?>"><?php echo esc_html(zendent_get_option('email')); ?></a></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_address')); ?></strong><span><?php echo esc_html(zendent_get_option('address')); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_schedule')); ?></strong><span><?php echo nl2br(esc_html(zendent_get_option('schedule'))); ?></span></li>
                </ul>
                <?php zendent_render_schedule_badge(); ?>
                <div class="contact-actions" style="margin-top:28px">
                    <?php echo zendent_render_button(zendent_get_option('whatsapp_cta_text'), zendent_build_whatsapp_link()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </aside>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <?php zendent_render_map(); ?>
        </div>
    </section>
<?php endwhile; ?>

<?php
get_footer();
