<?php
declare(strict_types=1);

/** Escape text before displaying it in HTML. */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Return the current page filename for navigation highlighting. */
function currentPage(): string
{
    return basename(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: 'index.php');
}

/** Build a navigation class for the active page. */
function navIsActive(string $page): string
{
    return currentPage() === $page ? 'is-active' : '';
}
