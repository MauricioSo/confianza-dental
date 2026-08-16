    </main>
    <footer class="site-footer">
        <div class="container site-footer__inner">
            <?php echo zendent_render_site_logo(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php zendent_render_footer_nav(); ?>
            <div>
                <?php if (zendent_get_option('schedule')) : ?>
                    <?php zendent_render_schedule_badge(); ?>
                <?php endif; ?>
                <p><?php echo esc_html(zendent_get_option('footer_text')); ?></p>
                <p>&copy; <?php echo esc_html(wp_date('Y')); ?> <?php echo esc_html(zendent_get_option('clinic_name', get_bloginfo('name'))); ?></p>
                <p>Hecho por <a href="https://heymauricio.com" rel="author">Mauricio Soto</a></p>
            </div>
        </div>
    </footer>
</div>

<button class="back-to-top" id="back-to-top" aria-label="<?php esc_attr_e('Volver arriba', 'zendent'); ?>">
    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
        <path d="M8 12V4M4 8l4-4 4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</button>

<?php
$hero_phone = preg_replace('/\s+/', '', (string) zendent_get_option('phone_primary'));
if ($hero_phone || zendent_get_option('whatsapp')) :
?>
<div class="sticky-cta" id="sticky-cta" role="complementary" aria-label="<?php esc_attr_e('Contacto rápido', 'zendent'); ?>">
    <?php if ($hero_phone) : ?>
        <a class="sticky-cta__phone" href="<?php echo esc_url('tel:' . $hero_phone); ?>">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M13 10.33c0 .24-.06.47-.17.7-.12.22-.28.43-.49.62a2.38 2.38 0 01-1.6.58c-.42 0-.88-.1-1.37-.3a13.4 13.4 0 01-1.38-.77 22.3 22.3 0 01-1.31-1.06A22.1 22.1 0 015.37 8.8a13.4 13.4 0 01-.76-1.36C4.4 6.96 4.3 6.5 4.3 6.07c0-.42.09-.82.26-1.19.17-.37.43-.71.79-.97.4-.29.83-.43 1.28-.43.18 0 .36.04.52.11.17.07.32.18.44.34l1.5 2.1c.12.16.2.32.26.46.06.14.09.27.09.39 0 .15-.04.3-.13.45-.08.14-.2.29-.35.43l-.48.5c-.07.07-.1.16-.1.26 0 .05.01.1.03.15l.07.17c.12.22.33.5.61.84.29.34.6.69.93 1.03.34.34.67.65 1.01.94.33.28.61.49.83.6l.17.07c.04.01.09.02.15.02.1 0 .19-.04.26-.11l.48-.49c.15-.15.3-.27.44-.35.14-.08.29-.13.45-.13.12 0 .25.02.39.08.14.06.29.14.45.26l2.12 1.52c.16.12.27.27.34.44.06.17.1.34.1.53z" fill="currentColor"/></svg>
            <?php echo esc_html(zendent_get_option('phone_primary')); ?>
        </a>
    <?php endif; ?>
    <?php if (zendent_get_option('whatsapp')) : ?>
        <a class="sticky-cta__whatsapp" href="<?php echo esc_url(zendent_build_whatsapp_link()); ?>">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.77-.87-2.04-.97-.28-.1-.47-.15-.67.15s-.77.97-.95 1.17c-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.48-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.61-.92-2.2-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37s-1.04 1.01-1.04 2.47 1.07 2.87 1.22 3.07c.15.2 2.1 3.2 5.09 4.49.71.31 1.27.49 1.7.62.72.23 1.37.2 1.88.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/><path d="M12 0C5.37 0 0 5.37 0 12c0 2.1.55 4.1 1.53 5.83L0 24l6.35-1.5A11.95 11.95 0 0012 24c6.63 0 12-5.37 12-12S18.63 0 12 0zm0 21.82a9.82 9.82 0 01-5-1.36l-.36-.21-3.77.89.9-3.67-.23-.38A9.82 9.82 0 012.18 12 9.82 9.82 0 0112 2.18 9.82 9.82 0 0121.82 12 9.82 9.82 0 0112 21.82z"/></svg>
            WhatsApp
        </a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
