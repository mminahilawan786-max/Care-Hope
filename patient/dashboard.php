<?php
declare(strict_types=1);

$pathPrefix = '../';
require_once __DIR__ . '/../includes/auth.php';
requirePatient('../login.php');
require_once __DIR__ . '/../config/database.php';

$pageTitle = 'Patient dashboard | Care-Hope';
$user = loggedInUser();
$upcomingAppointment = null;
$appointmentCount = 0;
try {
    $statement = getDatabaseConnection()->prepare('SELECT appointments.appointment_date, appointments.appointment_time, appointments.status, doctors.first_name, doctors.last_name, specialties.name AS specialty FROM appointments INNER JOIN doctors ON doctors.id = appointments.doctor_id INNER JOIN specialties ON specialties.id = doctors.specialty_id WHERE appointments.patient_id = :patient_id AND appointments.appointment_date >= CURDATE() AND appointments.status IN (\'pending\', \'confirmed\') ORDER BY appointments.appointment_date, appointments.appointment_time LIMIT 1');
    $statement->execute(['patient_id' => $user['id']]);
    $upcomingAppointment = $statement->fetch();
    $count = getDatabaseConnection()->prepare('SELECT COUNT(*) FROM appointments WHERE patient_id = :patient_id');
    $count->execute(['patient_id' => $user['id']]);
    $appointmentCount = (int) $count->fetchColumn();
} catch (PDOException) {
    // The dashboard still renders when the database is temporarily unavailable.
}
require_once __DIR__ . '/../includes/header.php';
?>
<main id="main-content" class="dashboard-page"><div class="container dashboard-layout"><aside class="dashboard-sidebar"><p class="eyebrow">Patient account</p><h2>Hello, <?= e($user['first_name']) ?>.</h2><nav aria-label="Patient navigation"><a class="is-active" href="dashboard.php">Overview</a><a href="appointments.php">My appointments</a><a href="../book-appointment.php">Book an appointment</a><a href="../logout.php">Log out</a></nav></aside><section class="dashboard-content"><div class="dashboard-heading"><div><p class="eyebrow">Your overview</p><h1>Welcome back, <?= e($user['first_name']) ?>.</h1><p>Everything you need to stay on top of your care is right here.</p></div><a class="button" href="../book-appointment.php">Book appointment</a></div><div class="summary-card"><span>Total appointments</span><strong><?= e((string) $appointmentCount) ?></strong><a href="appointments.php">View appointment history →</a></div><?php if ($upcomingAppointment !== null): ?><article class="upcoming-card"><p class="eyebrow">Your next appointment</p><h2>Dr. <?= e($upcomingAppointment['first_name'] . ' ' . $upcomingAppointment['last_name']) ?></h2><p><?= e($upcomingAppointment['specialty']) ?> · <?= e(date('F j, Y', strtotime($upcomingAppointment['appointment_date']))) ?> at <?= e(date('g:i A', strtotime($upcomingAppointment['appointment_time']))) ?></p><span class="status status-<?= e($upcomingAppointment['status']) ?>"><?= e(ucfirst($upcomingAppointment['status'])) ?></span></article><?php else: ?><div class="empty-state"><span aria-hidden="true">📅</span><h2>No upcoming appointments</h2><p>When you book an appointment, its date, time, and status will appear here.</p><a class="text-link" href="../doctors.php">Find a doctor <span aria-hidden="true">→</span></a></div><?php endif; ?></section></div></main>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
