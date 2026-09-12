<?php
declare(strict_types=1);

$pageTitle = 'Find a Doctor | Care-Hope';
$pageDescription = 'Explore Care-Hope doctors and find the right specialist for your needs.';
require_once __DIR__ . '/includes/header.php';

$doctors = [
    ['id' => 1, 'initials' => 'RM', 'name' => 'Dr. Rachel Morgan', 'specialty' => 'General Medicine', 'experience' => '12 years experience', 'bio' => 'Compassionate primary care for individuals and families.'],
    ['id' => 2, 'initials' => 'JA', 'name' => 'Dr. James Allen', 'specialty' => 'Cardiology', 'experience' => '15 years experience', 'bio' => 'Focused on helping patients build healthier hearts and lives.'],
    ['id' => 3, 'initials' => 'SP', 'name' => 'Dr. Sofia Patel', 'specialty' => 'Dermatology', 'experience' => '10 years experience', 'bio' => 'Evidence-based skin care with a personal approach.'],
];
?>
<main id="main-content">
    <section class="page-hero page-hero-short">
        <div class="container page-hero-content">
            <p class="eyebrow">Our specialists</p>
            <h1>Find a doctor you can trust.</h1>
            <p>Explore our experienced healthcare professionals and choose the care that is right for you.</p>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="directory-heading"><div><p class="eyebrow">Featured doctors</p><h2>Here for your health.</h2></div><a class="button button-outline" href="book-appointment.php">Book an appointment</a></div>
            <div class="doctor-grid">
                <?php foreach ($doctors as $doctor): ?>
                    <article class="doctor-card">
                        <div class="doctor-card-image" aria-hidden="true"><span><?= e($doctor['initials']) ?></span></div>
                        <div class="doctor-card-body">
                            <p class="doctor-specialty"><?= e($doctor['specialty']) ?></p>
                            <h2><?= e($doctor['name']) ?></h2>
                            <p class="doctor-experience"><?= e($doctor['experience']) ?></p>
                            <p><?= e($doctor['bio']) ?></p>
                            <a class="text-link" href="doctor-profile.php?id=<?= e((string) $doctor['id']) ?>">View profile <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
