<?php
/**
 * Native contact form: render, validate, persist via wp_mail, flash data.
 *
 * Renders a honeypot-protected and validated native contact form.
 * shortcode is configured. Submission is handled via admin-post.php and
 * feedback is flashed through a short-lived transient + cookie so the
 * user sees the result on redirect.
 *
 * @package ConfianzaDental
 */

if (! defined('ABSPATH')) {
    exit;
}

// ── STATUS & URL HELPERS ──────────────────────────────────────

/**
 * Whether the contact form feature is enabled. Always true in the current build.
 *
 * @return bool
 */
function zendent_is_contact_form_enabled(): bool
{
    return true;
}

/**
 * Reads the current contact form status from the `zendent_contact` query var.
 *
 * Returns '' when no submission is in flight. Otherwise one of:
 * 'success', 'nonce', 'email', 'required', 'error'.
 *
 * @return string
 */
function zendent_get_contact_form_status(): string
{
    return isset($_GET['zendent_contact']) ? sanitize_key(wp_unslash($_GET['zendent_contact'])) : '';
}

/**
 * Returns the admin-post.php URL the form posts to.
 *
 * @return string
 */
function zendent_get_contact_form_action_url(): string
{
    return admin_url('admin-post.php');
}

// ── FLASH DATA (transient + cookie) ───────────────────────────

/**
 * Stashes form input across the post-redirect-get pattern.
 *
 * Stores the array in a 5-minute transient keyed by a random token, sets
 * a cookie with the key, and redirects with the error type in the query string.
 *
 * @param array<string, mixed> $data       Form data to preserve.
 * @param string               $error_type Status slug (e.g. 'required', 'email').
 * @param string               $redirect   URL to redirect to.
 */
function zendent_flash_form_data(array $data, string $error_type, string $redirect): void
{
    $key = wp_generate_password(16, false);
    set_transient('zendent_fd_' . $key, $data, 300);
    setcookie('zendent_fd', $key, time() + 300, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);
    wp_safe_redirect(add_query_arg('zendent_contact', $error_type, $redirect));
    exit;
}

/**
 * Reads and clears the flashed form data from the cookie + transient.
 *
 * @return array<string, mixed>
 */
function zendent_get_flashed_form_data(): array
{
    if (! isset($_COOKIE['zendent_fd'])) {
        return [];
    }

    $key  = sanitize_text_field(wp_unslash($_COOKIE['zendent_fd']));
    $data = get_transient('zendent_fd_' . $key);
    delete_transient('zendent_fd_' . $key);
    setcookie('zendent_fd', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN, is_ssl(), true);

    return is_array($data) ? $data : [];
}

// ── FORM RENDERER ─────────────────────────────────────────────

/**
 * Renders the native contact form, including success/error status blocks.
 *
 * Reads flashed data to pre-fill fields after a failed submission.
 * Honeypot field is invisible to humans; bots fill it and get silently
 * rejected as success (without actually sending).
 */
function zendent_render_native_contact_form(): void
{
    $status      = zendent_get_contact_form_status();
    $old         = zendent_get_flashed_form_data();
    $phone_clean = preg_replace('/\s+/', '', (string) zendent_get_option('phone_primary'));
    // Fallback WhatsApp link in case of server error.
    $whatsapp_url = zendent_build_whatsapp_link('Hola, no pude enviar el formulario y necesito contacto.');

    // ── Success block ─────────────────────────────────────
    if ($status === 'success') {
        echo '<div class="contact-form-status contact-form-status-success" role="alert">';
        echo '<div class="contact-form-status__icon" aria-hidden="true">&#10003;</div>';
        echo '<div class="contact-form-status__body">';
        echo '<p class="contact-form-status__title">' . esc_html(zendent_get_option('contact_form_success_message')) . '</p>';
        echo '<p class="contact-form-status__detail">' . esc_html__('Te responderemos en un plazo máximo de 24 horas hábiles. Si tu caso es urgente, puedes escribirnos por WhatsApp para una respuesta inmediata.', 'zendent') . '</p>';
        echo '<div class="contact-form-status__actions">' . zendent_render_button(esc_html__('Escribir por WhatsApp', 'zendent'), $whatsapp_url, 'secondary') . '</div>';
        echo '</div></div>';
        return;
    }

    // ── Expired nonce block ───────────────────────────────
    if ($status === 'nonce') {
        echo '<div class="contact-form-status contact-form-status-error" role="alert">';
        echo '<div class="contact-form-status__icon" aria-hidden="true">&#9888;</div>';
        echo '<div class="contact-form-status__body">';
        echo '<p class="contact-form-status__title">' . esc_html__('La sesión expiró', 'zendent') . '</p>';
        echo '<p class="contact-form-status__detail">' . esc_html__('La página estuvo abierta demasiado tiempo y la sesión de seguridad caducó. Recarga la página e intenta nuevamente.', 'zendent') . '</p>';
        echo '<div class="contact-form-status__actions"><a class="button button-secondary" href="' . esc_url(wp_get_referer() ?: home_url('/')) . '">' . esc_html__('Recargar página', 'zendent') . '</a></div>';
        echo '</div></div>';
        return;
    }

    // ── Error blocks (form stays visible below) ──────────
    if ($status === 'email') {
        echo '<div class="contact-form-status contact-form-status-error" role="alert">';
        echo '<div class="contact-form-status__icon" aria-hidden="true">&#9888;</div>';
        echo '<div class="contact-form-status__body">';
        echo '<p class="contact-form-status__title">' . esc_html__('El email no tiene un formato válido', 'zendent') . '</p>';
        echo '<p class="contact-form-status__detail">' . esc_html__('Revisa que la dirección esté bien escrita (ejemplo: tu@email.com). Tus datos se conservan en el formulario de abajo.', 'zendent') . '</p>';
        echo '</div></div>';
    } elseif ($status === 'required') {
        echo '<div class="contact-form-status contact-form-status-error" role="alert">';
        echo '<div class="contact-form-status__icon" aria-hidden="true">&#9888;</div>';
        echo '<div class="contact-form-status__body">';
        echo '<p class="contact-form-status__title">' . esc_html__('Faltan campos obligatorios', 'zendent') . '</p>';
        echo '<p class="contact-form-status__detail">' . esc_html__('Necesitamos al menos nombre, email y mensaje para procesar tu solicitud. Los campos marcados con * son obligatorios. Tus datos se conservan abajo.', 'zendent') . '</p>';
        echo '</div></div>';
    } elseif ($status === 'error') {
        echo '<div class="contact-form-status contact-form-status-error" role="alert">';
        echo '<div class="contact-form-status__icon" aria-hidden="true">&#10007;</div>';
        echo '<div class="contact-form-status__body">';
        echo '<p class="contact-form-status__title">' . esc_html__('No pudimos enviar tu mensaje', 'zendent') . '</p>';
        echo '<p class="contact-form-status__detail">' . esc_html__('Hubo un problema con el servidor de correo. Tus datos se conservan en el formulario de abajo. Puedes:', 'zendent') . '</p>';
        echo '<ul class="contact-form-status__list">';
        echo '<li>' . esc_html__('Intentar nuevamente en unos minutos', 'zendent') . '</li>';
        echo '<li>' . esc_html__('Escribirnos directamente por WhatsApp', 'zendent') . '</li>';
        if ($phone_clean) {
            echo '<li>' . sprintf(esc_html__('Llamarnos al %s', 'zendent'), esc_html(zendent_get_option('phone_primary'))) . '</li>';
        }
        echo '</ul>';
        echo '<div class="contact-form-status__actions">' . zendent_render_button(esc_html__('Escribir por WhatsApp', 'zendent'), $whatsapp_url, 'secondary') . '</div>';
        echo '</div></div>';
    }

    // ── Pre-fill values from the failed attempt ──────────
    $name_val    = esc_attr($old['name'] ?? '');
    $email_val   = esc_attr($old['email'] ?? '');
    $phone_val   = esc_attr($old['phone'] ?? '');
    $message_val = esc_textarea($old['message'] ?? '');

    echo '<form class="contact-form-native" method="post" action="' . esc_url(zendent_get_contact_form_action_url()) . '" data-contact-form novalidate>';
    echo '<input type="hidden" name="action" value="zendent_submit_contact_form">';
    echo '<input type="hidden" name="redirect_to" value="' . esc_url(wp_get_referer() ?: home_url('/')) . '">';
    wp_nonce_field('zendent_contact_form', 'zendent_contact_nonce');
    // Honeypot: hidden from humans, populated by bots.
    echo '<p class="contact-form-hp" aria-hidden="true"><label aria-hidden="true">Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></p>';
    echo '<p class="contact-form-required-note"><span class="required-mark" aria-hidden="true">*</span> ' . esc_html__('Campos obligatorios', 'zendent') . '</p>';
    echo '<div class="contact-form-grid">';
    echo '<label for="zendent_name"><span>' . esc_html(zendent_get_option('contact_form_name_label')) . '<span class="required-mark" aria-hidden="true"> *</span></span><input type="text" id="zendent_name" name="contact_name" autocomplete="name" required value="' . $name_val . '"></label>';
    echo '<label for="zendent_email"><span>' . esc_html(zendent_get_option('contact_form_email_label')) . '<span class="required-mark" aria-hidden="true"> *</span></span><input type="email" id="zendent_email" name="contact_email" autocomplete="email" required value="' . $email_val . '"></label>';
    echo '<label for="zendent_phone"><span>' . esc_html(zendent_get_option('contact_form_phone_label')) . '</span><input type="tel" id="zendent_phone" name="contact_phone" autocomplete="tel" value="' . $phone_val . '"></label>';
    echo '<label class="contact-form-message" for="zendent_message"><span>' . esc_html(zendent_get_option('contact_form_message_label')) . '<span class="required-mark" aria-hidden="true"> *</span></span><textarea id="zendent_message" name="contact_message" rows="6" required>' . $message_val . '</textarea></label>';
    echo '</div>';
    echo '<button class="button" type="submit" data-submit-btn><span class="btn-label">' . esc_html(zendent_get_option('contact_form_submit_label')) . '</span><span class="btn-label-loading" hidden>' . esc_html__('Enviando...', 'zendent') . '</span><span class="button-arrow" aria-hidden="true">&#8599;</span></button>';
    echo '</form>';
}

// ── SUBMISSION HANDLER ────────────────────────────────────────

/**
 * Handles the contact form submission via admin-post.php.
 *
 * Validates nonce, honeypot, required fields, and email format. Builds the
 * email body, sends via wp_mail, and redirects with the right status.
 *
 * Hooked on both `admin_post_nopriv_*` and `admin_post_*` so logged-in and
 * anonymous users share the same handler.
 */
function zendent_handle_contact_form_submission(): void
{
    $redirect = isset($_POST['redirect_to']) ? esc_url_raw(wp_unslash($_POST['redirect_to'])) : home_url('/');

    // Nonce check.
    if (! isset($_POST['zendent_contact_nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['zendent_contact_nonce'])), 'zendent_contact_form')) {
        wp_safe_redirect(add_query_arg('zendent_contact', 'nonce', $redirect));
        exit;
    }

    // Honeypot: silently succeed without sending (looks like a bot).
    if (! empty($_POST['website'])) {
        wp_safe_redirect(add_query_arg('zendent_contact', 'success', $redirect));
        exit;
    }

    $name    = isset($_POST['contact_name']) ? sanitize_text_field(wp_unslash($_POST['contact_name'])) : '';
    $email   = isset($_POST['contact_email']) ? sanitize_email(wp_unslash($_POST['contact_email'])) : '';
    $phone   = isset($_POST['contact_phone']) ? sanitize_text_field(wp_unslash($_POST['contact_phone'])) : '';
    $message = isset($_POST['contact_message']) ? sanitize_textarea_field(wp_unslash($_POST['contact_message'])) : '';

    $form_data = ['name' => $name, 'email' => $email, 'phone' => $phone, 'message' => $message];

    // Required-field check.
    if (! $name || ! $email || ! $message) {
        zendent_flash_form_data($form_data, 'required', $redirect);
    }

    // Email format check.
    if (! is_email($email)) {
        zendent_flash_form_data($form_data, 'email', $redirect);
    }

    $recipient = sanitize_email(zendent_get_option('email', get_option('admin_email')));
    if (! $recipient) {
        $recipient = get_option('admin_email');
    }

    $subject = sprintf('%s - Nuevo mensaje de contacto', zendent_get_option('clinic_name', get_bloginfo('name')));
    $body = "Nombre: {$name}\n";
    $body .= "Email: {$email}\n";
    if ($phone) {
        $body .= "Telefono: {$phone}\n";
    }
    $body .= "\nMensaje:\n{$message}\n";

    $headers = [
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    $sent = wp_mail($recipient, $subject, $body, $headers);

    if (! $sent) {
        zendent_flash_form_data($form_data, 'error', $redirect);
    }

    wp_safe_redirect(add_query_arg('zendent_contact', 'success', $redirect));
    exit;
}

// ── CONTACT PANEL RENDERER ────────────────────────────────────

/**
 * Renders the free native contact panel.
 *
 * @param string $context_class Optional extra class for the wrapper.
 */
function zendent_render_contact_form(string $context_class = ''): void
{
    $class_name = 'page-panel contact-form-panel';
    if ($context_class) {
        $class_name .= ' ' . $context_class;
    }

    echo '<div class="' . esc_attr($class_name) . '" id="reserva">';
    if (zendent_get_option('contact_form_title')) {
        echo '<h3>' . esc_html(zendent_get_option('contact_form_title')) . '</h3>';
    }
    if (zendent_get_option('contact_form_text')) {
        echo '<p>' . esc_html(zendent_get_option('contact_form_text')) . '</p>';
    }

    zendent_render_native_contact_form();
    echo '</div>';
}

// ── HOOK REGISTRATION ─────────────────────────────────────────
add_action('admin_post_nopriv_zendent_submit_contact_form', 'zendent_handle_contact_form_submission');
add_action('admin_post_zendent_submit_contact_form',         'zendent_handle_contact_form_submission');
