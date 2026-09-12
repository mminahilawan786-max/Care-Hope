<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

if (isPatient()) {
    redirect('patient/dashboard.php');
}

$pageTitle = 'Create your account | Care-Hope';
$errors = [];
$form = ['first_name' => '', 'last_name' => '', 'email' => '', 'phone' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($form as $field => $value) {
        $form[$field] = trim((string) ($_POST[$field] ?? ''));
    }
    $password = (string) ($_POST['password'] ?? '');
    $passwordConfirmation = (string) ($_POST['password_confirmation'] ?? '');

    if (!csrfIsValid($_POST['csrf_token'] ?? null)) $errors[] = 'Your form session has expired. Please try again.';
    if ($form['first_name'] === '' || mb_strlen($form['first_name']) > 80) $errors[] = 'Please enter your first name.';
    if ($form['last_name'] === '' || mb_strlen($form['last_name']) > 80) $errors[] = 'Please enter your last name.';
    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($form['email']) > 190) $errors[] = 'Please enter a valid email address.';
    if ($form['phone'] !== '' && mb_strlen($form['phone']) > 30) $errors[] = 'Please enter a valid phone number.';
    if (strlen($password) < 8) $errors[] = 'Your password must contain at least 8 characters.';
    if ($password !== $passwordConfirmation) $errors[] = 'Your password confirmation does not match.';

    if ($errors === []) {
        try {
            $pdo = getDatabaseConnection();
            $exists = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
            $exists->execute(['email' => $form['email']]);
            if ($exists->fetch() !== false) {
                $errors[] = 'An account with this email address already exists.';
            } else {
                $statement = $pdo->prepare('INSERT INTO users (role, first_name, last_name, email, phone, password_hash) VALUES (\'patient\', :first_name, :last_name, :email, :phone, :password_hash)');
                $statement->execute([...$form, 'phone' => $form['phone'] ?: null, 'password_hash' => password_hash($password, PASSWORD_DEFAULT)]);
                loginUser(['id' => (int) $pdo->lastInsertId(), ...$form, 'role' => 'patient']);
                redirect('patient/dashboard.php');
            }
        } catch (PDOException) {
            $errors[] = 'We could not create your account right now. Please try again later.';
        }
    }
}
require_once __DIR__ . '/includes/header.php';
?>
<main id="main-content" class="auth-page"><section class="auth-card"><div class="auth-intro"><p class="eyebrow">Welcome to Care-Hope</p><h1>Start managing your care with confidence.</h1><p>Keep appointments, trusted doctors, and important health visits organized in one place.</p></div><form class="auth-form" method="post" novalidate><h2>Create your account</h2><p>Already have an account? <a href="login.php">Log in</a></p><?php if ($errors !== []): ?><div class="form-message error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?><input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>"><div class="form-row"><label>First name<input name="first_name" required maxlength="80" autocomplete="given-name" value="<?= e($form['first_name']) ?>"></label><label>Last name<input name="last_name" required maxlength="80" autocomplete="family-name" value="<?= e($form['last_name']) ?>"></label></div><label>Email address<input name="email" type="email" required maxlength="190" autocomplete="email" value="<?= e($form['email']) ?>"></label><label>Phone number <span>(optional)</span><input name="phone" type="tel" maxlength="30" autocomplete="tel" value="<?= e($form['phone']) ?>"></label><label>Password<input name="password" type="password" required minlength="8" autocomplete="new-password"></label><label>Confirm password<input name="password_confirmation" type="password" required minlength="8" autocomplete="new-password"></label><button class="button" type="submit">Create account</button></form></section></main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
