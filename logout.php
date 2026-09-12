<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/auth.php';

logoutUser();
startSecureSession();
$_SESSION['flash_error'] = 'You have been logged out.';
redirect('login.php');
