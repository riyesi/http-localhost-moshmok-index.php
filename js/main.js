/**
 * js/main.js — Membership Form AJAX & Client-Side Validation
 * Plain Vanilla JavaScript — No jQuery, no external libraries
 */
document.addEventListener('DOMContentLoaded', function () {
  initMembershipForm();
});

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
        // Update timestamp for next potential submit
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

  // Clear validation errors dynamically on user input
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
