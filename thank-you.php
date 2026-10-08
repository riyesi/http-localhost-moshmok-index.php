<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You ? Financial Precision</title>
  <meta name="description" content="Thank you for reaching out to Professional Financial & Training Solutions. We will be in touch shortly.">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="css/style.css?v=<?= file_exists(__DIR__ . '/css/style.css') ? filemtime(__DIR__ . '/css/style.css') : time() ?>">
  <script src="assets/js/main.js" defer></script>
  <style>
    #mobile-nav { transform: translateX(100%); transition: transform 0.3s ease; display: flex; }
    #mobile-nav.open { transform: translateX(0); }
    #mobile-nav-overlay { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
    #mobile-nav-overlay.open { opacity: 1; pointer-events: auto; }
    .icon-close { display: none; }
    .mobile-nav-btn[aria-expanded="true"] .icon-menu { display: none; }
    .mobile-nav-btn[aria-expanded="true"] .icon-close { display: block; }
    .checkmark-circle { width: 120px; height: 120px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; animation: scaleIn 0.5s ease-out; }
    @keyframes scaleIn { 0% { transform: scale(0); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
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
      <a href="booking.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Booking</a>
      <a href="contact.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Contact</a>
    </nav>
    <div class="flex items-center gap-unit hidden md:flex">
      <a href="document-upload.php" class="font-label-md text-label-md text-on-surface-variant border border-on-surface-variant rounded px-gutter py-unit hover:bg-surface-container-low transition-all">Upload Docs</a>
      <a href="contact.php" class="font-label-md text-label-md bg-tertiary-fixed text-on-tertiary-fixed rounded px-gutter py-unit hover:opacity-90 transition-all font-bold">Get a Quote</a>
      <a href="backend/admin/login.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors flex items-center gap-1 border border-outline-variant rounded px-3 py-unit hover:bg-surface-container-low" title="Staff / Admin Portal Login">
        <span class="material-symbols-outlined text-[18px]" aria-hidden="true">lock</span> Login
      </a>
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
    <a href="booking.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Booking</a>
    <a href="document-upload.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Upload Docs</a>
    <a href="contact.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Contact</a>
  </nav>
  <div class="mt-8 flex flex-col gap-3">
    <a href="contact.php" class="bg-tertiary-fixed text-on-tertiary-fixed text-center py-3 rounded font-label-md text-label-md font-bold">Get a Quote</a>
    <a href="backend/admin/login.php" class="border border-outline-variant text-on-surface-variant hover:text-primary text-center py-2.5 rounded font-label-md text-label-md flex items-center justify-center gap-1.5 font-medium">
      <span class="material-symbols-outlined text-[18px]" aria-hidden="true">lock</span> Staff / Admin Login
    </a>
  </div>
</div>

<!-- Main Content -->
<main class="flex-grow relative z-10 w-full">

  <!-- Thank You Hero -->
  <section class="py-10 md:py-20 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto text-center">
    <div class="max-w-2xl mx-auto">
      <!-- Animated Checkmark -->
      <div class="checkmark-circle bg-primary-container mb-stack-md">
        <span class="material-symbols-outlined text-on-primary" style="font-size: 64px; font-variation-settings: 'FILL' 1;" aria-hidden="true">check_circle</span>
      </div>

      <h1 class="font-display-lg-mobile text-display-lg-mobile md:font-display-lg md:text-display-lg text-primary mb-stack-sm">Submission Received.</h1>
      <p class="font-body-lg text-body-lg text-on-surface-variant mb-stack-md">
        Thank you for contacting Professional Financial &amp; Training Solutions. Your enquiry has been logged and our team will review it promptly. You can expect a response within <strong class="text-on-surface">24 business hours</strong>.
      </p>

      <div class="flex flex-col sm:flex-row gap-unit justify-center mb-stack-lg">
        <a href="index.php" class="bg-primary-container text-on-primary px-gutter py-3 rounded font-label-md text-label-md hover:opacity-90 transition-opacity text-center">Return to Home</a>
        <a href="services.php" class="border border-primary text-primary px-gutter py-3 rounded font-label-md text-label-md hover:bg-surface-container-low transition-colors text-center">Explore Our Services</a>
      </div>
    </div>
  </section>

  <!-- Next Steps -->
  <section class="py-stack-lg bg-surface-container-lowest border-y border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div class="text-center mb-stack-md">
        <h2 class="font-headline-lg text-headline-lg text-primary mb-4">What Happens Next</h2>
        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">Here's what you can expect from our team following your submission.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
        <!-- Step 1 -->
        <div class="text-center p-6 bg-surface border border-outline-variant rounded">
          <div class="w-16 h-16 bg-primary-container rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-on-primary text-3xl" aria-hidden="true">mark_email_read</span>
          </div>
          <span class="font-stat-lg text-stat-lg text-primary block mb-2">1</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-2">Confirmation</h3>
          <p class="font-body-sm text-body-sm text-on-surface-variant">You'll receive an email confirmation of your submission within the hour.</p>
        </div>
        <!-- Step 2 -->
        <div class="text-center p-6 bg-surface border border-outline-variant rounded">
          <div class="w-16 h-16 bg-primary-container rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-on-primary text-3xl" aria-hidden="true">manage_search</span>
          </div>
          <span class="font-stat-lg text-stat-lg text-primary block mb-2">2</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-2">Review</h3>
          <p class="font-body-sm text-body-sm text-on-surface-variant">Our team reviews your submission and assigns the appropriate specialist.</p>
        </div>
        <!-- Step 3 -->
        <div class="text-center p-6 bg-surface border border-outline-variant rounded">
          <div class="w-16 h-16 bg-primary-container rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-on-primary text-3xl" aria-hidden="true">handshake</span>
          </div>
          <span class="font-stat-lg text-stat-lg text-primary block mb-2">3</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-2">Follow-Up</h3>
          <p class="font-body-sm text-body-sm text-on-surface-variant">A specialist will reach out to discuss next steps or confirm your booking.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="w-full py-stack-lg bg-surface-container-low border-b border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop text-center">
      <h2 class="font-headline-lg text-headline-lg mb-4 text-primary">Need immediate assistance?</h2>
      <p class="font-body-lg text-body-lg mb-stack-md max-w-2xl mx-auto text-on-surface-variant">Our team is available during standard business hours to assist with urgent enquiries.</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="tel:+27825406032" class="inline-block font-label-md text-label-md bg-tertiary-fixed text-on-tertiary-fixed px-8 py-4 rounded hover:bg-tertiary-fixed-dim transition-colors">Call 082 540 6032</a>
        <a href="contact.php" class="inline-block font-label-md text-label-md border-2 border-primary text-primary px-8 py-4 rounded hover:bg-surface-container-low transition-colors">Contact Us</a>
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
      <a href="backend/admin/login.php" class="font-label-md text-label-md text-on-primary-container hover:text-on-primary hover:underline transition-all flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">lock</span> Staff Login</a>
    </div>
    <div class="col-span-1 flex flex-col gap-2">
      <span class="font-label-md text-label-md text-tertiary-fixed font-bold mb-2">Contact</span>
      <p class="font-label-md text-label-md text-on-primary-container"><a href="tel:+27825406032" class="hover:text-on-primary hover:underline transition-all">0825406032</a></p>
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
