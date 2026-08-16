document.addEventListener('DOMContentLoaded', () => {

  // ── Menú móvil ──────────────────────────────────────────────
  const toggle = document.querySelector('[data-nav-toggle]');
  const nav    = document.querySelector('[data-nav]');

  function closeNav() {
    if (!nav || !toggle) return;
    nav.classList.remove('is-open');
    toggle.setAttribute('aria-expanded', 'false');
  }

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    // Cierra al hacer clic en cualquier enlace del menú
    nav.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', closeNav);
    });

    // Cierra con Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeNav();
    });
  }

  // ── FAQ accordion ────────────────────────────────────────────
  document.querySelectorAll('[data-accordion] .faq-item').forEach((item) => {
    const button = item.querySelector('.faq-question');
    if (!button) return;

    function toggleFaq() {
      const open = item.classList.toggle('is-open');
      button.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    button.addEventListener('click', toggleFaq);

    // Soporte de teclado: Enter y Space activan el acordeón
    button.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        toggleFaq();
      }
    });
  });

  // ── Validación de formulario en tiempo real ──────────────────
  const contactForm = document.querySelector('[data-contact-form]');
  const contactStatus = document.querySelector('.contact-form-status');

  if (contactStatus) {
    setTimeout(() => {
      contactStatus.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }, 300);
    const firstInput = contactStatus.querySelector('input, textarea, .button');
    if (!firstInput) {
      contactStatus.setAttribute('tabindex', '-1');
      contactStatus.focus();
    }
  }

  if (contactForm) {
    const requiredFields = contactForm.querySelectorAll('input[required], textarea[required]');

    function showFieldError(field, message) {
      field.classList.add('field-error');
      field.setAttribute('aria-invalid', 'true');
      let errorEl = field.parentElement.querySelector('.field-error-msg');
      if (!errorEl) {
        errorEl = document.createElement('span');
        errorEl.className = 'field-error-msg';
        errorEl.setAttribute('role', 'alert');
        field.parentElement.appendChild(errorEl);
      }
      errorEl.textContent = message;
    }

    function clearFieldError(field) {
      field.classList.remove('field-error');
      field.removeAttribute('aria-invalid');
      const errorEl = field.parentElement.querySelector('.field-error-msg');
      if (errorEl) errorEl.remove();
    }

    function validateField(field) {
      if (field.type === 'email' && field.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
        showFieldError(field, 'Ingresa un email válido.');
        return false;
      }
      if (field.required && !field.value.trim()) {
        showFieldError(field, 'Este campo es obligatorio.');
        return false;
      }
      clearFieldError(field);
      return true;
    }

    requiredFields.forEach((field) => {
      field.addEventListener('blur', () => validateField(field));
      field.addEventListener('input', () => {
        if (field.classList.contains('field-error')) validateField(field);
      });
    });

    // Estado loading en el botón de envío
    const submitBtn = contactForm.querySelector('[data-submit-btn]');
    contactForm.addEventListener('submit', (e) => {
      let valid = true;
      requiredFields.forEach((field) => {
        if (!validateField(field)) valid = false;
      });

      if (!valid) {
        e.preventDefault();
        const firstError = contactForm.querySelector('.field-error');
        if (firstError) firstError.focus();
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-label').hidden = true;
        submitBtn.querySelector('.btn-label-loading').hidden = false;
        submitBtn.querySelector('.button-arrow').hidden = true;
      }
    });
  }

  // ── Botón volver arriba ──────────────────────────────────────
  const backToTop = document.getElementById('back-to-top');
  if (backToTop) {
    const toggleBackToTop = () => {
      backToTop.classList.toggle('is-visible', window.scrollY > 400);
    };
    window.addEventListener('scroll', toggleBackToTop, { passive: true });
    backToTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // ── Sticky CTA móvil ─────────────────────────────────────────
  const stickyCta = document.getElementById('sticky-cta');
  if (stickyCta) {
    const hero = document.querySelector('.hero');
    if (hero) {
      const observer = new IntersectionObserver(
        ([entry]) => stickyCta.classList.toggle('is-visible', !entry.isIntersecting),
        { threshold: 0 }
      );
      observer.observe(hero);
    }
  }

  // ── Animación de entrada en CTA banner ───────────────────────
  const animatedSections = document.querySelectorAll('[data-animate-in]');
  if (animatedSections.length && 'IntersectionObserver' in window) {
    const animObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animated-in');
            animObserver.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.15 }
    );
    animatedSections.forEach((el) => animObserver.observe(el));
  }

  // ── Refined scroll animations ────────────────────────────────
  if ('IntersectionObserver' in window) {
    // Detecta si animaciones están deshabilitadas
    const animationsDisabled = document.body.classList.contains('animations-disabled');

    if (!animationsDisabled) {
      const revealObserver = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add('reveal-animated');
              revealObserver.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
      );

      // Anima secciones
      document.querySelectorAll('.section').forEach((el) => {
        el.classList.add('reveal-target');
        revealObserver.observe(el);
      });

      // Anima cards
      document.querySelectorAll('.card, .testimonial, .info-card').forEach((el) => {
        el.classList.add('reveal-target');
        revealObserver.observe(el);
      });

      // Anima hero elementos
      const heroCopy = document.querySelector('.hero-copy');
      const heroFigure = document.querySelector('.hero-figure');
      if (heroCopy) {
        heroCopy.classList.add('reveal-target', 'reveal-left');
        revealObserver.observe(heroCopy);
      }
      if (heroFigure) {
        heroFigure.classList.add('reveal-target', 'reveal-right');
        revealObserver.observe(heroFigure);
      }

      // Anima estadísticas
      document.querySelectorAll('.stat-value').forEach((el) => {
        el.classList.add('reveal-target', 'reveal-count');
        revealObserver.observe(el);
      });

      // Mini badges flotantes
      document.querySelectorAll('.hero-badge, .mini-badge').forEach((el) => {
        el.classList.add('reveal-target', 'reveal-float');
        revealObserver.observe(el);
      });
    }
  }

});
