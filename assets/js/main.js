/**
 * Professional Financial & Training Solutions — Shared JS
 * Mobile nav, form validation, AJAX submission, scroll effects, smooth scroll
 */
(function () {
  'use strict';

  /* =============================================
     MOBILE NAVIGATION
     ============================================= */
  function initMobileNav() {
    const btn = document.querySelector('.mobile-nav-btn');
    const nav = document.getElementById('mobile-nav');
    const overlay = document.getElementById('mobile-nav-overlay');
    if (!btn || !nav) return;

    function toggleNav() {
      const expanded = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', String(!expanded));
      nav.classList.toggle('open', !expanded);
      if (overlay) overlay.classList.toggle('open', !expanded);
      document.body.style.overflow = !expanded ? 'hidden' : '';
    }

    btn.addEventListener('click', toggleNav);
    if (overlay) overlay.addEventListener('click', toggleNav);

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && btn.getAttribute('aria-expanded') === 'true') {
        toggleNav();
      }
    });
  }

  /* =============================================
     FORM VALIDATION — Client-side
     ============================================= */
  function validateForm(form) {
    var valid = true;
    var firstInvalid = null;

    // Clear previous errors
    form.querySelectorAll('.form-group').forEach(function (g) {
      g.classList.remove('has-error');
    });

    // Required fields
    form.querySelectorAll('[required]').forEach(function (field) {
      if (field.type === 'checkbox' && !field.checked) {
        valid = false;
        var group = field.closest('.form-group');
        if (group) group.classList.add('has-error');
        if (!firstInvalid) firstInvalid = field;
        return;
      }
      if (!field.value.trim()) {
        valid = false;
        var group2 = field.closest('.form-group');
        if (group2) group2.classList.add('has-error');
        if (!firstInvalid) firstInvalid = field;
      }
    });

    // Email
    form.querySelectorAll('input[type="email"]').forEach(function (field) {
      if (field.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
        valid = false;
        var group = field.closest('.form-group');
        if (group) group.classList.add('has-error');
        if (!firstInvalid) firstInvalid = field;
      }
    });

    // Phone
    form.querySelectorAll('input[type="tel"]').forEach(function (field) {
      if (field.value && field.value.replace(/[\s\-\+\(\)]/g, '').length < 8) {
        valid = false;
        var group = field.closest('.form-group');
        if (group) group.classList.add('has-error');
        if (!firstInvalid) firstInvalid = field;
      }
    });

    // Select
    form.querySelectorAll('select[required]').forEach(function (sel) {
      if (!sel.value) {
        valid = false;
        var group = sel.closest('.form-group');
        if (group) group.classList.add('has-error');
        if (!firstInvalid) firstInvalid = sel;
      }
    });

    // File upload
    form.querySelectorAll('input[type="file"][required]').forEach(function (fileInput) {
      if (!fileInput.files || fileInput.files.length === 0) {
        valid = false;
        var group = fileInput.closest('.form-group');
        if (group) group.classList.add('has-error');
        if (!firstInvalid) firstInvalid = fileInput;
      }
    });

    return { valid: valid, firstInvalid: firstInvalid };
  }

  function clearErrors(form) {
    form.querySelectorAll('.form-group').forEach(function (g) {
      g.classList.remove('has-error');
    });
  }

  /* =============================================
     SHOW FORM MESSAGE (success / error)
     ============================================= */
  function showMessage(form, type, text) {
    var msgEl = form.parentNode.querySelector('.form-message');
    if (!msgEl) {
      // fallback: insert after form
      msgEl = document.createElement('div');
      msgEl.className = 'form-message hidden mt-6 p-4 rounded text-center font-body-md text-body-md';
      msgEl.setAttribute('role', 'alert');
      form.parentNode.insertBefore(msgEl, form.nextSibling);
    }
    msgEl.textContent = text;
    msgEl.className = 'form-message mt-6 p-4 rounded text-center font-body-md text-body-md';
    if (type === 'success') {
      msgEl.classList.add('bg-tertiary-fixed', 'text-on-tertiary-fixed');
    } else {
      msgEl.classList.add('bg-red-100', 'text-red-700', 'border', 'border-red-300');
    }
    msgEl.classList.remove('hidden');
    msgEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  function hideMessage(form) {
    var msgEl = form.parentNode.querySelector('.form-message');
    if (msgEl) msgEl.classList.add('hidden');
  }

  /* =============================================
     BUTTON LOADING STATE
     ============================================= */
  function setButtonLoading(btn, loading) {
    if (loading) {
      btn.dataset.originalHtml = btn.innerHTML;
      btn.disabled = true;
      btn.classList.add('opacity-60', 'cursor-wait');
      btn.innerHTML = '<svg class="animate-spin inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>Submitting\u2026';
    } else {
      btn.disabled = false;
      btn.classList.remove('opacity-60', 'cursor-wait');
      if (btn.dataset.originalHtml) {
        btn.innerHTML = btn.dataset.originalHtml;
      }
    }
  }

  /* =============================================
     AJAX FORM SUBMISSION
     ============================================= */
  function initFormAjax() {
    var forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(function (form) {
      form.setAttribute('novalidate', '');

      form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Client-side validation
        var result = validateForm(form);
        if (!result.valid) {
          if (result.firstInvalid) result.firstInvalid.focus();
          return;
        }

        var handler = form.getAttribute('data-handler');
        var formType = form.getAttribute('data-form-type');
        if (!handler) return;

        // Find submit button
        var submitBtn = form.querySelector('button[type="submit"]');
        setButtonLoading(submitBtn, true);
        hideMessage(form);

        // Build FormData (works for both JSON and multipart/file uploads)
        var formData = new FormData(form);
        var useFormData = formType === 'upload';

        var fetchOptions = {
          method: 'POST',
          body: useFormData ? formData : null,
        };

        // For non-file forms, send as JSON
        if (!useFormData) {
          var jsonData = {};
          formData.forEach(function (value, key) {
            jsonData[key] = value;
          });
          fetchOptions.headers = { 'Content-Type': 'application/json' };
          fetchOptions.body = JSON.stringify(jsonData);
        }

        // Send CSRF token via header as well
        var csrfInput = form.querySelector('input[name="csrf_token"]');
        if (csrfInput && csrfInput.value) {
          fetchOptions.headers = fetchOptions.headers || {};
          fetchOptions.headers['X-CSRF-Token'] = csrfInput.value;
        }

        fetch(handler, fetchOptions)
          .then(function (response) {
            return response.json().then(function (data) {
              return { ok: response.ok, data: data };
            });
          })
          .then(function (result) {
            setButtonLoading(submitBtn, false);
            if (result.ok && result.data.success) {
              showMessage(form, 'success', result.data.message || 'Submitted successfully.');
              form.reset();
              // Clear file list if upload form
              var fileList = document.getElementById('file-list');
              if (fileList) fileList.innerHTML = '';
            } else {
              showMessage(form, 'error', result.data.message || 'Something went wrong. Please try again.');
            }
          })
          .catch(function () {
            setButtonLoading(submitBtn, false);
            showMessage(form, 'error', 'Network error. Please check your connection and try again.');
          });
      });

      // Live validation: remove error on input
      form.querySelectorAll('input, select, textarea').forEach(function (field) {
        field.addEventListener('input', function () {
          var group = field.closest('.form-group');
          if (group && field.value.trim()) {
            group.classList.remove('has-error');
          }
        });
        field.addEventListener('change', function () {
          var group = field.closest('.form-group');
          if (group && field.value.trim()) {
            group.classList.remove('has-error');
          }
        });
      });
    });
  }

  /* =============================================
     SCROLL-BASED HEADER SHADOW
     ============================================= */
  function initScrollHeader() {
    var header = document.querySelector('header.sticky, header[class*="sticky"]');
    if (!header) return;

    window.addEventListener('scroll', function () {
      if (window.scrollY > 10) {
        header.classList.add('shadow-md');
        header.classList.remove('shadow-none');
      } else {
        header.classList.remove('shadow-md');
        header.classList.add('shadow-none');
      }
    }, { passive: true });
  }

  /* =============================================
     SMOOTH SCROLL FOR ANCHOR LINKS
     ============================================= */
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
      anchor.addEventListener('click', function (e) {
        var targetId = this.getAttribute('href');
        if (targetId === '#') return;
        var target = document.querySelector(targetId);
        if (target) {
          e.preventDefault();
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
  }

  /* =============================================
     FILE UPLOAD PREVIEW & R200 FEE CHECKBOX
     ============================================= */
  function initFileUpload() {
    var fileInput = document.getElementById('file-upload');
    var fileList = document.getElementById('file-list');
    var feeCheckbox = document.getElementById('fee-acknowledge');
    var submitBtn = document.getElementById('upload-submit');

    if (!fileInput) return;

    fileInput.addEventListener('change', function () {
      if (!fileList) return;
      fileList.innerHTML = '';
      Array.from(this.files).forEach(function (file) {
        var li = document.createElement('li');
        li.className = 'flex items-center justify-between py-2 px-3 bg-surface-container-lowest border border-outline-variant rounded text-sm';
        var sizeKB = Math.round(file.size / 1024);
        li.innerHTML = '<span class="truncate max-w-xs">' + file.name + '</span><span class="text-on-surface-variant">' + sizeKB + ' KB</span>';
        fileList.appendChild(li);
      });
      updateSubmitState();
    });

    if (feeCheckbox) {
      feeCheckbox.addEventListener('change', updateSubmitState);
    }

    function updateSubmitState() {
      if (!submitBtn || !feeCheckbox) return;
      submitBtn.disabled = !feeCheckbox.checked || (fileInput.files && fileInput.files.length === 0);
    }
  }

  /* =============================================
     MEMBERSHIP FORM AJAX SUBMISSION
     ============================================= */
  function initMembershipForm() {
    var form = document.getElementById('member-signup-form');
    if (!form) return;

    var nameInput = document.getElementById('member-name');
    var emailInput = document.getElementById('member-email');
    var submitBtn = document.getElementById('member-submit-btn');
    var feedback = document.getElementById('member-form-feedback');
    var errName = document.getElementById('error-name');
    var errEmail = document.getElementById('error-email');

    function isValidEmail(email) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function showStatus(type, message) {
      if (!feedback) return;
      feedback.className = 'form-feedback ' + (type === 'success' ? 'feedback-success' : 'feedback-error');
      feedback.textContent = message;
      feedback.style.display = 'block';
    }

    function clearStatus() {
      if (feedback) {
        feedback.className = 'form-feedback';
        feedback.textContent = '';
        feedback.style.display = 'none';
      }
      if (errName) errName.textContent = '';
      if (errEmail) errEmail.textContent = '';
      if (nameInput) nameInput.classList.remove('input-error');
      if (emailInput) emailInput.classList.remove('input-error');
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      clearStatus();

      var nameVal = nameInput ? nameInput.value.trim() : '';
      var emailVal = emailInput ? emailInput.value.trim() : '';
      var hasError = false;

      // Client-side validation: Name required
      if (!nameVal) {
        if (errName) errName.textContent = 'Please enter your full name.';
        if (nameInput) nameInput.classList.add('input-error');
        hasError = true;
      }

      // Client-side validation: Valid Email required
      if (!emailVal) {
        if (errEmail) errEmail.textContent = 'Please enter your email address.';
        if (emailInput) emailInput.classList.add('input-error');
        hasError = true;
      } else if (!isValidEmail(emailVal)) {
        if (errEmail) errEmail.textContent = 'Please provide a valid email address (e.g. name@domain.com).';
        if (emailInput) emailInput.classList.add('input-error');
        hasError = true;
      }

      if (hasError) {
        showStatus('error', 'Please resolve the highlighted field errors before submitting.');
        return;
      }

      // Disable button during AJAX submission
      var origBtnText = submitBtn ? submitBtn.innerHTML : '';
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting\u2026';
      }

      var formData = new FormData(form);

      fetch(form.action || 'member-signup.php', {
        method: 'POST',
        body: formData
      })
      .then(function (res) {
        return res.json().then(function (data) {
          return { ok: res.ok, data: data };
        });
      })
      .then(function (res) {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = origBtnText;
        }

        if (res.ok && res.data.success) {
          showStatus('success', res.data.message || 'Thank you! Your membership request was received.');
          form.reset();
          var tsField = form.querySelector('input[name="form_timestamp"]');
          if (tsField) {
            tsField.value = Math.floor(Date.now() / 1000);
          }
        } else {
          var msg = (res.data && res.data.message) ? res.data.message : 'An error occurred. Please try again.';
          showStatus('error', msg);
        }
      })
      .catch(function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = origBtnText;
        }
        showStatus('error', 'Network error. Please check your internet connection and try again.');
      });
    });

    if (nameInput) {
      nameInput.addEventListener('input', function () {
        if (this.value.trim() && errName) {
          errName.textContent = '';
          this.classList.remove('input-error');
        }
      });
    }

    if (emailInput) {
      emailInput.addEventListener('input', function () {
        if (isValidEmail(this.value.trim()) && errEmail) {
          errEmail.textContent = '';
          this.classList.remove('input-error');
        }
      });
    }
  }

  /* =============================================
     INIT ALL
     ============================================= */
  document.addEventListener('DOMContentLoaded', function () {
    initMobileNav();
    initFormAjax();
    initScrollHeader();
    initSmoothScroll();
    initFileUpload();
    initMembershipForm();
  });
})();

