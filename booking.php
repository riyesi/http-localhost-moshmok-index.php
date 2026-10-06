<?php
require_once __DIR__ . '/backend/includes/csrf.php';
$csrfToken = getCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book a Consultation — Financial Precision</title>
  <meta name="description" content="Book a consultation with Professional Financial & Training Solutions. Schedule your compliance assessment or advisory session.">
  <link rel="stylesheet" href="assets/css/styles.css">
  <script src="assets/js/main.js" defer></script>
  <style>
    #mobile-nav { transform: translateX(100%); transition: transform 0.3s ease; display: flex; }
    #mobile-nav.open { transform: translateX(0); }
    #mobile-nav-overlay { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
    #mobile-nav-overlay.open { opacity: 1; pointer-events: auto; }
    .icon-close { display: none; }
    .mobile-nav-btn[aria-expanded="true"] .icon-menu { display: none; }
    .mobile-nav-btn[aria-expanded="true"] .icon-close { display: block; }
    .form-group.has-error input,
    .form-group.has-error select,
    .form-group.has-error textarea { border-color: #ba1a1a; }
    .form-group.has-error .error-msg { display: block; }
    .error-msg { display: none; color: #ba1a1a; font-size: 0.75rem; margin-top: 4px; }
  </style>
</head>
<body class="bg-surface text-on-surface font-body-lg antialiased min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-surface sticky top-0 z-50 w-full border-b border-outline-variant">
  <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-unit max-w-container-max mx-auto">
    <a href="index.php" class="font-headline-md text-headline-md font-bold text-primary tracking-tight">FINANCIAL PRECISION</a>
    <nav class="hidden md:flex items-center gap-gutter">
      <a href="index.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Home</a>
      <a href="services.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Services</a>
      <a href="about.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">About</a>
      <a href="training.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Training</a>
      <a href="booking.php" class="font-label-md text-label-md text-primary border-b-2 border-on-tertiary-fixed-variant pb-1">Booking</a>
      <a href="contact.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Contact</a>
    </nav>
    <div class="flex items-center gap-unit hidden md:flex">
      <a href="document-upload.php" class="font-label-md text-label-md text-on-surface-variant border border-on-surface-variant rounded px-gutter py-unit hover:bg-surface-container-low transition-all">Upload Docs</a>
      <a href="contact.php" class="font-label-md text-label-md bg-tertiary-fixed text-on-tertiary-fixed rounded px-gutter py-unit hover:opacity-90 transition-all font-bold">Get a Quote</a>
    </div>
    <button class="mobile-nav-btn md:hidden text-primary p-2" aria-expanded="false" aria-label="Toggle navigation">
      <span class="material-symbols-outlined icon-menu">menu</span>
      <span class="material-symbols-outlined icon-close">close</span>
    </button>
  </div>
</header>
<div id="mobile-nav-overlay" class="fixed inset-0 bg-black/40 z-40"></div>
<div id="mobile-nav" class="fixed top-0 right-0 w-72 h-full bg-surface z-50 flex-col p-6 shadow-xl">
  <nav class="flex flex-col gap-4">
    <a href="index.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Home</a>
    <a href="services.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Services</a>
    <a href="about.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">About</a>
    <a href="training.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Training</a>
    <a href="booking.php" class="font-label-md text-label-md text-primary font-bold py-2">Booking</a>
    <a href="document-upload.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Upload Docs</a>
    <a href="contact.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Contact</a>
  </nav>
  <div class="mt-8 flex flex-col gap-3">
    <a href="contact.php" class="bg-tertiary-fixed text-on-tertiary-fixed text-center py-3 rounded font-label-md text-label-md font-bold">Get a Quote</a>
  </div>
</div>

<!-- Main Content -->
<main class="flex-grow">

  <!-- Hero Section -->
  <section class="relative pt-6 pb-10 md:pt-10 md:pb-14 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto border-b border-outline-variant bg-surface">
    <div class="max-w-3xl">
      <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-stack-md">
        Book a Consultation
      </h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
        Schedule a preliminary compliance assessment or advisory consultation with our expert team. <strong class="text-primary font-bold">Consultation Fee: R750 per hour.</strong> Choose the format that suits you best — virtual or in-person.
      </p>
    </div>
  </section>

  <!-- Booking Form + Sidebar -->
  <section class="py-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-stack-lg">

      <!-- Booking Form -->
      <div class="lg:col-span-8">
        <div class="bg-surface border border-outline-variant p-8 md:p-10 rounded relative">
          <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-container via-surface-tint to-primary-container rounded"></div>
          <h2 class="font-headline-lg text-headline-lg text-primary mb-2">Appointment Booking</h2>
          <p class="font-body-md text-body-md text-on-surface-variant mb-4">Complete the form below and we will confirm your appointment within 24 hours via email or phone.</p>
          <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded bg-surface-container-low border border-outline-variant text-primary font-bold text-sm mb-6"><span class="material-symbols-outlined text-[18px]">payments</span> Consultation Fee: R750 per hour</div>

          <!-- CALENDLY EMBED: Replace this section with Calendly widget -->

          <form data-validate data-form-type="booking" data-handler="backend/handlers/booking-handler.php" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label class="block font-label-md text-label-md text-primary mb-2 uppercase tracking-wide" for="book-name">Full Name</label>
                <input class="w-full bg-surface-container-lowest border border-outline-variant rounded py-3 px-4 focus:ring-0 focus:border-tertiary-fixed-dim focus:bg-surface transition-colors font-body-md text-body-md text-primary placeholder-outline" id="book-name" name="name" placeholder="e.g. John Mokoena" required type="text">
                <span class="error-msg">Please enter your name.</span>
              </div>
              <div class="form-group">
                <label class="block font-label-md text-label-md text-primary mb-2 uppercase tracking-wide" for="book-email">Email</label>
                <input class="w-full bg-surface-container-lowest border border-outline-variant rounded py-3 px-4 focus:ring-0 focus:border-tertiary-fixed-dim focus:bg-surface transition-colors font-body-md text-body-md text-primary placeholder-outline" id="book-email" name="email" placeholder="name@company.co.za" required type="email">
                <span class="error-msg">Please enter a valid email.</span>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label class="block font-label-md text-label-md text-primary mb-2 uppercase tracking-wide" for="book-phone">Phone</label>
                <input class="w-full bg-surface-container-lowest border border-outline-variant rounded py-3 px-4 focus:ring-0 focus:border-tertiary-fixed-dim focus:bg-surface transition-colors font-body-md text-body-md text-primary placeholder-outline" id="book-phone" name="phone" placeholder="082 540 6032" required type="tel">
                <span class="error-msg">Please enter a valid phone number.</span>
              </div>
              <div class="form-group">
                <label class="block font-label-md text-label-md text-primary mb-2 uppercase tracking-wide" for="book-type">Consultation Type</label>
                <select class="w-full bg-surface-container-lowest border border-outline-variant rounded py-3 px-4 focus:ring-0 focus:border-tertiary-fixed-dim focus:bg-surface transition-colors font-body-md text-body-md text-primary appearance-none" id="book-type" name="consultation_type" required>
                  <option disabled selected value="">Select type</option>
                  <option value="tax_compliance">Tax Compliance Assessment</option>
                  <option value="audit_review">Audit Review Consultation</option>
                  <option value="financial_advisory">Financial Advisory Session</option>
                  <option value="accounting_setup">Accounting Setup Consultation</option>
                  <option value="training_enquiry">Training Programme Enquiry</option>
                  <option value="general">General Enquiry</option>
                </select>
                <span class="error-msg">Please select a consultation type.</span>
              </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="form-group">
                <label class="block font-label-md text-label-md text-primary mb-2 uppercase tracking-wide" for="book-date">Preferred Date</label>
                <input class="w-full bg-surface-container-lowest border border-outline-variant rounded py-3 px-4 focus:ring-0 focus:border-tertiary-fixed-dim focus:bg-surface transition-colors font-body-md text-body-md text-primary" id="book-date" name="preferred_date" required type="date">
                <span class="error-msg">Please select a date.</span>
              </div>
              <div class="form-group">
                <label class="block font-label-md text-label-md text-primary mb-2 uppercase tracking-wide" for="book-time">Preferred Time</label>
                <select class="w-full bg-surface-container-lowest border border-outline-variant rounded py-3 px-4 focus:ring-0 focus:border-tertiary-fixed-dim focus:bg-surface transition-colors font-body-md text-body-md text-primary appearance-none" id="book-time" name="preferred_time" required>
                  <option disabled selected value="">Select time</option>
                  <option value="08:00">08:00</option>
                  <option value="09:00">09:00</option>
                  <option value="10:00">10:00</option>
                  <option value="11:00">11:00</option>
                  <option value="12:00">12:00</option>
                  <option value="13:00">13:00</option>
                  <option value="14:00">14:00</option>
                  <option value="15:00">15:00</option>
                  <option value="16:00">16:00</option>
                </select>
                <span class="error-msg">Please select a time.</span>
              </div>
            </div>
            <div class="form-group">
              <label class="block font-label-md text-label-md text-primary mb-2 uppercase tracking-wide" for="book-message">Additional Notes</label>
              <textarea class="w-full bg-surface-container-lowest border border-outline-variant rounded py-3 px-4 focus:ring-0 focus:border-tertiary-fixed-dim focus:bg-surface transition-colors font-body-md text-body-md text-primary placeholder-outline resize-none" id="book-message" name="message" placeholder="Briefly describe what you would like to discuss..." rows="4"></textarea>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-outline-variant/30 gap-4">
              <p class="font-body-md text-body-md text-on-surface-variant text-sm">
                <span class="material-symbols-outlined text-sm align-middle mr-1" aria-hidden="true">check_circle</span>
                Your booking will be confirmed via email or phone within 24 hours.
              </p>
              <button class="w-full sm:w-auto font-label-md text-label-md bg-primary-container text-on-primary px-8 py-3 hover:bg-surface-tint transition-all duration-300 rounded font-bold flex items-center justify-center gap-2 group" type="submit">
                Request Appointment
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
              </button>
            </div>
          </form>
          <div class="form-message hidden mt-6 p-4 rounded text-center font-body-md text-body-md" role="alert"></div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="lg:col-span-4 flex flex-col gap-gutter">
        <!-- Consultation Fee -->
        <div class="bg-surface border border-outline-variant p-6 rounded">
          <h3 class="font-headline-md text-headline-md text-primary mb-3 flex items-center">
            <span class="material-symbols-outlined mr-3 text-on-surface-variant" aria-hidden="true">payments</span>
            Consultation Fee
          </h3>
          <p class="font-headline-lg text-headline-lg text-primary font-bold">R750 <span class="font-body-md text-body-md text-on-surface-variant font-normal">per hour</span></p>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm mt-2">Comprehensive compliance evaluation, financial advisory, and strategic guidance.</p>
        </div>
        <!-- Operating Hours -->
        <div class="bg-surface border border-outline-variant p-6 rounded">
          <h3 class="font-headline-md text-headline-md text-primary mb-4 flex items-center">
            <span class="material-symbols-outlined mr-3 text-on-surface-variant" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">schedule</span>
            Operating Hours
          </h3>
          <div class="space-y-3 font-body-md text-body-md text-primary">
            <div class="flex justify-between border-b border-outline-variant/30 pb-2">
              <span>Monday — Thursday</span>
              <span class="font-label-md text-label-md">08:00 — 17:00</span>
            </div>
            <div class="flex justify-between border-b border-outline-variant/30 pb-2">
              <span>Friday</span>
              <span class="font-label-md text-label-md">08:00 — 16:00</span>
            </div>
            <div class="flex justify-between text-on-surface-variant">
              <span>Weekends &amp; Public Holidays</span>
              <span class="font-label-md text-label-md">Closed</span>
            </div>
          </div>
        </div>
        <!-- Direct Line -->
        <div class="bg-surface border border-outline-variant p-6 rounded">
          <h3 class="font-headline-md text-headline-md text-primary mb-4 flex items-center">
            <span class="material-symbols-outlined mr-3 text-on-surface-variant" aria-hidden="true">support_agent</span>
            Direct Line
          </h3>
          <div class="space-y-3 font-body-md text-body-md text-on-surface-variant">
            <p class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary text-sm" aria-hidden="true">call</span>
              <a href="tel:+27825406032" class="hover:text-primary transition-colors">+27 82 540 6032</a>
            </p>
            <p class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary text-sm" aria-hidden="true">mail</span>
              <a href="mailto:info@moshmokbusinessenter-prise.me" class="hover:text-primary transition-colors break-all">info@moshmokbusinessenter-prise.me</a>
            </p>
            <p class="flex items-center gap-2">
              <span class="text-[#25D366] shrink-0" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current" aria-hidden="true">
                  <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.28-2.42 5.84a8.19 8.19 0 0 1-5.82 2.41h-.01c-1.49 0-2.95-.4-4.23-1.16l-.3-.18-3.12.82.83-3.04-.2-.31a8.188 8.188 0 0 1-1.25-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.8 11.66c-.26-.13-1.56-.77-1.8-.86-.24-.09-.42-.13-.6.13-.17.26-.69.86-.84 1.04-.16.17-.31.2-.58.07-.26-.13-1.12-.41-2.13-1.31-.79-.7-1.32-1.57-1.48-1.83-.16-.26-.02-.4.11-.53.12-.12.26-.31.39-.46.13-.16.17-.26.26-.44.09-.17.04-.33-.02-.46-.07-.13-.6-1.45-.83-1.99-.22-.52-.45-.45-.61-.46h-.52c-.18 0-.46.07-.7.33-.24.26-.92.9-.92 2.2 0 1.3 0.95 2.56 1.08 2.74.13.17 1.87 2.85 4.52 4 0.63 0.27 1.12 0.44 1.5 0.56 0.63 0.2 1.21 0.17 1.66 0.1 0.51-.08 1.56-.64 1.78-1.25.22-.62.22-1.15.15-1.26-.06-.11-.24-.18-.5-.31z"/>
                </svg>
              </span>
              <a href="https://wa.me/27825406032" target="_blank" rel="noopener noreferrer" class="text-[#25D366] hover:underline font-semibold transition-colors">Chat on WhatsApp</a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- Footer -->
<footer class="bg-primary-container text-on-primary w-full border-t border-outline-variant">
  <div class="grid grid-cols-1 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop py-stack-lg max-w-container-max mx-auto">
    <div class="col-span-1">
      <div class="font-headline-md text-headline-md text-on-primary">FINANCIAL PRECISION</div>
      <p class="font-body-md text-body-md text-on-primary-container mt-stack-sm text-sm">Elevating financial standards through rigorous methodology and expert education.</p>
      <p class="font-body-md text-body-md text-on-primary-container mt-2 text-sm">100% Black-Owned Practice</p>
    </div>
    <div class="col-span-1 flex flex-col gap-2">
      <span class="font-label-md text-label-md text-tertiary-fixed font-bold mb-2">Services</span>
      <a href="services.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all">Accounting</a>
      <a href="services.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all">Tax Audit</a>
      <a href="services.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all">Advisory</a>
      <a href="training.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all">Training</a>
    </div>
    <div class="col-span-1 flex flex-col gap-2">
      <span class="font-label-md text-label-md text-tertiary-fixed font-bold mb-2">Company</span>
      <a href="about.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all">About Us</a>
      <a href="booking.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all">Book Consultation</a>
      <a href="document-upload.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all">Upload Documents</a>
      <a href="contact.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all">Contact</a>
    </div>
    <div class="col-span-1 flex flex-col gap-2">
      <span class="font-label-md text-label-md text-tertiary-fixed font-bold mb-2">Contact</span>
      <p class="font-label-md text-label-md text-on-primary-container"><a href="tel:+27825406032" class="hover:text-on-primary hover:underline transition-all">+27 82 540 6032</a></p>
      <p class="font-label-md text-label-md text-on-primary-container"><a href="mailto:info@moshmokbusinessenter-prise.me" class="hover:text-on-primary hover:underline transition-all break-all">info@moshmokbusinessenter-prise.me</a></p>
      <p class="font-body-md text-body-md text-on-primary-container text-sm mt-4">CBAP SA | ATO SA | TTP SA</p>
    </div>
  </div>
  <div class="px-margin-mobile md:px-margin-desktop py-4 bg-[#0A1324] text-center border-t border-on-primary-fixed-variant">
    <p class="font-body-md text-body-md text-on-primary-container text-xs">&copy; 2024 Professional Financial &amp; Training Solutions. All rights reserved.</p>
  </div>
</footer>

</body>
</html>
