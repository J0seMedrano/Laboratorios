<?php

// ─── Credenciales de conexión ────────────────────────────────────────────────
$host   = 'localhost';
$user   = 'root';
$pass   = '';
$dbname = 'curso_ii51';

// ─── Conexión PDO ────────────────────────────────────────────────────────────
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>