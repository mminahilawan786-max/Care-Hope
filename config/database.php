<?php
declare(strict_types=1);

/**
 * Creates the application's PDO connection.
 *
 * Configure the values through environment variables in production. The
 * defaults make local development simple after importing database/schema.sql.
 */
function getDatabaseConnection(): PDO
{
    $host = getenv('CARE_HOPE_DB_HOST') ?: '127.0.0.1';
    $port = getenv('CARE_HOPE_DB_PORT') ?: '3306';
    $database = getenv('CARE_HOPE_DB_NAME') ?: 'care_hope';
    $username = getenv('CARE_HOPE_DB_USER') ?: 'root';
    $password = getenv('CARE_HOPE_DB_PASS') ?: '';

    $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";

    return new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
