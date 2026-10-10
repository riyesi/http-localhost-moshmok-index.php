<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services � Financial Precision</title>
  <meta name="description" content="Comprehensive accounting, tax audit, financial advisory and accredited training services in South Africa.">
  <link rel="stylesheet" href="assets/css/styles.css">
  <link rel="stylesheet" href="css/style.css?v=<?= file_exists(__DIR__ . '/css/style.css') ? filemtime(__DIR__ . '/css/style.css') : time() ?>">
  <script src="assets/js/main.js" defer></script>
  <style>
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -15px rgba(15,27,51,0.04); border-color: #95f6c6; }
    #mobile-nav { transform: translateX(100%); transition: transform 0.3s ease; display: flex; }
    #mobile-nav.open { transform: translateX(0); }
    #mobile-nav-overlay { opacity: 0; pointer-events: none; transition: opacity 0.3s ease; }
    #mobile-nav-overlay.open { opacity: 1; pointer-events: auto; }
    .icon-close { display: none; }
    .mobile-nav-btn[aria-expanded="true"] .icon-menu { display: none; }
    .mobile-nav-btn[aria-expanded="true"] .icon-close { display: block; }
  </style>
</head>
<body class="bg-surface text-on-surface font-body-lg antialiased min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-surface sticky top-0 z-50 w-full border-b border-outline-variant">
  <div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-unit max-w-container-max mx-auto">
    <a href="index.php" class="font-headline-md text-headline-md font-bold text-primary tracking-tight">FINANCIAL PRECISION</a>
    <nav class="hidden md:flex items-center gap-gutter">
      <a href="index.php" class="font-label-md text-label-md text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low px-unit py-unit rounded">Home</a>
      <a href="services.php" class="font-label-md text-label-md text-primary border-b-2 border-on-tertiary-fixed-variant pb-1">Services</a>
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
    <a href="services.php" class="font-label-md text-label-md text-primary font-bold py-2">Services</a>
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
<main class="flex-grow">

  <!-- Hero Section -->
  <section class="relative pt-6 pb-12 md:pt-10 md:pb-16 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto border-b border-outline-variant">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter items-center">
      <div class="md:col-span-8">
        <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-stack-md leading-tight">
          Comprehensive Financial &amp; Training Solutions
        </h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant mb-stack-lg max-w-2xl">
          Expert methodology applied to modern financial challenges. We deliver precision in accounting, definitive insight in tax strategy, and accredited training for the next generation of financial leaders.
        </p>
        <a href="contact.php" class="font-label-md text-label-md px-8 py-4 bg-tertiary-fixed text-on-tertiary-fixed hover:bg-tertiary-fixed-dim transition-all rounded flex items-center group w-fit">
          Explore Services
          <span class="material-symbols-outlined ml-2 group-hover:translate-x-1 transition-transform" aria-hidden="true">arrow_forward</span>
        </a>
      </div>
      <div class="md:col-span-4 hidden md:block h-[400px] relative">
        <div class="absolute inset-0 bg-surface-container border border-outline-variant rounded overflow-hidden">
          <img src="assets/images/services-hero.jpg" alt="Financial services" class="object-cover w-full h-full">
        </div>
      </div>
    </div>
  </section>

    <!-- Statutory Returns & Compliance Services Section -->
  <section class="border-b border-outline-variant" style="background-color: #f8fafc; padding-top: 5.5rem; padding-bottom: 4.5rem;" aria-labelledby="statutory-compliance-heading">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      
      <!-- Section Header -->
      <div class="max-w-3xl mx-auto flex flex-col items-center justify-center text-center mb-12 md:mb-16">
        <div class="inline-flex items-center justify-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider mb-5 shadow-sm mx-auto" style="background-color: #dcfce7; border: 1px solid #86efac; color: #166534;">
          <span class="material-symbols-outlined text-sm" aria-hidden="true">verified_user</span>
          <span>Our Compliance Services: Statutory Returns</span>
        </div>
        <h2 id="statutory-compliance-heading" class="font-headline-lg text-headline-lg md:text-[38px] md:leading-tight text-primary font-bold mb-4 text-center mx-auto">
          Stay Compliant. Avoid Penalties. We've Got You Covered.
        </h2>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto text-center leading-relaxed">
          Don't let admin headaches derail your business. We handle your South African statutory returns so you can focus on what you do best—growing your company.
        </p>
      </div>

      <!-- 3-Column Compliance Grid -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        <!-- Card 1: SARS Tax Returns -->
        <div class="bg-surface border border-outline-variant rounded-xl p-6 md:p-8 flex flex-col justify-between hover-lift relative group transition-all duration-300 hover:border-[#166534] shadow-sm">
          <div class="absolute top-0 left-0 right-0 h-1 bg-[#166534] rounded-t-xl opacity-80 group-hover:opacity-100 transition-opacity"></div>
          <div>
            <div class="w-12 h-12 rounded-lg bg-[#dcfce7] text-[#166534] flex items-center justify-center mb-5 text-2xl" aria-hidden="true">
              📊
            </div>
            <h3 class="font-headline-md text-headline-md text-primary font-bold mb-3">
              <span><strong>SARS</strong> Tax Returns</span>
            </h3>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-5">
              From VAT and PAYE to Provisional Income Tax, we ensure your submissions to the <strong>South African Revenue Service (SARS)</strong> are accurate and on time. Keep SARS off your back.
            </p>
          </div>
          <div class="pt-4 border-t border-outline-variant/60 mt-auto">
            <a href="https://www.sars.gov.za/contact-us/online-query-system/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#166534] hover:text-[#14532d] hover:underline" title="Guide to the SARS Online Query System (SOQS) on official SARS website">
              <span>Guide to the SARS Online Query System (SOQS)</span>
              <span class="material-symbols-outlined text-[14px]" aria-hidden="true">open_in_new</span>
            </a>
          </div>
        </div>

        <!-- Card 2: CIPC Annual Returns -->
        <div class="bg-surface border border-outline-variant rounded-xl p-6 md:p-8 flex flex-col justify-between hover-lift relative group transition-all duration-300 hover:border-[#166534] shadow-sm">
          <div class="absolute top-0 left-0 right-0 h-1 bg-[#166534] rounded-t-xl opacity-80 group-hover:opacity-100 transition-opacity"></div>
          <div>
            <div class="w-12 h-12 rounded-lg bg-[#dcfce7] text-[#166534] flex items-center justify-center mb-5 text-2xl" aria-hidden="true">
              🏢
            </div>
            <h3 class="font-headline-md text-headline-md text-primary font-bold mb-3">
              <span><strong>CIPC</strong> Annual Returns</span>
            </h3>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-5">
              Keep your company or close corporation legally active. We handle your yearly <strong>CIPC</strong> updates quickly, so you never risk business deregistration or statutory lockouts.
            </p>
          </div>
          <div class="pt-4 border-t border-outline-variant/60 mt-auto">
            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-on-surface-variant">
              <span class="material-symbols-outlined text-[16px] text-tertiary-fixed-dim" aria-hidden="true">check_circle</span>
              Guaranteed CIPC Compliance &amp; Active Status
            </span>
          </div>
        </div>

        <!-- Card 3: Employer Declarations -->
        <div class="bg-surface border border-outline-variant rounded-xl p-6 md:p-8 flex flex-col justify-between hover-lift relative group transition-all duration-300 hover:border-[#166534] shadow-sm">
          <div class="absolute top-0 left-0 right-0 h-1 bg-[#166534] rounded-t-xl opacity-80 group-hover:opacity-100 transition-opacity"></div>
          <div>
            <div class="w-12 h-12 rounded-lg bg-[#dcfce7] text-[#166534] flex items-center justify-center mb-5 text-2xl" aria-hidden="true">
              👥
            </div>
            <h3 class="font-headline-md text-headline-md text-primary font-bold mb-3">
              <span>Employer Declarations</span>
            </h3>
            <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed mb-5">
              Seamless monthly and bi-annual filing for the <strong>Unemployment Insurance Fund (UIF)</strong> and <strong>Skills Development Levy (SDL)</strong>. Keep your workforce compliant without the paperwork.
            </p>
          </div>
          <div class="pt-4 border-t border-outline-variant/60 mt-auto">
            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-on-surface-variant">
              <span class="material-symbols-outlined text-[16px] text-tertiary-fixed-dim" aria-hidden="true">check_circle</span>
              Full UIF &amp; SDL Payroll Alignment
            </span>
          </div>
        </div>

      </div>

      <!-- Why It Matters & Call to Action Banner -->
      <div class="bg-gradient-to-r from-primary to-[#0f172a] text-on-primary rounded-2xl p-6 md:p-10 border border-outline-variant/40 shadow-lg flex flex-col lg:flex-row items-center justify-between gap-6">
        <div class="flex items-start gap-4 max-w-2xl">
          <div class="w-12 h-12 rounded-xl bg-tertiary-fixed/20 border border-tertiary-fixed/40 flex items-center justify-center shrink-0 text-tertiary-fixed mt-1">
            <span class="material-symbols-outlined text-2xl" aria-hidden="true">shield</span>
          </div>
          <div>
            <span class="font-label-md text-xs uppercase tracking-widest text-tertiary-fixed font-bold block mb-1">Why It Matters</span>
            <p class="font-body-lg text-base md:text-lg text-slate-100 leading-relaxed">
              Missing a deadline means heavy fines and legal trouble. We keep your business <strong style="color: #00ff66; font-weight: 800; text-shadow: 0 0 10px rgba(0,255,102,0.3);">💯 100% compliant</strong> so you can operate with total peace of mind.
            </p>
          </div>
        </div>
        <div class="shrink-0 w-full lg:w-auto">
          <a href="contact.php?service=tax_audit" class="inline-flex items-center justify-center gap-2 w-full lg:w-auto px-8 py-4 bg-[#00cc00] hover:bg-[#00e600] active:scale-95 text-[#002200] font-bold font-label-md text-base rounded-xl transition-all shadow-[0_4px_20px_rgba(0,204,0,0.35)] hover:shadow-[0_6px_25px_rgba(0,204,0,0.5)]">
            <span>Get a Free Compliance Quote</span>
            <span class="material-symbols-outlined text-xl" aria-hidden="true">arrow_forward</span>
          </a>
        </div>
      </div>

    </div>
  </section>

<!-- Services Grid -->
  <section class="py-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-stack-lg">
      <!-- Service 1: Accounting -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex-grow">
          <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded mb-6 border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
            <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">account_balance</span>
          </div>
          <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Accounting Services</h2>
          <p class="font-body-md text-body-md text-on-surface-variant mb-6">
            Rigorous, methodical bookkeeping and payroll management designed for high-stakes operational environments. We ensure every transaction is meticulously recorded and reconciled.
          </p>
          <ul class="space-y-3 mb-8">
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-2 text-sm mt-1" aria-hidden="true">check_circle</span>
              <span class="font-body-md text-body-md text-on-surface-variant">Precision Bookkeeping &amp; Reconciliation</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-2 text-sm mt-1" aria-hidden="true">check_circle</span>
              <span class="font-body-md text-body-md text-on-surface-variant">Automated Payroll Management Systems</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-2 text-sm mt-1" aria-hidden="true">check_circle</span>
              <span class="font-body-md text-body-md text-on-surface-variant">Financial Statement Preparation &amp; Review</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-2 text-sm mt-1" aria-hidden="true">check_circle</span>
              <span class="font-body-md text-body-md text-on-surface-variant">Management Accounts &amp; Reporting</span>
            </li>
          </ul>
        </div>
        <div class="px-6 md:px-8 pb-6 md:pb-8 mt-auto">
          <a href="contact.php" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded text-center block">Get a Quote</a>
        </div>
      </article>

      <!-- Service 2: Tax Audit -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex-grow">
          <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded mb-6 border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
            <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">policy</span>
          </div>
          <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Tax Audit Services</h2>
          <p class="font-body-md text-body-md text-on-surface-variant mb-6">
            Authoritative compliance verification and strategic tax planning. Our expert auditors navigate complex SARS regulations to safeguard your financial standing.
          </p>
          <ul class="space-y-3 mb-8">
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-2 text-sm mt-1" aria-hidden="true">check_circle</span>
              <span class="font-body-md text-body-md text-on-surface-variant">Comprehensive SARS Tax Compliance</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-2 text-sm mt-1" aria-hidden="true">check_circle</span>
              <span class="font-body-md text-body-md text-on-surface-variant">Strategic Tax Planning &amp; Structuring</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-2 text-sm mt-1" aria-hidden="true">check_circle</span>
              <span class="font-body-md text-body-md text-on-surface-variant">Audit Defence &amp; SARS Representation</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-2 text-sm mt-1" aria-hidden="true">check_circle</span>
              <span class="font-body-md text-body-md text-on-surface-variant">VAT, PAYE &amp; Corporate Tax Filings</span>
            </li>
          </ul>
        </div>
        <div class="px-6 md:px-8 pb-6 md:pb-8 mt-auto">
          <a href="booking.php" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded text-center block">Schedule an Audit Consultation</a>
        </div>
      </article>

      <!-- Service 3: Financial Advisory (Full Width) -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden lg:col-span-2">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex flex-col md:flex-row gap-8">
          <div class="md:w-1/2">
            <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded mb-6 border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
              <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">trending_up</span>
            </div>
            <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Financial Advisory Services</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mb-6">
              Institutional-grade strategic guidance. We provide fractional CFO services and data-driven insights to steer long-term corporate growth and stability.
            </p>
            <a href="booking.php" class="font-label-md text-label-md px-6 py-3 bg-primary text-on-primary hover:bg-primary-container hover:text-primary transition-colors rounded inline-block text-center w-full md:w-auto">Book a Strategy Session</a>
          </div>
          <div class="md:w-1/2 border-t md:border-t-0 md:border-l border-outline-variant pt-6 md:pt-0 md:pl-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="p-4 bg-surface-container-lowest border border-outline-variant rounded">
              <span class="font-stat-lg text-stat-lg text-primary block mb-2">CFO</span>
              <span class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider">Fractional Services</span>
            </div>
            <div class="p-4 bg-surface-container-lowest border border-outline-variant rounded">
              <span class="font-stat-lg text-stat-lg text-primary block mb-2">M&amp;A</span>
              <span class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider">Strategic Advisory</span>
            </div>
            <div class="p-4 bg-surface-container-lowest border border-outline-variant rounded">
              <span class="font-stat-lg text-stat-lg text-primary block mb-2">Risk</span>
              <span class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider">Management Frameworks</span>
            </div>
            <div class="p-4 bg-surface-container-lowest border border-outline-variant rounded">
              <span class="font-stat-lg text-stat-lg text-primary block mb-2">Cap</span>
              <span class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider">Capital Structuring</span>
            </div>
          </div>
        </div>
      </article>

      <!-- Service 4: Training -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden lg:col-span-2">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex flex-col md:flex-row gap-8">
          <div class="md:w-1/2">
            <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded mb-6 border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
              <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">school</span>
            </div>
            <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Accredited Training</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mb-6">
              Rigorous, methodology-based curricula for financial professionals seeking to maintain compliance and elevate their technical expertise. ATO and TTP accredited programmes.
            </p>
          </div>
          <div class="md:w-1/2 border-t md:border-t-0 md:border-l border-outline-variant pt-6 md:pt-0 md:pl-8 flex flex-col justify-center">
            <div class="flex flex-wrap gap-3 mb-6">
              <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">ATO Certified</span>
              <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">CPE Credits</span>
              <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">TTP Accredited</span>
            </div>
            <a href="training.php" class="font-label-md text-label-md px-6 py-3 bg-primary text-on-primary hover:bg-primary-container hover:text-primary transition-colors rounded inline-block text-center w-full md:w-auto">View Course Catalog</a>
          </div>
        </div>
      </article>
    </div>
  </section>

  <!-- Pricing Section -->
  <section class="py-stack-lg bg-surface-container-lowest border-y border-outline-variant">
    <div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
      <div class="text-center mb-stack-lg max-w-3xl mx-auto">
        <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Transparent Structuring</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Baseline package indications in ZAR. Precision quoting requires a detailed analysis of your operational complexity.</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Tier 1: Essential -->
        <div class="bg-surface border border-outline-variant rounded p-8 flex flex-col relative">
          <h3 class="font-headline-md text-headline-md text-primary mb-2">Essential Compliance</h3>
          <div class="flex items-baseline mb-6">
            <span class="font-stat-lg text-stat-lg text-primary">From R8,500</span>
            <span class="font-body-md text-body-md text-on-surface-variant ml-2">/mo</span>
          </div>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-8 pb-6 border-b border-outline-variant">Baseline bookkeeping and essential tax preparation for streamlined operations.</p>
          <ul class="space-y-4 mb-8 flex-grow">
            <li class="flex items-start">
              <span class="material-symbols-outlined text-outline-variant mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-surface-variant text-sm">Monthly Reconciliation</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-outline-variant mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-surface-variant text-sm">Standard Financial Reporting</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-outline-variant mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-surface-variant text-sm">Annual Tax Preparation</span>
            </li>
          </ul>
          <a href="contact.php" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-surface-container-low transition-colors rounded mt-auto text-center block">Request Detail</a>
        </div>

        <!-- Tier 2: Comprehensive (Featured) -->
        <div class="bg-primary-container border border-primary-container rounded p-8 flex flex-col relative shadow-lg md:-translate-y-4">
          <div class="absolute top-0 left-0 w-full h-1 bg-tertiary-fixed rounded-t"></div>
          <span class="absolute top-0 right-8 -translate-y-1/2 bg-tertiary-fixed text-on-tertiary-fixed font-label-md text-label-md px-3 py-1 rounded-full text-xs">Recommended</span>
          <h3 class="font-headline-md text-headline-md text-on-primary mb-2 mt-2">Comprehensive Advisory</h3>
          <div class="flex items-baseline mb-6">
            <span class="font-stat-lg text-stat-lg text-on-primary">From R24,000</span>
            <span class="font-body-md text-body-md ml-2" style="color: #86efac;">/mo</span>
          </div>
          <p class="font-body-md text-body-md text-sm mb-8 pb-6 border-b border-white/20" style="color: #cbd5e1;">Integrated accounting and strategic advisory for growing entities.</p>
          <ul class="space-y-4 mb-8 flex-grow">
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-sm font-medium" style="color: #ffffff;">Everything in Essential</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-primary text-sm font-medium">Quarterly Strategic Reviews</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-primary text-sm font-medium">Advanced Cash Flow Modelling</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-tertiary-fixed-dim mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-primary text-sm font-medium">Dedicated Account Partner</span>
            </li>
          </ul>
          <a href="booking.php" class="w-full font-label-md text-label-md px-6 py-3 bg-tertiary-fixed text-on-tertiary-fixed hover:bg-tertiary-fixed-dim transition-colors rounded mt-auto text-center block">Request Detail</a>
        </div>

        <!-- Tier 3: Enterprise -->
        <div class="bg-surface border border-outline-variant rounded p-8 flex flex-col relative">
          <h3 class="font-headline-md text-headline-md text-primary mb-2">Enterprise Structuring</h3>
          <div class="flex items-baseline mb-6 mt-2">
            <span class="font-headline-lg text-headline-lg text-primary">Custom</span>
          </div>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-8 pb-6 border-b border-outline-variant">Bespoke financial engineering, full-scale audit defence, and fractional CFO engagement.</p>
          <ul class="space-y-4 mb-8 flex-grow">
            <li class="flex items-start">
              <span class="material-symbols-outlined text-outline-variant mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-surface-variant text-sm">M&amp;A Due Diligence</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-outline-variant mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-surface-variant text-sm">Complex Restructuring</span>
            </li>
            <li class="flex items-start">
              <span class="material-symbols-outlined text-outline-variant mr-3 text-sm mt-1" aria-hidden="true">check</span>
              <span class="font-body-md text-body-md text-on-surface-variant text-sm">Full Board Reporting</span>
            </li>
          </ul>
          <a href="contact.php" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded mt-auto text-center block">Contact for Custom Quote</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Accredited Training Section -->
  <section class="py-stack-lg bg-surface">
    <div class="px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-stack-lg gap-4">
        <div class="max-w-2xl">
          <div class="flex items-center space-x-4 mb-4">
            <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">ATO Certified</span>
            <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">CPE Credits</span>
          </div>
          <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Accredited Training Programmes</h2>
          <p class="font-body-md text-body-md text-on-surface-variant">
            Rigorous, methodology-based curricula for financial professionals seeking to maintain compliance and elevate their technical expertise.
          </p>
        </div>
        <a href="training.php" class="font-label-md text-label-md px-8 py-3 bg-tertiary-fixed text-on-tertiary-fixed hover:bg-tertiary-fixed-dim transition-all rounded shadow-sm flex-shrink-0">
          View Full Catalog
        </a>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-surface-container-lowest border border-outline-variant rounded p-6 hover:shadow-[0_10px_30px_-10px_rgba(15,27,51,0.05)] transition-shadow">
          <div class="font-label-md text-label-md text-primary mb-2">MOD-101</div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Advanced Corporate Tax Strategy</h3>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-6">In-depth analysis of contemporary tax structures and compliance frameworks for large-scale entities.</p>
          <div class="flex justify-between items-center border-t border-outline-variant pt-4">
            <span class="font-label-md text-label-md text-on-surface-variant text-xs">8 CPE Credits</span>
            <a href="training.php" class="font-label-md text-label-md text-tertiary-container hover:text-primary transition-colors underline">Enrol Now</a>
          </div>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant rounded p-6 hover:shadow-[0_10px_30px_-10px_rgba(15,27,51,0.05)] transition-shadow">
          <div class="font-label-md text-label-md text-primary mb-2">MOD-204</div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Audit Readiness &amp; Defence Protocol</h3>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-6">Methodical preparation techniques for handling intensive compliance audits with precision.</p>
          <div class="flex justify-between items-center border-t border-outline-variant pt-4">
            <span class="font-label-md text-label-md text-on-surface-variant text-xs">12 CPE Credits</span>
            <a href="training.php" class="font-label-md text-label-md text-tertiary-container hover:text-primary transition-colors underline">Enrol Now</a>
          </div>
        </div>
        <div class="bg-surface-container-lowest border border-outline-variant rounded p-6 hover:shadow-[0_10px_30px_-10px_rgba(15,27,51,0.05)] transition-shadow">
          <div class="font-label-md text-label-md text-primary mb-2">MOD-350</div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Financial Modelling &amp; Forecasting</h3>
          <p class="font-body-md text-body-md text-on-surface-variant text-sm mb-6">Technical instruction on constructing robust financial models for strategic advisory roles.</p>
          <div class="flex justify-between items-center border-t border-outline-variant pt-4">
            <span class="font-label-md text-label-md text-on-surface-variant text-xs">16 CPE Credits</span>
            <a href="training.php" class="font-label-md text-label-md text-tertiary-container hover:text-primary transition-colors underline">Enrol Now</a>
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

