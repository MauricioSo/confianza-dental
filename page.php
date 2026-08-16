<?php

get_header();

while (have_posts()) : the_post();
    ?>
    <section class="page-hero">
        <div class="container">
            <?php zendent_render_page_intro(zendent_get_option('generic_page_eyebrow'), get_the_title(), get_the_excerpt(), 1); ?>
        </div>
    </section>
    <section class="section">
        <div class="container page-layout">
            <article class="page-panel entry-content">
                <?php the_content(); ?>
            </article>
            <aside class="detail-panel">
                <h3><?php echo esc_html(zendent_get_option('generic_sidebar_title')); ?></h3>
                <ul class="meta-list">
                    <li><strong><?php echo esc_html(zendent_get_option('label_phone')); ?></strong><span><?php echo esc_html(zendent_get_option('phone_primary')); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_whatsapp')); ?></strong><span><?php echo esc_html(zendent_get_option('whatsapp')); ?></span></li>
                    <li><strong><?php echo esc_html(zendent_get_option('label_address')); ?></strong><span><?php echo esc_html(zendent_get_option('address')); ?></span></li>
                </ul>
            </aside>
        </div>
    </section>
<?php endwhile; ?>

<?php
get_footer();
