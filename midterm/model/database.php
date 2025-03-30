<?php
/**
 * Database connection for this project. User root for development environment only.
 * 
 * @author Judson Hartley <github@jahartley.com> 20250328
 * 
 */

$dsn = "mysql:host=localhost; dbname=zippyusedautos";
$username = 'root';

try {
    $db = new PDO($dsn, $username);
} catch (PDOException $e) {
    error_log($e->getMessage());
    die("Database connection is failed");
}
