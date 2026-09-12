<?php
declare(strict_types=1);

$pathPrefix = '../';
require_once __DIR__ . '/../includes/auth.php';
requirePatient('../login.php');
require_once __DIR__ . '/../config/database.php';

$pageTitle = 'My appointments | Care-Hope';
$user = loggedInUser();
$appointments = [];
try {
    $statement = getDatabaseConnection()->prepare('SELECT appointments.appointment_date, appointments.appointment_time, appointments.reason, appointments.status, doctors.first_name, doctors.last_name, specialties.name AS specialty FROM appointments INNER JOIN doctors ON doctors.id = appointments.doctor_id INNER JOIN specialties ON specialties.id = doctors.specialty_id WHERE appointments.patient_id = :patient_id ORDER BY appointments.appointment_date DESC, appointments.appointment_time DESC');
    $statement->execute(['patient_id' => $user['id']]);
    $appointments = $statement->fetchAll();
} catch (PDOException) {
    // An empty state is safer than exposing database connection details.
}
require_once __DIR__ . '/../includes/header.php';
?>
<main id="main-content" class="dashboard-page"><div class="container dashboard-layout"><aside class="dashboard-sidebar"><p class="eyebrow">Patient account</p><h2>Hello, <?= e($user['first_name']) ?>.</h2><nav aria-label="Patient navigation"><a href="dashboard.php">Overview</a><a class="is-active" href="appointments.php">My appointments</a><a href="../book-appointment.php">Book an appointment</a><a href="../logout.php">Log out</a></nav></aside><section class="dashboard-content"><div class="dashboard-heading"><div><p class="eyebrow">Your care</p><h1>My appointments</h1><p>Review the appointments you have booked with Care-Hope.</p></div><a class="button" href="../book-appointment.php">Book appointment</a></div><?php if (isset($_SESSION['flash_success'])): ?><p class="form-message success" role="status"><?= e($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></p><?php endif; ?><?php if ($appointments === []): ?><div class="empty-state"><span aria-hidden="true">⌚</span><h2>Your appointment list is empty</h2><p>Choose a doctor and time that works for you to get started.</p><a class="text-link" href="../doctors.php">Browse doctors <span aria-hidden="true">→</span></a></div><?php else: ?><div class="appointment-list"><?php foreach ($appointments as $appointment): ?><article class="appointment-card"><div><p class="doctor-specialty"><?= e($appointment['specialty']) ?></p><h2>Dr. <?= e($appointment['first_name'] . ' ' . $appointment['last_name']) ?></h2><p><?= e(date('F j, Y', strtotime($appointment['appointment_date']))) ?> at <?= e(date('g:i A', strtotime($appointment['appointment_time']))) ?></p><small><?= e($appointment['reason']) ?></small></div><span class="status status-<?= e($appointment['status']) ?>"><?= e(ucfirst($appointment['status'])) ?></span></article><?php endforeach; ?></div><?php endif; ?></section></div></main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
