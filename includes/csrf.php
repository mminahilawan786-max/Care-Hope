<?php
declare(strict_types=1);

function startSecureSession(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start([
            'cookie_httponly' => true,
            'cookie_samesite' => 'Lax',
            'cookie_secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        ]);
    }
}

function csrfToken(): string
{
    startSecureSession();
    $_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

    return $_SESSION['csrf_token'];
}

function csrfIsValid(?string $token): bool
{
    startSecureSession();

    return is_string($token)
        && isset($_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $token);
}
