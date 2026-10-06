<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professional Financial &amp; Training Solutions — Home</title>
  <meta name="description" content="Your trusted partner for accounting, tax audit, financial advisory and accredited training in South Africa.">
  <link rel="stylesheet" href="assets/css/styles.css">
  <script src="assets/js/main.js" defer></script>
  <style>
    .top-accent { border-top: 2px solid #95f6c6; }
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(15,27,51,0.04), 0 10px 10px -5px rgba(15,27,51,0.02); border-color: #95f6c6; }
    .grid-pattern { background-size: 40px 40px; background-image: linear-gradient(to right, rgba(0,0,0,0.05) 1px, transparent 1px), linear-gradient(to bottom, rgba(0,0,0,0.05) 1px, transparent 1px); }
    #mobile-nav { transform: translateX(100%); transition: transform 0.3s ease; display: flex; }
    #mobile-nav.open { transform: translateX(0); }
    #mobile-nav-overlay { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
    #mobile-nav-overlay.open { opacity: 1; pointer-events: auto; }
    .icon-close { display: none; }
    .mobile-nav-btn[aria-expanded="true"] .icon-menu { display: none; }
    .mobile-nav-btn[aria-expanded="true"] .icon-close { display: block; }
  </style>
</head>
<body class="bg-surface text-on-surface font-body-lg antialiased">

<!-- Header -->
<header class="bg-surface sticky top-0 z-50 w-full border-b border-outline-variant">
  <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-unit max-w-container-max mx-auto">
    <a href="index.php" class="font-headline-md text-headline-md font-bold text-primary tracking-tight">FINANCIAL PRECISION</a>
    <nav class="hidden md:flex items-center gap-gutter">
      <a href="index.php" class="font-label-md text-label-md text-primary border-b-2 border-on-tertiary-fixed-variant pb-1">Home</a>
      <a href="services.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Services</a>
      <a href="about.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">About</a>
      <a href="training.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Training</a>
      <a href="booking.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Booking</a>
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
<!-- Mobile nav overlay -->
<div id="mobile-nav-overlay" class="fixed inset-0 bg-black/40 z-40"></div>
<!-- Mobile nav drawer -->
<div id="mobile-nav" class="fixed top-0 right-0 w-72 h-full bg-surface z-50 flex-col p-6 shadow-xl">
  <nav class="flex flex-col gap-4">
    <a href="index.php" class="font-label-md text-label-md text-primary font-bold py-2">Home</a>
    <a href="services.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Services</a>
    <a href="about.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">About</a>
    <a href="training.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Training</a>
    <a href="booking.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Booking</a>
    <a href="document-upload.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Upload Docs</a>
    <a href="contact.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary py-2">Contact</a>
  </nav>
  <div class="mt-8 flex flex-col gap-3">
    <a href="contact.php" class="bg-tertiary-fixed text-on-tertiary-fixed text-center py-3 rounded font-label-md text-label-md font-bold">Get a Quote</a>
  </div>
</div>

<!-- Main Content -->
<main>

  <!-- Hero Section -->
  <section class="relative w-full border-b border-outline-variant bg-surface">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop py-6 md:py-12 grid grid-cols-1 md:grid-cols-2 gap-gutter items-center min-h-[600px]">
      <div class="z-10">
        <h1 class="font-display-lg-mobile text-display-lg-mobile md:font-display-lg md:text-display-lg text-primary mb-stack-sm text-balance">
          Your Trusted Partner for Accounting, Tax Audit &amp; Financial Training
        </h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mb-stack-md max-w-lg">
          Expert accounting services, tax audit solutions, and accredited financial training — all under one roof. Designed for clarity, executed with precision.
        </p>
        <div class="flex flex-col sm:flex-row gap-unit mt-stack-md">
          <a href="booking.php" class="bg-primary-container text-on-primary px-gutter py-3 rounded font-label-md text-label-md hover:opacity-90 transition-opacity text-center">Book a Consultation</a>
          <a href="services.php" class="border border-primary text-primary px-gutter py-3 rounded font-label-md text-label-md hover:bg-surface-container-low transition-colors text-center">Explore Our Services</a>
        </div>
      </div>
      <div class="relative h-64 md:h-full min-h-[400px] bg-surface-container-low rounded-lg overflow-hidden border border-outline-variant">
        <div class="absolute inset-0 grid-pattern opacity-50"></div>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('assets/images/hero-home.jpg');" role="img" aria-label="Modern corporate office setting representing Financial Precision"></div>
      </div>
    </div>
  </section>

  <!-- Trust Badges -->
  <section class="py-stack-md bg-surface-container-lowest border-b border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div class="flex flex-wrap justify-center items-center gap-4 md:gap-gutter text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">history</span>
          <span>18+ Years Experience</span>
        </div>
        <div class="hidden md:block w-px h-6 bg-outline-variant" aria-hidden="true"></div>
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">verified</span>
          <span>CBAP SA</span>
        </div>
        <div class="hidden md:block w-px h-6 bg-outline-variant" aria-hidden="true"></div>
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">school</span>
          <span>ATO SA</span>
        </div>
        <div class="hidden md:block w-px h-6 bg-outline-variant" aria-hidden="true"></div>
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">assured_workload</span>
          <span>TTP SA</span>
        </div>
        <div class="hidden md:block w-px h-6 bg-outline-variant" aria-hidden="true"></div>
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">verified_user</span>
          <span>100% Black-Owned</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Overview -->
  <section class="py-stack-lg bg-surface">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div class="mb-stack-md md:mb-stack-lg">
        <h2 class="font-headline-lg text-headline-lg text-primary mb-unit">Precision Solutions</h2>
        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">Comprehensive financial management and education tailored for institutional stability and individual growth.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
        <!-- Service Card 1: Accounting -->
        <a href="services.php" class="bg-surface-container-lowest border border-outline-variant rounded p-gutter top-accent hover-lift flex flex-col h-full no-underline">
          <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center mb-stack-sm text-primary">
            <span class="material-symbols-outlined text-[24px]" aria-hidden="true">account_balance</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-unit">Accounting</h3>
          <p class="font-body-md text-body-md text-on-surface-variant flex-grow">Methodical bookkeeping, financial reporting, and structural financial health monitoring.</p>
          <div class="mt-stack-sm font-label-md text-label-md text-primary flex items-center gap-1 group">
            Learn more <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
          </div>
        </a>
        <!-- Service Card 2: Tax Audit -->
        <a href="services.php" class="bg-surface-container-lowest border border-outline-variant rounded p-gutter top-accent hover-lift flex flex-col h-full no-underline">
          <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center mb-stack-sm text-primary">
            <span class="material-symbols-outlined text-[24px]" aria-hidden="true">fact_check</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-unit">Tax Audit</h3>
          <p class="font-body-md text-body-md text-on-surface-variant flex-grow">Rigorous compliance checks, risk mitigation, and strategic tax planning solutions.</p>
          <div class="mt-stack-sm font-label-md text-label-md text-primary flex items-center gap-1 group">
            Learn more <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
          </div>
        </a>
        <!-- Service Card 3: Financial Advisory -->
        <a href="services.php" class="bg-surface-container-lowest border border-outline-variant rounded p-gutter top-accent hover-lift flex flex-col h-full no-underline">
          <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center mb-stack-sm text-primary">
            <span class="material-symbols-outlined text-[24px]" aria-hidden="true">trending_up</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-unit">Financial Advisory</h3>
          <p class="font-body-md text-body-md text-on-surface-variant flex-grow">Data-driven insights and strategic modelling for sustainable wealth generation.</p>
          <div class="mt-stack-sm font-label-md text-label-md text-primary flex items-center gap-1 group">
            Learn more <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
          </div>
        </a>
        <!-- Service Card 4: Accredited Training -->
        <a href="training.php" class="bg-surface-container-lowest border border-outline-variant rounded p-gutter top-accent hover-lift flex flex-col h-full no-underline">
          <div class="w-12 h-12 rounded-full bg-surface-container-low flex items-center justify-center mb-stack-sm text-primary">
            <span class="material-symbols-outlined text-[24px]" aria-hidden="true">local_library</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-unit">Accredited Training</h3>
          <p class="font-body-md text-body-md text-on-surface-variant flex-grow">Industry-recognised certification programmes designed for future financial leaders.</p>
          <div class="mt-stack-sm font-label-md text-label-md text-primary flex items-center gap-1 group">
            Learn more <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- MD Spotlight -->
  <section class="py-stack-lg bg-surface-container-low border-b border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div style="display:grid; grid-template-columns:auto 1fr; gap:24px; align-items:center; max-width:56rem; margin:0 auto;">
        <div style="flex-shrink:0; width:500px;">
          <div style="width:500px; border-radius:16px; overflow:hidden; border:1px solid rgba(255,255,255,0.12); box-shadow:0 1px 3px rgba(0,0,0,0.2);">
            <img src="assets/images/ceo-2.png" alt="Chartered Business Accountant in Practice (CBAP) of Professional Financial &amp; Training Solutions" style="width:500px; height:500px; object-fit:cover; object-position:center top; display:block;">
          </div>
        </div>
        <div class="flex flex-col gap-stack-md">
          <p class="font-label-md text-label-md text-on-tertiary-container uppercase tracking-widest">Leadership</p>
          <h2 class="font-headline-lg text-headline-lg text-primary">Chartered Business Accountant in Practice (CBAP)</h2>
          <p class="font-body-lg text-body-lg text-on-surface-variant">
            With over 18 years of experience in the financial services industry, our principal brings unmatched expertise in accounting, tax compliance, and strategic advisory. Holder of CBAP SA, ATO SA, and TTP SA credentials, leading a dedicated practice of 4 professionals.
          </p>
          <div class="flex flex-wrap gap-3 mt-unit">
            <span class="font-label-md text-label-md text-on-primary bg-primary-container px-3 py-1 rounded">CBAP SA</span>
            <span class="font-label-md text-label-md text-on-primary bg-primary-container px-3 py-1 rounded">ATO SA</span>
            <span class="font-label-md text-label-md text-on-primary bg-primary-container px-3 py-1 rounded">TTP SA</span>
            <span class="font-label-md text-label-md text-primary bg-surface-container-high border border-outline-variant px-3 py-1 rounded font-bold">Total Employees: 4 (1 Principal + 3 Consultants)</span>
          </div>
          <div class="pt-2 flex flex-wrap items-center gap-4">
            <a href="https://wa.me/27825406032" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20ba5a] text-white px-5 py-2.5 rounded font-label-md text-label-md font-medium transition-all shadow-sm hover:shadow active:scale-95" aria-label="Message our principal directly on WhatsApp">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current shrink-0" aria-hidden="true">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.28-2.42 5.84a8.19 8.19 0 0 1-5.82 2.41h-.01c-1.49 0-2.95-.4-4.23-1.16l-.3-.18-3.12.82.83-3.04-.2-.31a8.188 8.188 0 0 1-1.25-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.8 11.66c-.26-.13-1.56-.77-1.8-.86-.24-.09-.42-.13-.6.13-.17.26-.69.86-.84 1.04-.16.17-.31.2-.58.07-.26-.13-1.12-.41-2.13-1.31-.79-.7-1.32-1.57-1.48-1.83-.16-.26-.02-.4.11-.53.12-.12.26-.31.39-.46.13-.16.17-.26.26-.44.09-.17.04-.33-.02-.46-.07-.13-.6-1.45-.83-1.99-.22-.52-.45-.45-.61-.46h-.52c-.18 0-.46.07-.7.33-.24.26-.92.9-.92 2.2 0 1.3 0.95 2.56 1.08 2.74.13.17 1.87 2.85 4.52 4 0.63 0.27 1.12 0.44 1.5 0.56 0.63 0.2 1.21 0.17 1.66 0.1 0.51-.08 1.56-.64 1.78-1.25.22-.62.22-1.15.15-1.26-.06-.11-.24-.18-.5-.31z"/>
              </svg>
              <span>Message Her Directly</span>
            </a>
          </div>
          <a href="about.php" class="font-label-md text-label-md text-primary flex items-center gap-2 mt-unit hover:underline group">
            Read our full story <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer CTA -->
  <section class="w-full py-stack-lg bg-primary-container">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop text-center">
      <h2 class="font-headline-lg text-headline-lg mb-4 text-on-primary">Ready for precision?</h2>
      <p class="font-body-lg text-body-lg mb-2 max-w-2xl mx-auto text-on-primary-container">Secure your financial architecture with our expert advisory team. Let us discuss your compliance requirements.</p>
      <p class="font-label-md text-label-md mb-stack-md text-on-primary font-bold">Consultation Fee: R750 per hour</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="booking.php" class="inline-block font-label-md text-label-md bg-tertiary-fixed text-on-tertiary-fixed px-8 py-4 rounded hover:bg-tertiary-fixed-dim transition-colors">Book a Consultation</a>
        <a href="contact.php" class="inline-block font-label-md text-label-md border-2 border-on-primary text-on-primary px-8 py-4 rounded hover:bg-primary-container hover:text-on-primary transition-colors">Contact Us</a>
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

