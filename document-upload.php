<?php
require_once __DIR__ . '/backend/includes/csrf.php';
$csrfToken = getCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secure Document Upload — Financial Precision</title>
  <meta name="description" content="Securely upload your financial documents to Professional Financial & Training Solutions. 256-bit encryption.">
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
    .upload-zone { border: 2px dashed #c5c6ce; transition: all 0.3s ease; }
    .upload-zone:hover, .upload-zone.dragover { border-color: #95f6c6; background-color: #f0f3ff; }
    .upload-zone.dragover { transform: scale(1.01); }
    #upload-submit:disabled { opacity: 0.5; cursor: not-allowed; }
    .form-group.has-error input { border-color: #ba1a1a; }
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
      <a href="booking.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Booking</a>
      <a href="contact.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Contact</a>
    </nav>
    <div class="flex items-center gap-unit hidden md:flex">
      <a href="document-upload.php" class="font-label-md text-label-md text-primary border-b-2 border-on-tertiary-fixed-variant pb-1">Upload Docs</a>
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
    <a href="booking.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Booking</a>
    <a href="document-upload.php" class="font-label-md text-label-md text-primary font-bold py-2">Upload Docs</a>
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
      <div class="flex items-center gap-3 mb-stack-sm">
        <span class="material-symbols-outlined text-[32px] text-on-primary-container" aria-hidden="true">lock</span>
        <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary">
          Secure Document Upload
        </h1>
      </div>
      <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
        Submit your financial documents securely. All uploads are protected with 256-bit SSL encryption and handled in strict accordance with South African POPIA regulations.
      </p>
    </div>
  </section>

  <!-- Upload Section -->
  <section class="py-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-stack-lg">

      <!-- Upload Form -->
      <div class="lg:col-span-8">
        <div class="bg-surface border border-outline-variant p-8 md:p-10 rounded relative">
          <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-container via-surface-tint to-primary-container rounded"></div>
          <h2 class="font-headline-lg text-headline-lg text-primary mb-2">Upload Your Documents</h2>
          <p class="font-body-md text-body-md text-on-surface-variant mb-8">Drag and drop your files or click to browse. A R200 non-refundable review fee applies per submission.</p>

          <form data-validate data-form-type="upload" data-handler="backend/handlers/upload-handler.php" id="upload-form" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            <!-- File Upload Zone -->
            <div class="form-group">
              <label class="block font-label-md text-label-md text-primary mb-2 uppercase tracking-wide" for="file-upload">Select Files</label>
              <div class="upload-zone rounded p-8 text-center cursor-pointer" id="upload-zone" role="button" tabindex="0" aria-label="Click or drag files here to upload">
                <span class="material-symbols-outlined text-[48px] text-outline-variant mb-4 block" aria-hidden="true">cloud_upload</span>
                <p class="font-body-md text-body-md text-on-surface-variant mb-2">Drag &amp; drop files here, or <span class="text-primary underline">browse</span></p>
                <p class="font-label-md text-label-md text-on-surface-variant text-xs">Maximum file size: 25MB per file</p>
                <input type="file" id="file-upload" name="documents" class="hidden" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,.jpg,.jpeg,.png" required>
              </div>
              <ul id="file-list" class="mt-4 space-y-2" aria-live="polite"></ul>
              <span class="error-msg">Please select at least one file to upload.</span>
            </div>

            <!-- Supported File Types -->
            <div class="bg-surface-container-low border border-outline-variant rounded p-4">
              <h4 class="font-label-md text-label-md text-primary mb-2">Supported File Types</h4>
              <div class="flex flex-wrap gap-2">
                <span class="font-label-md text-label-md text-on-surface-variant bg-surface-container-lowest border border-outline-variant px-2 py-1 rounded text-xs">PDF</span>
                <span class="font-label-md text-label-md text-on-surface-variant bg-surface-container-lowest border border-outline-variant px-2 py-1 rounded text-xs">DOC / DOCX</span>
                <span class="font-label-md text-label-md text-on-surface-variant bg-surface-container-lowest border border-outline-variant px-2 py-1 rounded text-xs">XLS / XLSX</span>
                <span class="font-label-md text-label-md text-on-surface-variant bg-surface-container-lowest border border-outline-variant px-2 py-1 rounded text-xs">CSV</span>
                <span class="font-label-md text-label-md text-on-surface-variant bg-surface-container-lowest border border-outline-variant px-2 py-1 rounded text-xs">TXT</span>
                <span class="font-label-md text-label-md text-on-surface-variant bg-surface-container-lowest border border-outline-variant px-2 py-1 rounded text-xs">JPG / PNG</span>
              </div>
            </div>

            <!-- R200 Fee Acknowledgement -->
            <div class="bg-surface-container-low border border-outline-variant rounded p-6">
              <h4 class="font-headline-md text-headline-md text-primary mb-3 flex items-center">
                <span class="material-symbols-outlined mr-2 text-on-surface-variant" aria-hidden="true">policy</span>
                Review Fee Acknowledgement
              </h4>
              <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-4">
                A non-refundable document review fee of <strong>R200</strong> applies to each submission. This fee covers the initial assessment and classification of your documents by a qualified professional.
              </p>
              <div class="form-group flex items-start">
                <input class="w-4 h-4 mt-1 text-primary-container border-outline-variant rounded-sm focus:ring-primary-container focus:ring-2" id="fee-acknowledge" name="fee_acknowledge" type="checkbox" required>
                <label class="ml-3 font-body-md text-body-md text-primary" for="fee-acknowledge">
                  I acknowledge the non-refundable R200 review fee and agree to proceed with payment.
                </label>
              </div>
            </div>

            <!-- PAYMENT GATEWAY: Insert PayFast/Yoco payment widget here -->

            <!-- Submit -->
            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 border-t border-outline-variant/30 gap-4">
              <div class="flex items-center gap-2 text-on-surface-variant">
                <span class="material-symbols-outlined text-sm" aria-hidden="true">lock</span>
                <span class="font-body-md text-body-md text-sm">256-bit SSL encrypted transfer</span>
              </div>
              <button id="upload-submit" class="w-full sm:w-auto font-label-md text-label-md bg-primary-container text-on-primary px-8 py-3 hover:bg-surface-tint transition-all duration-300 rounded font-bold flex items-center justify-center gap-2 group disabled:opacity-50 disabled:cursor-not-allowed" type="submit" disabled>
                Upload &amp; Pay R200
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
              </button>
            </div>
          </form>
          <div class="form-message hidden mt-6 p-4 rounded text-center font-body-md text-body-md" role="alert"></div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="lg:col-span-4 flex flex-col gap-gutter">
        <!-- Security Info -->
        <div class="bg-primary-container text-on-primary p-6 rounded">
          <span class="material-symbols-outlined text-[32px] text-tertiary-fixed mb-4 block" aria-hidden="true">verified_user</span>
          <h3 class="font-headline-md text-headline-md text-on-primary mb-3">Security Assurance</h3>
          <ul class="space-y-3">
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-tertiary-fixed-dim text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-primary-container text-sm">256-bit SSL encryption on all transfers</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-tertiary-fixed-dim text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-primary-container text-sm">POPIA-compliant data handling</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-tertiary-fixed-dim text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-primary-container text-sm">Secure South African servers</span>
            </li>
            <li class="flex items-start gap-2">
              <span class="material-symbols-outlined text-tertiary-fixed-dim text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-primary-container text-sm">Confidential handling by qualified professionals</span>
            </li>
          </ul>
        </div>

        <!-- Process Info -->
        <div class="bg-surface border border-outline-variant p-6 rounded">
          <h3 class="font-headline-md text-headline-md text-primary mb-4">How It Works</h3>
          <div class="space-y-4">
            <div class="flex items-start gap-3">
              <span class="font-stat-lg text-stat-lg text-tertiary-fixed-dim">01</span>
              <div>
                <p class="font-label-md text-label-md text-primary">Upload Documents</p>
                <p class="font-body-md text-body-md text-on-surface-variant text-sm">Select and upload your financial documents securely.</p>
              </div>
            </div>
            <div class="flex items-start gap-3">
              <span class="font-stat-lg text-stat-lg text-tertiary-fixed-dim">02</span>
              <div>
                <p class="font-label-md text-label-md text-primary">Pay Review Fee</p>
                <p class="font-body-md text-body-md text-on-surface-variant text-sm">R200 non-refundable fee via PayFast or Yoco.</p>
              </div>
            <div class="flex items-start gap-3">
              <span class="font-stat-lg text-stat-lg text-tertiary-fixed-dim">03</span>
              <div>
                <p class="font-label-md text-label-md text-primary">Professional Review</p>
                <p class="font-body-md text-body-md text-on-surface-variant text-sm">Our qualified team reviews and provides feedback within 48 hours.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- Contact Support Card -->
        <div class="bg-surface border border-outline-variant p-6 rounded">
          <h3 class="font-headline-md text-headline-md text-primary mb-4 flex items-center">
            <span class="material-symbols-outlined mr-3 text-on-surface-variant" aria-hidden="true">support_agent</span>
            Need Assistance?
          </h3>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-4">Having trouble uploading or have questions about the review process?</p>
          <div class="space-y-2 text-sm text-on-surface-variant">
            <p class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary text-sm" aria-hidden="true">call</span>
              <a href="tel:+27825406032" class="hover:text-primary transition-colors">0825406032</a>
            </p>
            <p class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary text-sm" aria-hidden="true">mail</span>
              <a href="mailto:info@moshmokbusinessenter-prise.me" class="hover:text-primary transition-colors break-all">info@moshmokbusinessenter-prise.me</a>
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
