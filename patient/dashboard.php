<?php
declare(strict_types=1);

$pathPrefix = '../';
require_once __DIR__ . '/../includes/auth.php';
requirePatient('../login.php');

$pageTitle = 'Patient dashboard | Care-Hope';
$user = loggedInUser();
require_once __DIR__ . '/../includes/header.php';
?>
<main id="main-content" class="dashboard-page"><div class="container dashboard-layout"><aside class="dashboard-sidebar"><p class="eyebrow">Patient account</p><h2>Hello, <?= e($user['first_name']) ?>.</h2><nav aria-label="Patient navigation"><a class="is-active" href="dashboard.php">Overview</a><a href="appointments.php">My appointments</a><a href="../book-appointment.php">Book an appointment</a><a href="../logout.php">Log out</a></nav></aside><section class="dashboard-content"><div class="dashboard-heading"><div><p class="eyebrow">Your overview</p><h1>Welcome back, <?= e($user['first_name']) ?>.</h1><p>Everything you need to stay on top of your care is right here.</p></div><a class="button" href="../book-appointment.php">Book appointment</a></div><div class="empty-state"><span aria-hidden="true">📅</span><h2>No upcoming appointments</h2><p>When you book an appointment, its date, time, and status will appear here.</p><a class="text-link" href="../doctors.php">Find a doctor <span aria-hidden="true">→</span></a></div></section></div></main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
