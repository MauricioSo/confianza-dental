<?php

get_header();
?>
<section class="section">
    <div class="container">
        <div class="page-panel" style="max-width:760px;margin:0 auto;text-align:center;">
            <span class="section-tag">404</span>
            <h1><?php echo esc_html(zendent_get_option('not_found_title')); ?></h1>
            <p><?php echo esc_html(zendent_get_option('not_found_text')); ?></p>
            <div class="contact-actions" style="justify-content:center; margin-top:28px;">
                <?php echo zendent_render_button(zendent_get_option('not_found_primary_text'), zendent_get_option('not_found_primary_url')); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <?php echo zendent_render_button(zendent_get_option('not_found_secondary_text'), zendent_get_option('not_found_secondary_url'), 'secondary'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        </div>
    </div>
</section>
<?php
get_footer();
