<?php
require_once __DIR__ . '/backend/includes/csrf.php';
$csrfToken = getCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Training &amp; Courses — Financial Precision</title>
  <meta name="description" content="Accredited financial training courses for accounting, tax, and audit professionals. ATO & TTP certified programmes with CPE credits.">
  <link rel="stylesheet" href="assets/css/styles.css">
  <script src="assets/js/main.js" defer></script>
  <style>
    .hover-lift { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-lift:hover { transform: translateY(-4px); box-shadow: 0 10px 25px -5px rgba(15,27,51,0.04); }
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
      <a href="training.php" class="font-label-md text-label-md text-primary border-b-2 border-on-tertiary-fixed-variant pb-1">Training</a>
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
    <a href="training.php" class="font-label-md text-label-md text-primary font-bold py-2">Training</a>
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

  <!-- Hero Section -->
  <section class="relative pt-6 pb-10 md:pt-10 md:pb-14 px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center">
      <div class="lg:col-span-7 space-y-stack-md">
        <h1 class="font-display-lg-mobile text-display-lg-mobile md:font-display-lg md:text-display-lg text-primary">Elevate Your<br>Professional Edge.</h1>
        <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
          Accredited financial training programmes designed for accounting, tax, and audit professionals seeking to maintain compliance and elevate technical expertise. ATO and TTP certified courses with CPE credits.
        </p>
        <div class="flex flex-col sm:flex-row gap-unit mt-stack-md">
          <a href="#courses" class="bg-primary-container text-on-primary px-gutter py-3 rounded font-label-md text-label-md hover:opacity-90 transition-opacity text-center">Browse Course Catalog</a>
          <a href="#sign-up" class="border border-primary text-primary px-gutter py-3 rounded font-label-md text-label-md hover:bg-surface-container-low transition-colors text-center">Sign Up Now</a>
        </div>
      </div>
      <div class="lg:col-span-5 h-64 lg:h-96 w-full relative bg-surface-container-low border border-outline-variant overflow-hidden rounded">
        <img src="assets/images/Training.png" alt="Professional financial training session at Financial Precision" class="object-cover w-full h-full">
        <div class="absolute inset-0 bg-gradient-to-t from-surface via-transparent to-transparent opacity-50"></div>
      </div>
    </div>
  </section>

  <!-- Trust Strip -->
  <section class="py-stack-md bg-surface-container-lowest border-y border-outline-variant">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
      <div class="flex flex-wrap justify-center items-center gap-4 md:gap-gutter text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">verified</span>
          <span>ATO Certified</span>
        </div>
        <div class="hidden md:block w-px h-6 bg-outline-variant" aria-hidden="true"></div>
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
          <span>TTP Accredited</span>
        </div>
        <div class="hidden md:block w-px h-6 bg-outline-variant" aria-hidden="true"></div>
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">school</span>
          <span>CPE Credits Available</span>
        </div>
        <div class="hidden md:block w-px h-6 bg-outline-variant" aria-hidden="true"></div>
        <div class="flex items-center gap-unit">
          <span class="material-symbols-outlined" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">groups</span>
          <span>1,200+ Professionals Trained</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Bento Grid: Course Catalog -->
  <section id="courses" class="py-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <div class="text-center mb-stack-lg max-w-3xl mx-auto">
      <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Course Catalog</h2>
      <p class="font-body-md text-body-md text-on-surface-variant">Select from our comprehensive range of accredited programmes, each designed with rigorous methodological foundations for maximum professional impact.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

      <!-- Course 1: Advanced Tax Compliance -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex flex-col flex-grow">
          <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
              <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">receipt_long</span>
            </div>
            <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">16 CPE</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Advanced Tax Compliance</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mb-6 text-sm flex-grow">
            In-depth analysis of South African tax legislation, including Income Tax Act amendments, VAT interpretations, and transfer pricing methodologies.
          </p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">Intermediate</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">5 Days</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">R8,500</span>
          </div>
          <a href="#sign-up" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded text-center block">Enrol Now</a>
        </div>
      </article>

      <!-- Course 2: Statistical Techniques for Auditors -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex flex-col flex-grow">
          <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
              <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">query_stats</span>
            </div>
            <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">24 CPE</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Statistical Techniques for Auditors</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mb-6 text-sm flex-grow">
            Quantitative methodologies for audit sampling, risk assessment, and substantive testing. Includes regression analysis and probability distributions.
          </p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">Advanced</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">7 Days</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">R12,500</span>
          </div>
          <a href="#sign-up" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded text-center block">Enrol Now</a>
        </div>
      </article>

      <!-- Course 3: Financial Reporting Standards -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex flex-col flex-grow">
          <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
              <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">analytics</span>
            </div>
            <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">20 CPE</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Financial Reporting Standards</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mb-6 text-sm flex-grow">
            Comprehensive review of IFRS for SMEs, IAS/IFRS updates, and South African GRAP standards. Practical application workshops included.
          </p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">Intermediate</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">6 Days</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">R10,500</span>
          </div>
          <a href="#sign-up" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded text-center block">Enrol Now</a>
        </div>
      </article>

      <!-- Course 4: Anti-Money Laundering Compliance -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex flex-col flex-grow">
          <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
              <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">gavel</span>
            </div>
            <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">12 CPE</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Anti-Money Laundering Compliance</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mb-6 text-sm flex-grow">
            FICA/FINICA regulatory framework, client due diligence, suspicious transaction reporting, and compliance officer responsibilities.
          </p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">All Levels</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">4 Days</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">R6,500</span>
          </div>
          <a href="#sign-up" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded text-center block">Enrol Now</a>
        </div>
      </article>

      <!-- Course 5: Internal Audit Methodologies -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex flex-col flex-grow">
          <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
              <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">fact_check</span>
            </div>
            <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">18 CPE</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Internal Audit Methodologies</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mb-6 text-sm flex-grow">
            Risk-based audit planning, control testing frameworks, and reporting standards aligned with IIA guidelines and King IV governance principles.
          </p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">Intermediate</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">5 Days</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">R9,000</span>
          </div>
          <a href="#sign-up" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded text-center block">Enrol Now</a>
        </div>
      </article>

      <!-- Course 6: Corporate Governance & King IV -->
      <article class="bg-surface border border-outline-variant rounded relative group hover:-translate-y-1 transition-transform duration-300 flex flex-col h-full hover:shadow-[0_20px_40px_-15px_rgba(15,27,51,0.04)] hover:border-tertiary-fixed overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-[2px] bg-tertiary-fixed opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="p-6 md:p-8 flex flex-col flex-grow">
          <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-surface-container flex items-center justify-center rounded border border-outline-variant group-hover:border-tertiary-fixed transition-colors">
              <span class="material-symbols-outlined text-primary text-2xl" aria-hidden="true">balance</span>
            </div>
            <span class="px-3 py-1 bg-surface-container border border-outline-variant rounded font-label-md text-label-md text-on-surface-variant uppercase tracking-widest text-[10px]">14 CPE</span>
          </div>
          <h3 class="font-headline-md text-headline-md text-primary mb-3">Corporate Governance &amp; King IV</h3>
          <p class="font-body-md text-body-md text-on-surface-variant mb-6 text-sm flex-grow">
            King IV application, ESG reporting, board effectiveness evaluations, and integrated thinking frameworks for organisational sustainability.
          </p>
          <div class="flex flex-wrap gap-2 mb-6">
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">All Levels</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">4 Days</span>
            <span class="px-2 py-1 bg-surface-container-lowest border border-outline-variant rounded text-[10px] uppercase tracking-widest text-on-surface-variant font-label-md">R7,500</span>
          </div>
          <a href="#sign-up" class="w-full font-label-md text-label-md px-6 py-3 border border-primary text-primary hover:bg-primary hover:text-on-primary transition-colors rounded text-center block">Enrol Now</a>
        </div>
      </article>

    </div>
  </section>

  <!-- Accreditation Pathway CTA -->
  <section class="py-stack-lg bg-primary-container">
    <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop text-center">
      <div class="max-w-3xl mx-auto">
        <span class="material-symbols-outlined text-on-primary text-5xl mb-4 block" aria-hidden="true" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
        <h2 class="font-headline-lg text-headline-lg text-on-primary mb-4">Accreditation Pathway</h2>
        <p class="font-body-lg text-body-lg text-on-primary opacity-90 mb-stack-md">
          Our programmes are aligned with SAICA, SAIPA, and IRBA CPD requirements. Complete any course to earn CPE credits towards your annual professional development obligations. Custom corporate training packages available for teams of 5+.
        </p>
        <div class="flex flex-col sm:flex-row gap-unit justify-center">
          <a href="contact.php" class="bg-on-primary text-primary px-gutter py-3 rounded font-label-md text-label-md hover:opacity-90 transition-opacity font-bold">Request Corporate Package</a>
          <a href="booking.php" class="border border-on-primary text-on-primary px-gutter py-3 rounded font-label-md text-label-md hover:bg-on-primary hover:text-primary transition-colors">Book a Consultation</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Sign Up Form -->
  <section id="sign-up" class="py-stack-lg px-margin-mobile md:px-margin-desktop max-w-container-max mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
      <!-- Left: Form -->
      <div class="lg:col-span-7">
        <h2 class="font-headline-lg text-headline-lg text-primary mb-4">Course Sign-Up</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mb-stack-md">Complete the form below to register for a course. Our training coordinator will confirm availability and send payment details within 24 hours.</p>

        <form data-validate data-form-type="training" data-handler="backend/handlers/training-handler.php" class="space-y-6">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="form-group">
              <label for="first-name" class="font-label-md text-label-md text-on-surface block mb-2">First Name *</label>
              <input type="text" id="first-name" name="first-name" required class="w-full px-4 py-3 bg-surface border border-outline-variant rounded font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary transition-colors">
              <span class="error-msg">Please enter your first name</span>
            </div>
            <div class="form-group">
              <label for="last-name" class="font-label-md text-label-md text-on-surface block mb-2">Last Name *</label>
              <input type="text" id="last-name" name="last-name" required class="w-full px-4 py-3 bg-surface border border-outline-variant rounded font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary transition-colors">
              <span class="error-msg">Please enter your last name</span>
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="form-group">
              <label for="email" class="font-label-md text-label-md text-on-surface block mb-2">Email Address *</label>
              <input type="email" id="email" name="email" required class="w-full px-4 py-3 bg-surface border border-outline-variant rounded font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary transition-colors">
              <span class="error-msg">Please enter a valid email address</span>
            </div>
            <div class="form-group">
              <label for="phone" class="font-label-md text-label-md text-on-surface block mb-2">Phone Number *</label>
              <input type="tel" id="phone" name="phone" required class="w-full px-4 py-3 bg-surface border border-outline-variant rounded font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary transition-colors">
              <span class="error-msg">Please enter your phone number</span>
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="form-group">
              <label for="company" class="font-label-md text-label-md text-on-surface block mb-2">Company / Organisation</label>
              <input type="text" id="company" name="company" class="w-full px-4 py-3 bg-surface border border-outline-variant rounded font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary transition-colors">
            </div>
            <div class="form-group">
              <label for="designation" class="font-label-md text-label-md text-on-surface block mb-2">Professional Designation</label>
              <select id="designation" name="designation" class="w-full px-4 py-3 bg-surface border border-outline-variant rounded font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary transition-colors">
                <option value="">Select designation</option>
                <option value="ca">CA(SA)</option>
                <option value="cta">CTA</option>
                <option value="acca">ACCA</option>
                <option value="saipa">SAIPA</option>
                <option value="ira">IRBA Registered Auditor</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="course-select" class="font-label-md text-label-md text-on-surface block mb-2">Select Course *</label>
            <select id="course-select" name="course" required class="w-full px-4 py-3 bg-surface border border-outline-variant rounded font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary transition-colors">
              <option value="">Choose a course</option>
              <option value="tax-compliance">Advanced Tax Compliance — R8,500 (16 CPE)</option>
              <option value="statistical-techniques">Statistical Techniques for Auditors — R12,500 (24 CPE)</option>
              <option value="financial-reporting">Financial Reporting Standards — R10,500 (20 CPE)</option>
              <option value="aml">Anti-Money Laundering Compliance — R6,500 (12 CPE)</option>
              <option value="internal-audit">Internal Audit Methodologies — R9,000 (18 CPE)</option>
              <option value="corporate-governance">Corporate Governance &amp; King IV — R7,500 (14 CPE)</option>
            </select>
            <span class="error-msg">Please select a course</span>
          </div>
          <div class="form-group">
            <label for="message" class="font-label-md text-label-md text-on-surface block mb-2">Additional Notes</label>
            <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 bg-surface border border-outline-variant rounded font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary transition-colors resize-vertical" placeholder="Any special requirements or questions..."></textarea>
          </div>
          <div>
            <button type="submit" class="bg-primary-container text-on-primary px-gutter py-3 rounded font-label-md text-label-md hover:opacity-90 transition-opacity font-bold cursor-pointer">Submit Registration</button>
          </div>
        </form>
        <div class="form-message hidden mt-6 p-4 rounded text-center font-body-md text-body-md" role="alert"></div>
      </div>

      <!-- Right: Info Sidebar -->
      <div class="lg:col-span-5 space-y-gutter">
        <!-- Upcoming Sessions -->
        <div class="bg-surface-container-lowest border border-outline-variant p-6">
          <h3 class="font-headline-md text-headline-md text-primary mb-4 flex items-center">
            <span class="material-symbols-outlined mr-3 text-on-surface-variant" aria-hidden="true">calendar_month</span>
            Upcoming Sessions
          </h3>
          <div class="space-y-4">
            <div class="border-b border-outline-variant pb-4">
              <span class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider mb-1">September 2026</span>
              <span class="font-body-md text-body-md text-on-surface">Advanced Tax Compliance</span>
              <span class="font-body-sm text-body-sm text-on-surface-variant block">8–12 Sep · Johannesburg</span>
            </div>
            <div class="border-b border-outline-variant pb-4">
              <span class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider mb-1">October 2026</span>
              <span class="font-body-md text-body-md text-on-surface">Statistical Techniques for Auditors</span>
              <span class="font-body-sm text-body-sm text-on-surface-variant block">5–11 Oct · Johannesburg</span>
            </div>
            <div class="border-b border-outline-variant pb-4">
              <span class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider mb-1">November 2026</span>
              <span class="font-body-md text-body-md text-on-surface">Financial Reporting Standards</span>
              <span class="font-body-sm text-body-sm text-on-surface-variant block">2–7 Nov · Johannesburg</span>
            </div>
            <div>
              <span class="font-label-md text-label-md text-on-surface-variant block uppercase tracking-wider mb-1">November 2026</span>
              <span class="font-body-md text-body-md text-on-surface">Anti-Money Laundering Compliance</span>
              <span class="font-body-sm text-body-sm text-on-surface-variant block">16–19 Nov · Johannesburg</span>
            </div>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-surface border border-outline-variant p-6">
          <h3 class="font-headline-md text-headline-md text-primary mb-4 flex items-center">
            <span class="material-symbols-outlined mr-3 text-on-surface-variant" aria-hidden="true">support_agent</span>
            Training Enquiries
          </h3>
          <div class="space-y-3 font-body-md text-body-md text-on-surface-variant">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-primary" aria-hidden="true">call</span>
              <a href="tel:+27825406032" class="hover:text-primary transition-colors">+27 82 540 6032</a>
            </div>
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-primary" aria-hidden="true">mail</span>
              <a href="mailto:info@moshmokbusinessenter-prise.me" class="hover:text-primary transition-colors">info@moshmokbusinessenter-prise.me</a>
            </div>
            <div class="flex items-center gap-3">
              <span class="text-[#25D366] shrink-0" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4 h-4 fill-current" aria-hidden="true">
                  <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm.01 1.67c4.54 0 8.24 3.7 8.24 8.24 0 2.2-.86 4.28-2.42 5.84a8.19 8.19 0 0 1-5.82 2.41h-.01c-1.49 0-2.95-.4-4.23-1.16l-.3-.18-3.12.82.83-3.04-.2-.31a8.188 8.188 0 0 1-1.25-4.38c0-4.54 3.7-8.24 8.24-8.24zm4.8 11.66c-.26-.13-1.56-.77-1.8-.86-.24-.09-.42-.13-.6.13-.17.26-.69.86-.84 1.04-.16.17-.31.2-.58.07-.26-.13-1.12-.41-2.13-1.31-.79-.7-1.32-1.57-1.48-1.83-.16-.26-.02-.4.11-.53.12-.12.26-.31.39-.46.13-.16.17-.26.26-.44.09-.17.04-.33-.02-.46-.07-.13-.6-1.45-.83-1.99-.22-.52-.45-.45-.61-.46h-.52c-.18 0-.46.07-.7.33-.24.26-.92.9-.92 2.2 0 1.3 0.95 2.56 1.08 2.74.13.17 1.87 2.85 4.52 4 0.63 0.27 1.12 0.44 1.5 0.56 0.63 0.2 1.21 0.17 1.66 0.1 0.51-.08 1.56-.64 1.78-1.25.22-.62.22-1.15.15-1.26-.06-.11-.24-.18-.5-.31z"/>
                </svg>
              </span>
              <a href="https://wa.me/27825406032" target="_blank" rel="noopener noreferrer" class="text-[#25D366] hover:underline font-semibold transition-colors">Chat on WhatsApp</a>
            </div>
          </div>
        </div>

        <!-- Corporate Training CTA -->
        <div class="bg-tertiary-fixed p-6">
          <h3 class="font-headline-md text-headline-md text-on-tertiary-fixed mb-3">Corporate Training</h3>
          <p class="font-body-md text-body-md text-on-tertiary-fixed opacity-90 mb-4">Custom programmes tailored to your team's specific compliance and development needs. Group discounts available.</p>
          <a href="contact.php" class="bg-on-tertiary-fixed text-tertiary-fixed font-label-md text-label-md px-gutter py-3 rounded hover:opacity-90 transition-opacity inline-block font-bold">Request a Proposal</a>
        </div>
      </div>
    </div>
  </section>

</main>

<!-- Footer -->
<footer class="bg-surface-container-lowest border-t border-outline-variant py-stack-lg">
  <div class="max-w-container-max mx-auto px-margin-mobile md:px-margin-desktop">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-gutter mb-stack-lg">
      <div>
        <span class="font-headline-md text-headline-md font-bold text-primary block mb-4">FINANCIAL PRECISION</span>
        <p class="font-body-sm text-body-sm text-on-surface-variant">Professional Financial &amp; Training Solutions. Your trusted partner for accounting, tax audit, financial advisory and accredited training.</p>
      </div>
      <div>
        <span class="font-label-lg text-label-lg text-on-surface block mb-4 font-bold">Services</span>
        <ul class="space-y-2">
          <li><a href="services.php" class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors">Accounting &amp; Bookkeeping</a></li>
          <li><a href="services.php" class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors">Tax Audit Solutions</a></li>
          <li><a href="services.php" class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors">Financial Advisory</a></li>
          <li><a href="training.php" class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors">Accredited Training</a></li>
        </ul>
      </div>
      <div>
        <span class="font-label-lg text-label-lg text-on-surface block mb-4 font-bold">Company</span>
        <ul class="space-y-2">
          <li><a href="about.php" class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors">About Us</a></li>
          <li><a href="booking.php" class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors">Book Consultation</a></li>
          <li><a href="contact.php" class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors">Contact Us</a></li>
          <li><a href="document-upload.php" class="font-body-sm text-body-sm text-on-surface-variant hover:text-primary transition-colors">Document Upload</a></li>
        </ul>
      </div>
      <div>
        <span class="font-label-lg text-label-lg text-on-surface block mb-4 font-bold">Contact</span>
        <div class="space-y-2 font-body-sm text-body-sm text-on-surface-variant">
          <p class="flex items-start gap-2">
            <span class="material-symbols-outlined text-primary text-sm mt-0.5" aria-hidden="true">call</span>
            <a href="tel:+27825406032" class="hover:text-primary transition-colors">+27 82 540 6032</a>
          </p>
          <p class="flex items-start gap-2">
            <span class="material-symbols-outlined text-primary text-sm mt-0.5" aria-hidden="true">mail</span>
            <a href="mailto:info@moshmokbusinessenter-prise.me" class="hover:text-primary transition-colors">info@moshmokbusinessenter-prise.me</a>
          </p>
          <p class="text-xs text-on-surface-variant mt-4">CBAP SA | ATO SA | TTP SA</p>
        </div>
      </div>
    </div>
    <div class="border-t border-outline-variant pt-6 text-center">
      <p class="font-body-sm text-body-sm text-on-surface-variant text-xs">&copy; 2024 Professional Financial &amp; Training Solutions. All rights reserved.</p>
    </div>
  </div>
</footer>

</body>
</html>
