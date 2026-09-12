<?php
declare(strict_types=1);

$pathPrefix = '../';
require_once __DIR__ . '/../includes/auth.php';
requirePatient('../login.php');

$pageTitle = 'My appointments | Care-Hope';
$user = loggedInUser();
require_once __DIR__ . '/../includes/header.php';
?>
<main id="main-content" class="dashboard-page"><div class="container dashboard-layout"><aside class="dashboard-sidebar"><p class="eyebrow">Patient account</p><h2>Hello, <?= e($user['first_name']) ?>.</h2><nav aria-label="Patient navigation"><a href="dashboard.php">Overview</a><a class="is-active" href="appointments.php">My appointments</a><a href="../book-appointment.php">Book an appointment</a><a href="../logout.php">Log out</a></nav></aside><section class="dashboard-content"><div class="dashboard-heading"><div><p class="eyebrow">Your care</p><h1>My appointments</h1><p>Review the appointments you have booked with Care-Hope.</p></div><a class="button" href="../book-appointment.php">Book appointment</a></div><div class="empty-state"><span aria-hidden="true">⌚</span><h2>Your appointment list is empty</h2><p>Choose a doctor and time that works for you to get started.</p><a class="text-link" href="../doctors.php">Browse doctors <span aria-hidden="true">→</span></a></div></section></div></main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
