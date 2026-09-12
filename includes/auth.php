<?php
declare(strict_types=1);

require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/functions.php';

function loggedInUser(): ?array
{
    startSecureSession();

    return isset($_SESSION['user']) && is_array($_SESSION['user']) ? $_SESSION['user'] : null;
}

function isPatient(): bool
{
    return (loggedInUser()['role'] ?? null) === 'patient';
}

function requirePatient(string $loginPath = '../login.php'): void
{
    if (!isPatient()) {
        startSecureSession();
        $_SESSION['flash_error'] = 'Please log in to access your patient account.';
        redirect($loginPath);
    }
}

function loginUser(array $user): void
{
    startSecureSession();
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'first_name' => $user['first_name'],
        'last_name' => $user['last_name'],
        'role' => $user['role'],
    ];
}

function logoutUser(): void
{
    startSecureSession();
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }

    session_destroy();
}
