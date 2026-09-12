<?php
declare(strict_types=1);

$pageTitle = 'Doctor Profile | Care-Hope';
$pageDescription = 'View a Care-Hope doctor profile and book an appointment.';
require_once __DIR__ . '/includes/header.php';

$doctor = [
    'name' => 'Dr. Rachel Morgan', 'initials' => 'RM', 'specialty' => 'General Medicine',
    'qualification' => 'MD, Family Medicine', 'experience' => '12 years of experience',
    'bio' => 'Dr. Rachel Morgan is a dedicated general medicine physician who partners with patients to support their long-term wellbeing. She provides thoughtful, preventative, and personalized care for adults and families.',
];
?>
<main id="main-content">
    <section class="section profile-section">
        <div class="container">
            <a class="back-link" href="doctors.php">← Back to doctors</a>
            <div class="profile-card">
                <div class="profile-avatar" aria-hidden="true"><?= e($doctor['initials']) ?></div>
                <div class="profile-intro"><p class="doctor-specialty"><?= e($doctor['specialty']) ?></p><h1><?= e($doctor['name']) ?></h1><p class="qualification"><?= e($doctor['qualification']) ?></p><p><?= e($doctor['experience']) ?></p></div>
                <a class="button" href="book-appointment.php?doctor=1">Book appointment</a>
            </div>
            <div class="profile-details">
                <article><h2>About <?= e($doctor['name']) ?></h2><p><?= e($doctor['bio']) ?></p></article>
                <aside class="details-list"><h2>At a glance</h2><div><span>Specialty</span><strong><?= e($doctor['specialty']) ?></strong></div><div><span>Experience</span><strong><?= e($doctor['experience']) ?></strong></div><div><span>Consultation</span><strong>30 minutes</strong></div></aside>
            </div>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
