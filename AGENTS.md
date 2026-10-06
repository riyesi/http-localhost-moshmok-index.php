# AGENTS.md — moshmok

Coding-agent context for **Professional Financial & Training Solutions** — a PHP/MySQL practice
website (accounting, tax/audit, financial advisory, accredited training; Johannesburg, South Africa).

Facts below are verified against the current repo. **Verification truth is the Apache/HTTP path,
not PHP CLI** (see "Quirks" — the CLI `php.ini` is polluted).

---

## 1. Environment & Landing

- **XAMPP** at `C:\xampp` — Apache 2.4.58, **PHP 8.2.12 (ZTS, VC2019, x64)**, MariaDB 10.4.32.
- Project docroot: `C:\xampp\htdocs\moshmok`.
- Apache + mysqld are **NOT** Windows services — start manually, in **this order**:
  ```
  Start-Process mysqld
  Start-Process httpd
  ```
- Site URL during local dev: `http://localhost/moshmok/`
- **MySQL:** root / no password, DB `moshmok_db`, charset `utf8mb4`.
- This is **not** a git repo (no `.git`, no `.gitignore`). Keep secrets out of the tree anyway
  (`backend/config/db.php` and `backend/includes/mailer.php` hold placeholders to replace).

### Verified working commands (run from repo root)
- **Lint a PHP file** (see Quirk 1 — CLI ini is polluted but safe for `-l`):
  ```
  php -l path/to/file.php
  ```
- **Import the database schema** (PowerShell `<` redirection is unavailable; use `--execute`):
  ```
  mysql -u root --password= -e "source C:/xampp/htdocs/moshmok/database/schema.sql"
  ```
- **Serve/develop:** no build step required. CSS is prebuilt (see §3).

---

## 2. Architecture

Server-rendered PHP pages + vanilla-JS AJAX forms hitting PHP handlers that return JSON.

```
docroot/
├─ index.php, about.php, services.php, training.php,
│  booking.php, contact.php, document-upload.php, thank-you.php   ← 8 public pages (.php)
├─ assets/
│  ├─ css/styles.css          ← PREBUILT Tailwind output (what the site uses)
│  ├─ css/input.css           ← Tailwind source (only when re-running the build)
│  ├─ fonts/                  ← self-hosted woff2 + Material Symbols ttf
│  ├─ images/                 ← 8 local images
│  └─ js/main.js              ← shared JS: nav, validation, AJAX, file preview
├─ backend/
│  ├─ config/db.php           ← PDO singleton (getDB())
│  ├─ includes/validate.php   ← isValidEmail, isValidPhone, isValidFutureDate, isValidTime, isAllowedFile...
│  ├─ includes/sanitize.php   ← sanitizeString, sanitizeArray, generateToken (unused)
│  ├─ includes/mailer.php     ← sendClientConfirmation, sendPracticeNotification (PHP mail())
│  ├─ handlers/               ← 4 POST JSON endpoints (see §4)
│  └─ uploads/                ← stored files; .htaccess = Require all denied (HTTP 403)
├─ database/schema.sql        ← DDL, 6 tables (idempotent CREATE TABLE IF NOT EXISTS)
├─ package.json, package-lock.json
├─ tailwind.config.js
└─ node_modules/              ← dev-only (Tailwind), present locally
```

### Key invariants
- **No external network calls on any page.** All fonts (DM Sans, Inter, JetBrains Mono, Material
  Symbols), CSS, and the 8 images are self-hosted under `assets/`. Never add a CDN link.
- **All 8 pages are `.php`** — the original `.html` files were deleted. Internal nav links are
  `.php`; do not reintroduce `.html`.
- `thank-you.php` exists but is **unlinked** from any nav (forms are AJAX with in-place messages).
- Backend handler refs from pages are **relative**: `backend/handlers/...` so forms work from
  docroot or a subfolder. Asset paths are also relative.
- Uploads are saved to `backend/uploads/` with a sha256+timerandom+randomhex stored name, MIME and
  extension whitelisted, `move_uploaded_file()`, max 25 MB/file, max 10 files/submission.
- Design: prebuilt Tailwind with a Material color scheme (green `primary-container #002200` /
  `primary-fixed-dim #00cc00`), fonts DM Sans (headline) / Inter (body) / JetBrains Mono (label).
  Dark-mode toggles a class on `<html>`; primary surface `#02010a` header.

---

## 3. Tailwind / CSS (important — was broken by the HTML→PHP conversion)

- The site runs on `assets/css/styles.css` (prebuilt/minified). **No build is needed to run.**
- `tailwind.config.js` has a content glob of `./*.html` **and `./assets/js/**/*.js`** (see
  `content: ['./*.html', './assets/js/**/*.js']`).
- **After the HTML→PHP conversion, `./*.html` matches nothing** (all pages are `.php`). If the
  Tailwind build is ever re-run (`npx tailwindcss -i ./assets/css/input.css -o ./assets/css/styles.css`),
  **update that glob first** to `./*.php` or you will generate a stylesheet with only the JS classes
  and break the pages. Currently `styles.css` is untouched/valid.
- Do not edit `styles.css` by hand for utility classes; edit `input.css`/`tailwind.config.js` and
  rebuild — but only after fixing the content glob.

---

## 4. Form → Handler contract (the API boundary)

`assets/js/main.js` reads each form's `name` attributes and POSTs them as **JSON** (`Content-Type:
application/json`), **except** the upload form which is sent as **multipart FormData**.

Pages carry `data-handler` and `data-form-type` attributes. **`data-form-type="upload"` is the only
one sent as FormData**; all others are JSON.

All 4 handlers:
- Return `Content-Type: application/json; charset=utf-8`.
- Reject non-POST with 405 JSON.
- Parse JSON body, falling back to `$_POST` if `json_decode` fails.
- Validate → 422 JSON on failure; DB error → 500 JSON; success → `{success:true,...}`.
- Insert into MySQL (PDO prepared statements, `ERRMODE_EXCEPTION`), then attempt to email.

| Form (page) | `data-handler` | `data-form-type` | Inputs (`name=` attributes) | Notes |
|---|---|---|---|---|
| contact.php | `backend/handlers/contact-handler.php` | `contact` | `name`, `email`, `phone`, `service`, `message`, `consent`(checkbox) | service whitelist: `accounting\|tax_audit\|advisory\|training\|other` |
| booking.php | `backend/handlers/booking-handler.php` | `booking` | `name`, `email`, `phone`, `consultation_type`, `preferred_date`, `preferred_time`, `message` | `consultation_type` is POSTed, stored in DB column `service_type`. Whitelist: `tax_compliance\|audit_review\|financial_advisory\|accounting_setup\|training_enquiry\|general` |
| training.php | `backend/handlers/training-handler.php` | `training` | **`first-name`, `last-name`** (hyphenated!), `email`, `phone`, `company`, `designation`, `course`, `message` | course whitelist: `tax-compliance\|statistical-techniques\|financial-reporting\|aml\|internal-audit\|corporate-governance` |
| document-upload.php | `backend/handlers/upload-handler.php` | `upload` | files: name=`documents` (`multiple`, accept `.pdf,.doc,.docx,.xls,.xlsx,.csv,.txt,.jpg,.jpeg,.png`), `fee_acknowledge` (checkbox), `name`, `email`, `notes` | R200 fee acknowledged → DB `fee_status='pending'` |

**Contract gotcha:** the input `name` == the exact JSON key the handler reads. Training uses
hyphenated `first-name`/`last-name` (matching its page inputs); booking/contact use camelCase-ish
keys. Never rename the `name` attributes without updating the handler.

### Upload handler specifics
- Accepts **single OR multiple** file uploads: normalises `$_FILES['documents']` (array vs scalar
  `name`) into a uniform list. Keep this normaliser if touched.
- Extension whitelist + MIME whitelist (`finfo`, see `isAllowedFile` in `validate.php`).
- 25 MB per file (`MAX_FILE_SIZE`), max 10 files (`MAX_FILES`).
- Saves to `backend/uploads/`, inserts parent row in `document_uploads` then child rows in
  `document_files` in a transaction (rolls back on PDOException).
- `fee_status` = `'pending'`; a Payment Gateway (PayFast/Yoco) insertion point is commented in
  `upload-handler.php` (toggle to `'paid'` on callback). Not yet implemented.

---

## 5. Database (schema.sql)

6 tables, all `InnoDB`, `utf8mb4`, idempotent `CREATE TABLE IF NOT EXISTS`, wrapped in
`CREATE DATABASE IF NOT EXISTS moshmok_db`:

1. `csrf_tokens` — `token` UNIQUE `VARCHAR(64)`, `created_at`, `expires_at` (nullable).
2. `bookings` — booking requests; `service_type` receives the front-end `consultation_type`;
   `status` ENUM `pending\|confirmed\|cancelled`.
3. `document_uploads` — parent upload record; `fee_status` ENUM `pending\|paid\|waived\|refunded`.
4. `document_files` — child rows, FK→`document_uploads.id` `ON DELETE CASCADE`.
5. `training_signups` — `first_name`, `last_name`, `course`, `attendees`, `status` ENUM...
6. `contact_messages` — `service`, `consent`, `read_status` ENUM `unread\|read`.

MariaDB is strict — NOT NULL columns need an explicit DEFAULT (or be nullable) to satisfy imports;
`csrf_tokens.expires_at` and several TEXT/DATE columns use `DEFAULT NULL`.

---

## 6. Known gaps & pre-production TODOs

These are deliberate/unfinished and should be addressed before going live:

- **CSRF is WIRED UP & ACTIVE.** `backend/includes/csrf.php` generates cryptographically secure
  session tokens (`getCsrfToken()`) and verifies them using `hash_equals()` (`verifyCsrfToken()`).
  All 4 public forms (`document-upload.php`, `booking.php`, `contact.php`, `training.php`) emit
  a hidden `csrf_token` input, `main.js` forwards it both in the payload and via `X-CSRF-Token`
  header, and all 4 handlers reject requests with HTTP 403 JSON if the token is missing or invalid.
- **No SMTP.** `mailer.php` uses PHP `mail()` with `@` suppression + `error_log` on failure so a
  failed send never corrupts the JSON. On localhost there is no MTA, so `mail()` fails silently
  (the DB row still saves; response stays valid). Pre-production: configure XAMPP sendmail or swap
  `sendEmail()` for PHPMailer + an SMTP relay (SendGrid/Mailgun). Replace placeholder
  `practice@financialprecision.co.za` in `mailer.php`.
- **`csrf_tokens` / `generateToken()`** — see CSRF note; `bin2hex(random_bytes($length))` yields
  `2×$length` chars (default 32 → 64, fits the `VARCHAR(64)` column).
- **Payment gateway** — R200 review fee has no processor yet; only `fee_status='pending'` + emails.
- **php.ini upload limits** — verify `upload_max_filesize`/`post_max_size`/`max_file_uploads` match
  the 25 MB / 10-file handler caps before accepting large uploads.
- **No admin UI** yet to view submissions or update `fee_status='pending'` rows.
- **`map-sydney.jpg`** in `assets/images/` is unused by the Johannesburg content (leftover) — verify
  before touching.

---

## 7. Quirks & pitfalls (learned on this repo)

1. **CLI PHP `php.ini` is polluted.** `C:\Users\user\.php.ini` loads PHP 8.3 pdo_mysql/mysqli DLLs
   into the XAMPP **8.2.12** CLI, producing module API-mismatch warnings on `php -l`. Harmless for
   linting; **not used by Apache**. Trust the HTTP path for DB behavior. To clean CLI only, delete
   the user `.php.ini` (dev-only).
2. **PHP interpolation gotcha:** `{$d['x'] ?? 'y'}` is a **parse error** in an interpolated string.
   Precompute into a variable first e.g. `$v = $d['x'] ?? 'y';`.
3. **Field name == API contract.** The hyphenated `first-name`/`last-name` on training (and the
   `service` vs `consultation_type` naming) are intentional. Changing a page `name` without the
   handler breaks the endpoint.
4. **Console encoding lies.** PowerShell cp1252 console renders `�` for UTF-8 dashes (e.g.
   `&mdash;`/en-dashes). The files are correct UTF-8 bytes (`E2 80 94`). Don't "fix" encoding based
   on console output; verify bytes/file reading instead.
5. **Upload normalisation.** `$_FILES` is scalar for a single file and an array for multi. The
   handler normalises both — preserve this when modifying.
6. **`@mail` suppression is intentional** (Keep JSON valid / don't block the saved DB record).
   Route email debugging through `error_log`, not by removing `@`.

---

## 8. Verification workflow (how to prove changes)

- **Pages render:** HTTP 200 and body starts `<!DOCTYPE html>` with no echoed PHP warnings/errors.
- **Browser audit (Playwright headless Chromium):** zero external requests, zero failed resources,
  all internal `.php` links resolve, zero console/page errors.
- **AJAX handlers:** POST expected JSON, confirm `{success:true,...}`; check the matching DB row was
  inserted, then clean up test rows (tables were verified empty after prior tests).
- **Uploads dir:** HTTP must be **403** (`.htaccess` denies direct web access).
- **DB state:** after any manual test, delete inserted rows so `moshmok_db` returns to 0 test rows.
