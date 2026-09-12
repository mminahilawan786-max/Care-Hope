<?php
declare(strict_types=1);

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/auth.php';

$pageTitle = $pageTitle ?? 'Care-Hope | Doctor Appointment Management';
$pageDescription = $pageDescription ?? 'Book trusted doctor appointments online with Care-Hope.';
$pathPrefix = $pathPrefix ?? '';
$user = loggedInUser();

$pageTitle = $pageTitle ?? 'Care-Hope | Doctor Appointment Management';
$pageDescription = $pageDescription ?? 'Book trusted doctor appointments online with Care-Hope.';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= e($pageDescription) ?>">
    <title><?= e($pageTitle) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e($pathPrefix) ?>assets/css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<a class="skip-link" href="#main-content">Skip to main content</a>
<header class="site-header">
    <div class="container header-content">
        <a class="brand" href="<?= e($pathPrefix) ?>index.php" aria-label="Care-Hope home">
        <a class="brand" href="index.php" aria-label="Care-Hope home">
            <span class="brand-mark" aria-hidden="true">+</span>
            <span>Care<span>Hope</span></span>
        </a>

        <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation">
            <span class="sr-only">Toggle navigation</span>
            <span></span><span></span><span></span>
        </button>

        <nav class="primary-nav" id="primary-navigation" aria-label="Primary navigation">
            <a class="<?= navIsActive('index.php') ?>" href="<?= e($pathPrefix) ?>index.php">Home</a>
            <a class="<?= navIsActive('about.php') ?>" href="<?= e($pathPrefix) ?>about.php">About</a>
            <a class="<?= navIsActive('doctors.php') ?>" href="<?= e($pathPrefix) ?>doctors.php">Doctors</a>
            <a class="<?= navIsActive('contact.php') ?>" href="<?= e($pathPrefix) ?>contact.php">Contact</a>
            <?php if ($user !== null && $user['role'] === 'patient'): ?>
                <a class="nav-login" href="<?= e($pathPrefix) ?>patient/dashboard.php">My account</a>
            <?php else: ?>
                <a class="nav-login <?= navIsActive('login.php') ?>" href="<?= e($pathPrefix) ?>login.php">Log in</a>
            <?php endif; ?>
            <a class="button button-small" href="<?= e($pathPrefix) ?>book-appointment.php">Book appointment</a>
            <a class="<?= navIsActive('index.php') ?>" href="index.php">Home</a>
            <a class="<?= navIsActive('about.php') ?>" href="about.php">About</a>
            <a class="<?= navIsActive('doctors.php') ?>" href="doctors.php">Doctors</a>
            <a class="<?= navIsActive('contact.php') ?>" href="contact.php">Contact</a>
            <a class="nav-login <?= navIsActive('login.php') ?>" href="login.php">Log in</a>
            <a class="button button-small" href="book-appointment.php">Book appointment</a>
        </nav>
    </div>
</header>
