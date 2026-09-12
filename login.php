<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';
if (isPatient()) redirect('patient/dashboard.php');
$pageTitle = 'Patient login | Care-Hope';
$errors = [];
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim((string) ($_POST['email'] ?? ''));
    $password = (string) ($_POST['password'] ?? '');
    if (!csrfIsValid($_POST['csrf_token'] ?? null)) $errors[] = 'Your form session has expired. Please try again.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
    if ($password === '') $errors[] = 'Please enter your password.';
    if ($errors === []) {
        try {
            $statement = getDatabaseConnection()->prepare('SELECT id, first_name, last_name, role, password_hash FROM users WHERE email = :email AND role = \'patient\' LIMIT 1');
            $statement->execute(['email' => $email]);
            $user = $statement->fetch();
            if ($user === false || !password_verify($password, $user['password_hash'])) {
                $errors[] = 'The email address or password is incorrect.';
            } else {
                loginUser($user);
                redirect('patient/dashboard.php');
            }
        } catch (PDOException) {
            $errors[] = 'We could not log you in right now. Please try again later.';
        }
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="auth-page"><section class="auth-card auth-card-compact"><div class="auth-intro"><p class="eyebrow">Welcome back</p><h1>Your care, always within reach.</h1><p>Log in to view upcoming appointments and manage your patient account.</p></div><form class="auth-form" method="post" novalidate><h2>Patient login</h2><p>New to Care-Hope? <a href="signup.php">Create an account</a></p><?php if (isset($_SESSION['flash_error'])): ?><p class="form-message error" role="alert"><?= e($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></p><?php endif; ?><?php if ($errors !== []): ?><div class="form-message error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><label>Email address<input name="email" type="email" required autocomplete="email" value="<?= e($email) ?>"></label><label>Password<input name="password" type="password" required autocomplete="current-password"></label><button class="button" type="submit">Log in</button></form></section></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
