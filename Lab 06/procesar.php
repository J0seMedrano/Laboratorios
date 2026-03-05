<?php
include 'db.php';

// Solo acepta POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$correo = trim($_POST['correo'] ?? '');

// ─── Validaciones ─────────────────────────────────────────────────────────────
$errores = [];

if ($nombre === '') {
    $errores[] = 'El nombre no puede venir vacío.';
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = 'El correo debe tener un formato válido (ej: usuario@dominio.com).';
}

// ─── Si hay errores: mostrarlos con enlace para volver ───────────────────────
if (!empty($errores)) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Errores de validación</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 500px; margin: 3rem auto; }
            .error-box { background: #fff3f3; border-left: 4px solid #e74c3c;
                         padding: 1rem 1.5rem; border-radius: 4px; }
            .error-box p { color: #c0392b; margin: .4rem 0; }
            a { display: inline-block; margin-top: 1rem; color: #007bff;
                text-decoration: none; font-weight: bold; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="error-box">
            <strong>Por favor corrige los siguientes errores:</strong>
            <?php foreach ($errores as $err): ?>
                <p>⚠ <?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
        </div>
        <a href="index.php">← Volver al formulario</a>
    </body>
    </html>
    <?php
    exit;
}

// ─── INSERT ───────────────────────────────────────────────────────────────────
try {
    $stmt = $pdo->prepare(
        "INSERT INTO alumnos (nombre, correo) VALUES (:nombre, :correo)"
    );
    $stmt->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
    ]);

    // Registro exitoso → redirige al listado
    header('Location: index.php');
    exit;

} catch (PDOException $e) {
    die("Error al guardar: " . $e->getMessage());
}
?>
