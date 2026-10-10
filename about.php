<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us — Financial Precision</title>
  <meta name="description" content="Learn about Professional Financial & Training Solutions — our story, values, and the expertise behind our South African practice.">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="css/style.css?v=<?= file_exists(__DIR__ . '/css/style.css') ? filemtime(__DIR__ . '/css/style.css') : time() ?>">
  <script src="assets/js/main.js" defer></script>
  <style>
    .top-accent { border-top: 2px solid #95f6c6; }
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(15,27,51,0.04); }
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
      <a href="index.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Home</a>
      <a href="services.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Services</a>
      <a href="about.php" class="font-label-md text-label-md text-primary border-b-2 border-on-tertiary-fixed-variant pb-1">About</a>
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
    <a href="about.php" class="font-label-md text-label-md text-primary font-bold py-2">About</a>
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
<main>

  <!-- Hero Section -->
  <section class="w-full py-6 md:py-12 border-b border-outline-variant bg-surface">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 md:grid-cols-2 gap-gutter items-center">
      <div class="flex flex-col gap-stack-md">
        <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Our Story</p>
        <h1 class="font-display-lg-mobile text-display-lg-mobile md:font-display-lg md:text-display-lg text-primary">Clarity amidst complexity.</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">
          Founded on the principles of rigorous methodology and uncompromising accuracy, Professional Financial &amp; Training Solutions was established to bring institutional-grade auditing, advisory, and training services to the South African market. We believe that true financial security begins with absolute transparency.
        </p>
      </div>
      <div class="relative h-[400px] w-full rounded overflow-hidden border border-outline-variant">
        <img src="assets/images/boutus.png" alt="About Professional Financial & Training Solutions" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-tr from-surface/20 to-transparent pointer-events-none"></div>
      </div>
    </div>
  </section>

  <!-- Founding Principles -->
  <section class="w-full py-stack-lg bg-surface border-b border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div class="max-w-3xl mx-auto text-center mb-stack-lg">
        <h2 class="font-headline-lg text-headline-lg mb-unit">Our Foundation</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">
          We established this practice on the conviction that every South African business — from emerging enterprises to established institutions — deserves access to the same calibre of financial expertise that was once reserved for only the largest corporations.
        </p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
        <div class="text-center p-gutter border border-outline-variant rounded hover-lift">
          <span class="material-symbols-outlined text-[32px] text-on-primary-container mb-unit block" aria-hidden="true">history</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-unit">18+ Years</h3>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm">Of professional experience in South African financial services</p>
        </div>
        <div class="text-center p-gutter border border-outline-variant rounded hover-lift">
          <span class="material-symbols-outlined text-[32px] text-on-primary-container mb-unit block" aria-hidden="true">verified_user</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-unit">100% Black-Owned</h3>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm">Proudly contributing to transformation in the financial sector</p>
        </div>
        <div class="text-center p-gutter border border-outline-variant rounded hover-lift">
          <span class="material-symbols-outlined text-[32px] text-on-primary-container mb-unit block" aria-hidden="true">school</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-unit">Accredited Training</h3>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm">ATO and TTP accredited professional development programmes</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Core Values (Bento Grid) -->
  <section class="w-full py-stack-lg bg-surface-container-low border-b border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div class="flex flex-col gap-stack-md mb-stack-lg">
        <h2 class="font-headline-lg text-headline-lg">Core Principles</h2>
        <p class="font-body-md text-body-md text-on-surface-variant max-w-2xl">These values guide every engagement, audit, and training programme we deliver.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-unit">
        <!-- Value 1 -->
        <div class="bg-surface p-stack-md border border-outline-variant rounded hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-on-tertiary-fixed-variant transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
          <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
          <span class="material-symbols-outlined text-4xl mb-4 text-on-surface-variant" aria-hidden="true">analytics</span>
          <h3 class="font-headline-md text-headline-md mb-2">Methodical Rigor</h3>
          <p class="font-body-md text-body-md text-on-surface-variant">Every audit and advisory plan is subjected to a multi-layered review process, ensuring zero tolerance for error.</p>
        </div>
        <!-- Value 2 -->
        <div class="bg-surface p-stack-md border border-outline-variant rounded hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-on-tertiary-fixed-variant transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group md:col-span-2">
          <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
          <div class="flex flex-col md:flex-row gap-gutter h-full items-center">
            <div class="flex-1">
              <span class="material-symbols-outlined text-4xl mb-4 text-on-surface-variant" aria-hidden="true">verified_user</span>
              <h3 class="font-headline-md text-headline-md mb-2">Institutional Integrity</h3>
              <p class="font-body-md text-body-md text-on-surface-variant">We operate with the highest ethical standards, maintaining strict independence and confidentiality in all client engagements.</p>
            </div>
            <div class="w-full md:w-1/3 h-32 md:h-full bg-surface-container-high border border-outline-variant rounded flex items-center justify-center">
              <span class="font-stat-lg text-stat-lg text-primary">100%</span>
            </div>
          </div>
        </div>
        <!-- Value 3 -->
        <div class="bg-surface p-stack-md border border-outline-variant rounded hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-on-tertiary-fixed-variant transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group md:col-span-3 flex flex-col md:flex-row justify-between items-center">
          <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
          <div class="max-w-2xl">
            <span class="material-symbols-outlined text-4xl mb-4 text-on-surface-variant" aria-hidden="true">gavel</span>
            <h3 class="font-headline-md text-headline-md mb-2">Regulatory Mastery</h3>
            <p class="font-body-md text-body-md text-on-surface-variant">Continuous adaptation to shifting financial legislation allows us to preemptively safeguard your assets against compliance risks.</p>
          </div>
          <div class="mt-4 md:mt-0 flex gap-4">
            <div class="w-16 h-16 border border-outline-variant rounded-full flex items-center justify-center bg-surface-container-highest text-on-surface-variant">
              <span class="font-label-md text-label-md">CBAP</span>
            </div>
            <div class="w-16 h-16 border border-outline-variant rounded-full flex items-center justify-center bg-surface-container-highest text-on-surface-variant">
              <span class="font-label-md text-label-md">ATO</span>
            </div>
            <div class="w-16 h-16 border border-outline-variant rounded-full flex items-center justify-center bg-surface-container-highest text-on-surface-variant">
              <span class="font-label-md text-label-md">TTP</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- MD Bio Section -->
  <section class="w-full py-stack-lg border-b border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div class="grid grid-cols-1 md:grid-cols-[auto_1fr] gap-8 md:gap-12 items-center max-w-4xl mx-auto">
        <div class="relative w-[120px] max-w-full mx-auto md:mx-0 my-4 p-3 bg-surface-container-lowest border border-outline-variant shadow-sm shrink-0" style="height: 160px; border-radius: 10px;">
          <img src="assets/images/ceo-2.png" alt="Chartered Business Accountant in Practice (CBAP) of Professional Financial and Training Solutions" class="w-full h-full" style="object-fit: cover; object-position: center top; border-radius: 8px;">
        </div>
        <div class="flex flex-col gap-stack-md">
          <p class="font-label-md text-label-md text-on-tertiary-container uppercase tracking-widest">Leadership</p>
          <h2 class="font-headline-lg text-headline-lg text-primary">Chartered Business Accountant in Practice (CBAP)</h2>
          <p class="font-body-md text-body-md text-on-surface-variant">
            With over 18 years of dedicated experience in accounting, tax audit, and financial advisory, our principal has built a practice rooted in precision and integrity. She holds multiple professional credentials including CBAP SA (Certified Business Advisor Professional), ATO SA (Accredited Tax Officer), and TTP SA (Tax Technician Professional).
          </p>
          <p class="font-body-md text-body-md text-on-surface-variant">
            Her vision for the firm centres on making institutional-grade financial services accessible to all South African businesses, while developing the next generation of financial professionals through accredited training programmes.
          </p>
          <div class="flex flex-wrap gap-3 mt-unit">
            <span class="font-label-md text-label-md text-on-primary bg-primary-container px-3 py-1 rounded">CBAP SA</span>
            <span class="font-label-md text-label-md text-on-primary bg-primary-container px-3 py-1 rounded">ATO SA</span>
            <span class="font-label-md text-label-md text-on-primary bg-primary-container px-3 py-1 rounded">TTP SA</span>
            <span class="font-label-md text-label-md text-primary bg-surface-container-high border border-outline-variant px-3 py-1 rounded font-bold">Total Employees: 4 (1 Principal + 3 Consultants)</span>
          </div>
          <div class="pt-2">
            <a href="https://wa.me/27825406032" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20ba5a] text-white px-5 py-2.5 rounded font-label-md text-label-md font-medium transition-all shadow-sm hover:shadow active:scale-95" aria-label="Message our principal directly on WhatsApp">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 fill-current shrink-0" aria-hidden="true">
                <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.28-2.42 5.84a8.19 8.19 0 0 1-5.82 2.41h-.01c-1.49 0-2.95-.4-4.23-1.16l-.3-.18-3.12.82.83-3.04-.2-.31a8.188 8.188 0 0 1-1.25-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.8 11.66c-.26-.13-1.56-.77-1.8-.86-.24-.09-.42-.13-.6.13-.17.26-.69.86-.84 1.04-.16.17-.31.2-.58.07-.26-.13-1.12-.41-2.13-1.31-.79-.7-1.32-1.57-1.48-1.83-.16-.26-.02-.4.11-.53.12-.12.26-.31.39-.46.13-.16.17-.26.26-.44.09-.17.04-.33-.02-.46-.07-.13-.6-1.45-.83-1.99-.22-.52-.45-.45-.61-.46h-.52c-.18 0-.46.07-.7.33-.24.26-.92.9-.92 2.2 0 1.3 0.95 2.56 1.08 2.74.13.17 1.87 2.85 4.52 4 0.63 0.27 1.12 0.44 1.5 0.56 0.63 0.2 1.21 0.17 1.66 0.1 0.51-.08 1.56-.64 1.78-1.25.22-.62.22-1.15.15-1.26-.06-.11-.24-.18-.5-.31z"/>
              </svg>
              <span>Message Her Directly</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Company Team Section -->
  <section class="w-full py-stack-lg bg-surface border-b border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div class="max-w-3xl mx-auto text-center mb-stack-lg">
        <p class="font-label-md text-label-md text-on-tertiary-container uppercase tracking-widest mb-2">Practice Structure</p>
        <h2 class="font-headline-lg text-headline-lg text-primary mb-unit">Company Team</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mb-4">
          A dedicated, precision-focused team structured to provide direct partner and consultant-level engagement.
        </p>
        <div class="inline-flex items-center gap-3 px-4 py-2 rounded bg-surface-container-low border border-outline-variant flex-wrap justify-center">
          <span class="font-label-md text-label-md text-primary font-bold">Total Employees: 4</span>
          <span class="text-on-surface-variant/40 hidden sm:inline">•</span>
          <span class="font-label-md text-label-md text-on-surface-variant font-medium">Team Structure: 1 Principal + 3 Consultants</span>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter max-w-5xl mx-auto">
        <!-- Employee 1: Chartered Business Accountant in Practice (CBAP) -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded p-6 hover-lift text-center flex flex-col items-center">
          <div class="w-16 h-16 rounded-full bg-primary-container text-on-primary flex items-center justify-center mb-4">
            <span class="material-symbols-outlined text-[32px]" aria-hidden="true">badge</span>
          </div>
          <span class="font-label-md text-label-md text-on-tertiary-container uppercase text-xs mb-1">Executive Leadership</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-1">Chartered Business Accountant in Practice (CBAP)</h3>
          <p class="font-label-md text-label-md text-tertiary-fixed-dim font-bold mb-3">Principal &amp; Practice Owner</p>
          <p class="font-body-sm text-body-sm text-on-surface-variant mb-4">Practice leadership, executive oversight, and strategic financial advisory.</p>
          <a href="https://wa.me/27825406032" target="_blank" rel="noopener noreferrer" class="mt-auto inline-flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#20ba5a] text-white px-4 py-2 rounded font-label-md text-xs font-semibold transition-all shadow-sm hover:shadow active:scale-95 w-full" aria-label="Message our principal directly on WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current shrink-0" aria-hidden="true">
              <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.28-2.42 5.84a8.19 8.19 0 0 1-5.82 2.41h-.01c-1.49 0-2.95-.4-4.23-1.16l-.3-.18-3.12.82.83-3.04-.2-.31a8.188 8.188 0 0 1-1.25-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.8 11.66c-.26-.13-1.56-.77-1.8-.86-.24-.09-.42-.13-.6.13-.17.26-.69.86-.84 1.04-.16.17-.31.2-.58.07-.26-.13-1.12-.41-2.13-1.31-.79-.7-1.32-1.57-1.48-1.83-.16-.26-.02-.4.11-.53.12-.12.26-.31.39-.46.13-.16.17-.26.26-.44.09-.17.04-.33-.02-.46-.07-.13-.6-1.45-.83-1.99-.22-.52-.45-.45-.61-.46h-.52c-.18 0-.46.07-.7.33-.24.26-.92.9-.92 2.2 0 1.3 0.95 2.56 1.08 2.74.13.17 1.87 2.85 4.52 4 0.63 0.27 1.12 0.44 1.5 0.56 0.63 0.2 1.21 0.17 1.66 0.1 0.51-.08 1.56-.64 1.78-1.25.22-.62.22-1.15.15-1.26-.06-.11-.24-.18-.5-.31z"/>
            </svg>
            <span>Message Her Directly</span>
          </a>
        </div>

        <!-- Employee 2: Consultant 1 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded p-6 hover-lift text-center flex flex-col items-center">
          <div class="w-16 h-16 rounded-full bg-surface-container-high text-primary flex items-center justify-center mb-4 border border-outline-variant">
            <span class="material-symbols-outlined text-[32px]" aria-hidden="true">account_balance</span>
          </div>
          <span class="font-label-md text-label-md text-on-tertiary-container uppercase text-xs mb-1">Advisory</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-1">Consultant 1</h3>
          <p class="font-label-md text-label-md text-primary font-bold mb-3">Consultant</p>
          <p class="font-body-sm text-body-sm text-on-surface-variant">Financial accounting systems, management reporting, and advisory services.</p>
        </div>

        <!-- Employee 3: Consultant 2 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded p-6 hover-lift text-center flex flex-col items-center">
          <div class="w-16 h-16 rounded-full bg-surface-container-high text-primary flex items-center justify-center mb-4 border border-outline-variant">
            <span class="material-symbols-outlined text-[32px]" aria-hidden="true">receipt_long</span>
          </div>
          <span class="font-label-md text-label-md text-on-tertiary-container uppercase text-xs mb-1">Compliance</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-1">Consultant 2</h3>
          <p class="font-label-md text-label-md text-primary font-bold mb-3">Consultant</p>
          <p class="font-body-sm text-body-sm text-on-surface-variant">Tax compliance, SARS audit preparation, and corporate tax structuring.</p>
        </div>

        <!-- Employee 4: Consultant 3 -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded p-6 hover-lift text-center flex flex-col items-center">
          <div class="w-16 h-16 rounded-full bg-surface-container-high text-primary flex items-center justify-center mb-4 border border-outline-variant">
            <span class="material-symbols-outlined text-[32px]" aria-hidden="true">trending_up</span>
          </div>
          <span class="font-label-md text-label-md text-on-tertiary-container uppercase text-xs mb-1">Consultancy</span>
          <h3 class="font-headline-md text-headline-md text-primary mb-1">Consultant 3</h3>
          <p class="font-label-md text-label-md text-primary font-bold mb-3">Consultant</p>
          <p class="font-body-sm text-body-sm text-on-surface-variant">Corporate governance, internal reviews, and client business consultation.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="w-full py-stack-lg bg-primary-container">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop text-center">
      <h2 class="font-headline-lg text-headline-lg mb-4 text-on-primary">Ready for precision?</h2>
      <p class="font-body-lg text-body-lg mb-2 max-w-2xl mx-auto text-on-primary-container">Secure your financial architecture with our expert advisory team. Let us discuss your compliance requirements.</p>
      <p class="font-label-md text-label-md mb-stack-md text-on-primary font-bold">Consultation Fee: R750 per hour</p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="booking.php" class="inline-block font-label-md text-label-md bg-tertiary-fixed text-on-tertiary-fixed px-8 py-4 rounded hover:bg-tertiary-fixed-dim transition-colors">Work With Us</a>
        <a href="contact.php" class="inline-block font-label-md text-label-md border-2 border-on-primary text-on-primary px-8 py-4 rounded hover:bg-primary-container transition-colors">Contact Us</a>
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
      <p class="font-label-md text-label-md text-on-primary-container"><a href="tel:+27825406032" class="hover:text-on-primary hover:underline transition-all">+27 82 540 6032</a></p>
      <p class="font-label-md text-label-md text-on-primary-container"><a href="mailto:info@moshmokbusinessenter-prise.me" class="hover:text-on-primary hover:underline transition-all break-all">info@moshmokbusinessenter-prise.me</a></p>
      <p class="font-body-md text-body-md text-on-primary-container text-sm mt-4">CBAP SA | ATO SA | TTP SA</p>
    </div>
  </div>
  <div class="px-margin-mobile md:px-margin-desktop py-4 bg-[#0A1324] text-center border-t border-on-primary-fixed-variant">
    <p class="font-body-md text-body-md text-on-primary-container text-xs">&copy; 2025 Professional Financial &amp; Training Solutions. All rights reserved.</p>
  </div>
</footer>

</body>
</html>

