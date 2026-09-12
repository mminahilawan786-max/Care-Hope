<?php
declare(strict_types=1);

$pageTitle = 'About Care-Hope | Compassionate care, made accessible';
$pageDescription = 'Learn how Care-Hope makes finding and managing healthcare simpler.';
require_once __DIR__ . '/includes/header.php';
?>
<main id="main-content">
    <section class="page-hero">
        <div class="container page-hero-content">
            <p class="eyebrow">About Care-Hope</p>
            <h1>Healthcare built around people.</h1>
            <p>We believe every patient deserves a clear, calm, and convenient way to access quality care.</p>
        </div>
    </section>

    <section class="section">
        <div class="container split-content">
            <div class="story-visual" aria-hidden="true"><span>Care</span><strong>with<br>confidence.</strong></div>
            <div>
                <p class="eyebrow">Our story</p>
                <h2>Making the path to care feel less complicated.</h2>
                <p>Care-Hope brings patients and trusted healthcare professionals together in one easy-to-use place. From choosing a specialist to reviewing an upcoming visit, we make each step easier to understand.</p>
                <p>Our focus is simple: thoughtful technology, clear information, and a better experience for every patient.</p>
                <a class="text-link" href="doctors.php">Meet our doctors <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </section>

    <section class="section section-soft" aria-labelledby="values-title">
        <div class="container">
            <div class="section-heading"><p class="eyebrow">Our promise</p><h2 id="values-title">Care that puts you first.</h2></div>
            <div class="feature-grid">
                <article class="feature-card"><span class="feature-icon" aria-hidden="true">♡</span><h3>Compassion</h3><p>We design every interaction to be considerate, respectful, and easy to follow.</p></article>
                <article class="feature-card"><span class="feature-icon" aria-hidden="true">◎</span><h3>Clarity</h3><p>We help patients make informed choices with straightforward, useful information.</p></article>
                <article class="feature-card"><span class="feature-icon" aria-hidden="true">⌁</span><h3>Connection</h3><p>We make it easier to connect with the right care at the right time.</p></article>
            </div>
        </div>
    </section>
</main>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
