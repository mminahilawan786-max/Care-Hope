<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/csrf.php';
require_once __DIR__ . '/config/database.php';

$pageTitle = 'Contact Care-Hope | We are here to help';
$pageDescription = 'Contact the Care-Hope team for help with appointments and patient accounts.';
$errors = [];
$successMessage = '';
$form = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($form as $field => $value) {
        $form[$field] = trim((string) ($_POST[$field] ?? ''));
    }

    if (!csrfIsValid($_POST['csrf_token'] ?? null)) {
        $errors[] = 'Your form session has expired. Please try again.';
    }
    if ($form['name'] === '' || mb_strlen($form['name']) > 160) {
        $errors[] = 'Please enter your name (up to 160 characters).';
    }
    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($form['email']) > 190) {
        $errors[] = 'Please enter a valid email address.';
    }
    if ($form['subject'] === '' || mb_strlen($form['subject']) > 200) {
        $errors[] = 'Please enter a subject (up to 200 characters).';
    }
    if ($form['message'] === '' || mb_strlen($form['message']) > 5000) {
        $errors[] = 'Please enter a message (up to 5,000 characters).';
    }

    if ($errors === []) {
        try {
            $statement = getDatabaseConnection()->prepare(
                'INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (:name, :email, :phone, :subject, :message)'
            );
            $statement->execute($form);
            $successMessage = 'Thank you for contacting us. Our team will get back to you soon.';
            $form = ['name' => '', 'email' => '', 'phone' => '', 'subject' => '', 'message' => ''];
        } catch (PDOException) {
            $errors[] = 'We could not send your message right now. Please try again later.';
        }
    }
}

require_once __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero page-hero-short"><div class="container page-hero-content"><p class="eyebrow">Contact us</p><h1>We are here to help.</h1><p>Have a question about Care-Hope or your appointment? Send us a message and our team will be happy to assist.</p></div></section>
    <section class="section"><div class="container contact-layout">
        <aside class="contact-details"><p class="eyebrow">Get in touch</p><h2>Let’s start a conversation.</h2><p>Our support team is available Monday through Friday, 9:00 AM to 5:00 PM.</p><div><strong>Email us</strong><a href="mailto:support@carehope.test">support@carehope.test</a></div><div><strong>Call us</strong><a href="tel:+15550102200">+1 (555) 010-2200</a></div></aside>
        <form class="contact-form" method="post" novalidate>
            <h2>Send a message</h2>
            <?php if ($successMessage !== ''): ?><p class="form-message success" role="status"><?= e($successMessage) ?></p><?php endif; ?>
            <?php if ($errors !== []): ?><div class="form-message error" role="alert"><p>Please correct the following:</p><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
            <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
            <div class="form-row"><label>Full name<input name="name" type="text" maxlength="160" autocomplete="name" required value="<?= e($form['name']) ?>"></label><label>Email address<input name="email" type="email" maxlength="190" autocomplete="email" required value="<?= e($form['email']) ?>"></label></div>
            <div class="form-row"><label>Phone number <span>(optional)</span><input name="phone" type="tel" maxlength="30" autocomplete="tel" value="<?= e($form['phone']) ?>"></label><label>Subject<input name="subject" type="text" maxlength="200" required value="<?= e($form['subject']) ?>"></label></div>
            <label>How can we help?<textarea name="message" rows="5" maxlength="5000" required><?= e($form['message']) ?></textarea></label>
            <button class="button" type="submit">Send message</button>
        </form>
    </div></section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
