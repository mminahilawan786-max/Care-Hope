<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <a class="brand brand-footer" href="<?= e($pathPrefix ?? '') ?>index.php" aria-label="Care-Hope home">
            <a class="brand brand-footer" href="index.php" aria-label="Care-Hope home">
                <span class="brand-mark" aria-hidden="true">+</span>
                <span>Care<span>Hope</span></span>
            </a>
            <p>Making quality healthcare simpler, closer, and more personal.</p>
        </div>
        <div>
            <h2>Quick links</h2>
            <a href="<?= e($pathPrefix ?? '') ?>about.php">About us</a>
            <a href="<?= e($pathPrefix ?? '') ?>doctors.php">Find a doctor</a>
            <a href="<?= e($pathPrefix ?? '') ?>book-appointment.php">Book appointment</a>
        </div>
        <div>
            <h2>For patients</h2>
            <a href="<?= e($pathPrefix ?? '') ?>signup.php">Create an account</a>
            <a href="<?= e($pathPrefix ?? '') ?>login.php">Patient login</a>
            <a href="<?= e($pathPrefix ?? '') ?>contact.php">Contact support</a>
            <a href="about.php">About us</a>
            <a href="doctors.php">Find a doctor</a>
            <a href="book-appointment.php">Book appointment</a>
        </div>
        <div>
            <h2>For patients</h2>
            <a href="signup.php">Create an account</a>
            <a href="login.php">Patient login</a>
            <a href="contact.php">Contact support</a>
        </div>
    </div>
    <div class="container footer-bottom">
        <p>&copy; <?= date('Y') ?> Care-Hope. All rights reserved.</p>
        <a href="<?= e($pathPrefix ?? '') ?>admin/login.php">Administrator login</a>
    </div>
</footer>
<script src="<?= e($pathPrefix ?? '') ?>assets/js/main.js"></script>
        <a href="admin/login.php">Administrator login</a>
    </div>
</footer>
<script src="assets/js/main.js"></script>
</body>
</html>
