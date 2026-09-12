<?php
declare(strict_types=1);

$pageTitle = 'Care-Hope | Quality care, made simple';
$pageDescription = 'Find a trusted doctor and book your appointment online with Care-Hope.';
require_once __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <p class="eyebrow">Care that fits your life</p>
                <h1>Quality care, made simple.</h1>
                <p class="hero-copy">Find trusted specialists, choose a convenient time, and manage every appointment from one reassuring place.</p>
                <div class="hero-actions">
                    <a class="button" href="book-appointment.php">Book an appointment</a>
                    <a class="button button-outline" href="doctors.php">Find a doctor</a>
                </div>
                <div class="hero-stats" aria-label="Care-Hope service highlights">
                    <div><strong>50+</strong><span>Trusted doctors</span></div>
                    <div><strong>12</strong><span>Specialty areas</span></div>
                    <div><strong>24/7</strong><span>Easy online access</span></div>
                </div>
            </div>
            <aside class="hero-panel" aria-label="Example appointment availability">
                <div class="panel-top"><span>Your next step</span><span aria-hidden="true">📅</span></div>
                <div class="availability">
                    <p>Available this week</p>
                    <h2>Choose a time that works for you.</h2>
                    <div class="doctor-preview">
                        <span class="doctor-avatar" aria-hidden="true">DR</span>
                        <div><strong>Dr. Rachel Morgan</strong><small>General Medicine</small></div>
                    </div>
                    <div class="slot-list" aria-label="Available appointment times">
                        <span class="slot">9:30 AM</span><span class="slot">11:00 AM</span><span class="slot">2:30 PM</span>
                    </div>
                </div>
                <span class="panel-note">Simple, secure booking</span>
            </aside>
        </div>
    </section>

    <section class="section" aria-labelledby="care-features-title">
        <div class="container">
            <div class="section-heading">
                <p class="eyebrow">Designed around you</p>
                <h2 id="care-features-title">Healthcare should feel easier.</h2>
                <p>Care-Hope gives patients a clear path from finding the right specialist to keeping track of every visit.</p>
            </div>
            <div class="feature-grid">
                <article class="feature-card"><span class="feature-icon" aria-hidden="true">⌕</span><h3>Find the right doctor</h3><p>Browse experienced doctors by specialty and view the information you need before booking.</p></article>
                <article class="feature-card"><span class="feature-icon" aria-hidden="true">◷</span><h3>Book in a few minutes</h3><p>Select a convenient date and time without phone queues or unnecessary paperwork.</p></article>
                <article class="feature-card"><span class="feature-icon" aria-hidden="true">✓</span><h3>Stay in control</h3><p>Use your patient dashboard to review appointments and keep your care organized.</p></article>
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container cta">
            <div><h2>Ready to take care of your health?</h2><p>Create your patient account to make booking and managing appointments easy.</p></div>
            <a class="button" href="signup.php">Create an account</a>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
