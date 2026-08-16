<?php
/**
 * Block pattern registration.
 *
 * Exposes a small set of curated block patterns in the editor under a
 * `Confianza Dental` category. These mirror the key sections (hero, CTA,
 * FAQ, contact) so editors can drop them into a generic page.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Registers the `zendent` block pattern category and its curated patterns.
 *
 * Hooked on `init`. Silently no-ops when block patterns are not supported
 * (very old WP versions).
 */
function zendent_register_block_patterns(): void
{
    if (! function_exists('register_block_pattern')) {
        return;
    }

    register_block_pattern_category('zendent', ['label' => __('Confianza Dental', 'zendent')]);

    $patterns = [
        'hero-principal'   => ['Hero principal',   '<!-- wp:group {"style":{"spacing":{"padding":{"top":"64px","bottom":"64px"}}},"layout":{"type":"constrained"}} --><div class="wp-block-group" style="padding-top:64px;padding-bottom:64px"><!-- wp:paragraph {"textColor":"violet","fontSize":"xs"} --><p class="has-violet-color has-text-color has-xs-font-size">Clinica dental moderna</p><!-- /wp:paragraph --><!-- wp:heading {"level":1,"fontSize":"hero"} --><h1 class="wp-block-heading has-hero-font-size">Atencion seria y clara para cuidar tu sonrisa.</h1><!-- /wp:heading --><!-- wp:paragraph --><p>Actualiza este bloque con tu propuesta principal, beneficios y CTA.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Agendar evaluacion</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button">Ver tratamientos</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->'],
        'cta-simple'       => ['Simple CTA',       '<!-- wp:group {"style":{"spacing":{"padding":{"top":"48px","right":"32px","bottom":"48px","left":"32px"}},"border":{"radius":"36px"},"color":{"background":"#0B0A1A"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-background" style="border-radius:36px;background-color:#0B0A1A;padding-top:48px;padding-right:32px;padding-bottom:48px;padding-left:32px"><!-- wp:paragraph {"textColor":"violet-light","fontSize":"xs"} --><p class="has-violet-light-color has-text-color has-xs-font-size">Start today</p><!-- /wp:paragraph --><!-- wp:heading {"textColor":"white"} --><h2 class="wp-block-heading has-white-color has-text-color">Book your initial evaluation</h2><!-- /wp:heading --><!-- wp:paragraph {"textColor":"background"} --><p class="has-background-color has-text-color">This block works for section closings and conversion.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Book</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->'],
        'cta-whatsapp'     => ['CTA WhatsApp',    '<!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}},"border":{"radius":"24px"},"color":{"background":"#EEEDFE"}},"layout":{"type":"constrained"}} --><div class="wp-block-group has-background" style="border-radius:24px;background-color:#EEEDFE;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Habla con la clinica por WhatsApp</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Ideal para dudas, reserva rapida o urgencias.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Escribir ahora</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->'],
        'faq'              => ['FAQ',              '<!-- wp:group {"layout":{"type":"constrained"}} --><div class="wp-block-group"><!-- wp:heading {"level":2} --><h2 class="wp-block-heading">Frequently asked questions</h2><!-- /wp:heading --><!-- wp:details --><details class="wp-block-details"><summary>How long does an evaluation take?</summary><!-- wp:paragraph --><p>Usually between 30 and 45 minutes.</p><!-- /wp:paragraph --></details><!-- /wp:details --><!-- wp:details --><details class="wp-block-details"><summary>Do you handle emergencies?</summary><!-- wp:paragraph --><p>Yes, you can use this block to inform about availability.</p><!-- /wp:paragraph --></details><!-- /wp:details --></div><!-- /wp:group -->'],
        'contacto-rapido'  => ['Contacto rapido', '<!-- wp:group {"style":{"spacing":{"padding":{"top":"32px","right":"32px","bottom":"32px","left":"32px"}},"border":{"radius":"24px"},"border":{"width":"1px"}},"layout":{"type":"constrained"}} --><div class="wp-block-group" style="border-width:1px;border-radius:24px;padding-top:32px;padding-right:32px;padding-bottom:32px;padding-left:32px"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Contacto rapido</h3><!-- /wp:heading --><!-- wp:list --><ul><li>Telefono principal</li><li>WhatsApp</li><li>Direccion</li><li>Horario</li></ul><!-- /wp:list --></div><!-- /wp:group -->'],
    ];

    foreach ($patterns as $slug => [$title, $content]) {
        register_block_pattern('zendent/' . $slug, [
            'title'    => __($title, 'zendent'),
            'categories' => ['zendent'],
            'content'  => $content,
        ]);
    }
}

// ── HOOK REGISTRATION ─────────────────────────────────────────
add_action('init', 'zendent_register_block_patterns');
