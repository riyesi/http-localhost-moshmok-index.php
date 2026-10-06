<?php
/**
 * Administrator Login
 *
 * Authenticates against admin_users table using password_verify().
 * Protected with per-session CSRF verification.
 */

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/db.php';

// Redirect if already authenticated
if (!empty($_SESSION['admin_user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf     = $_POST['csrf_token'] ?? '';

    if (!verifyAdminCsrfToken($csrf)) {
        $error = 'Security validation failed (invalid session token). Please try again.';
    } elseif (empty($username) || empty($password)) {
        $error = 'Please enter both your username and password.';
    } else {
        try {
            $pdo = getDB();
            $stmt = $pdo->prepare("SELECT id, username, password_hash, full_name, role FROM admin_users WHERE username = :u LIMIT 1");
            $stmt->execute([':u' => $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                // Regenerate session ID upon privilege escalation
                session_regenerate_id(true);

                $_SESSION['admin_user'] = [
                    'id'        => (int)$user['id'],
                    'username'  => $user['username'],
                    'full_name' => $user['full_name'],
                    'role'      => $user['role'],
                ];

                header('Location: dashboard.php');
                exit;
            } else {
                $error = 'Invalid credentials. Please check your username and password.';
            }
        } catch (PDOException $e) {
            $error = 'Database error occurred. Please try again.';
        }
    }
}

$csrfToken = getAdminCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Portal Login — Financial Precision</title>
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body class="bg-surface text-on-surface font-body-lg antialiased min-h-screen flex items-center justify-center p-4">

  <div class="w-full max-w-md">
    <!-- Brand Title -->
    <div class="text-center mb-8">
      <a href="../../index.php" class="font-headline-md text-headline-md font-bold text-primary tracking-tight block">
        FINANCIAL PRECISION
      </a>
      <p class="font-body-md text-body-md text-on-surface-variant mt-1">Lead Converter &amp; Follow-Up Portal</p>
    </div>

    <!-- Login Card -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-8 shadow-sm relative overflow-hidden">
      <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary-container via-surface-tint to-primary-container"></div>
      
      <h1 class="font-headline-md text-headline-md font-bold text-primary mb-2">Staff Sign In</h1>
      <p class="font-body-sm text-on-surface-variant mb-6">Enter your authorized administrative credentials to access lead operations.</p>

      <?php if (!empty($error)): ?>
        <div class="mb-5 p-3.5 bg-error-container text-on-error-container text-sm rounded border border-error/20 flex items-start gap-2">
          <span class="material-symbols-outlined text-base mt-0.5" aria-hidden="true">error</span>
          <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      <?php endif; ?>

      <form method="POST" action="login.php" class="space-y-5">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

        <div>
          <label for="username" class="block font-label-md text-label-md text-primary mb-1.5 uppercase tracking-wide">Username</label>
          <input type="text" id="username" name="username" required autofocus
                 class="w-full bg-surface border border-outline-variant rounded-lg py-2.5 px-3.5 text-primary focus:outline-none focus:border-tertiary-fixed-dim transition-colors"
                 placeholder="admin" value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div>
          <label for="password" class="block font-label-md text-label-md text-primary mb-1.5 uppercase tracking-wide">Password</label>
          <input type="password" id="password" name="password" required
                 class="w-full bg-surface border border-outline-variant rounded-lg py-2.5 px-3.5 text-primary focus:outline-none focus:border-tertiary-fixed-dim transition-colors"
                 placeholder="••••••••">
        </div>

        <button type="submit"
                class="w-full bg-tertiary-fixed text-on-tertiary-fixed font-bold py-3 px-4 rounded-lg hover:opacity-90 transition-all font-label-md text-label-md mt-2 shadow-sm">
          Sign In to Dashboard
        </button>
      </form>

      <div class="mt-6 pt-5 border-t border-outline-variant/50 text-center">
        <p class="text-xs text-on-surface-variant">
          Contact your system administrator if you cannot log in.
        </p>
      </div>
    </div>

    <!-- Back to public site -->
    <div class="text-center mt-6">
      <a href="../../index.php" class="text-xs text-on-surface-variant hover:text-primary transition-colors">
        &larr; Return to Public Website
      </a>
    </div>
  </div>

</body>
</html>
