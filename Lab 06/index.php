<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Alumnos</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5;
               margin: 0; padding: 2rem; }
        .card { background: #fff; max-width: 650px; margin: 0 auto;
                padding: 2rem; border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h2 { margin-top: 0; color: #333; }

        /* Formulario */
        label { display: block; margin-bottom: .25rem;
                font-weight: bold; color: #555; }
        input[type="text"],
        input[type="email"] {
            width: 100%; padding: .6rem .8rem; margin-bottom: 1rem;
            border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;
        }
        input:focus { outline: none; border-color: #007bff;
                      box-shadow: 0 0 0 2px rgba(0,123,255,.2); }
        button {
            padding: .6rem 1.4rem; background: #007bff; color: #fff;
            border: none; border-radius: 4px; font-size: 1rem;
            cursor: pointer;
        }
        button:hover { background: #0056b3; }

        /* Tabla */
        table { width: 100%; border-collapse: collapse; margin-top: 2rem; }
        th { background: #e9ecef; padding: .6rem; border: 1px solid #dee2e6;
             text-align: left; }
        td { padding: .6rem; border: 1px solid #dee2e6; }
        tr:nth-child(even) { background: #f8f9fa; }
        .empty { text-align: center; color: #888; padding: 1rem; }
    </style>
</head>
<body>
<div class="card">
    <h2>Registro de Alumnos</h2>

    <!-- ── Formulario ───────────────────────────────────────────────────── -->
    <form action="procesar.php" method="POST">
        <label for="nombre">Nombre completo</label>
        <input type="text" id="nombre" name="nombre"
               placeholder="Ej: María López" required>

        <label for="correo">Correo electrónico</label>
        <input type="email" id="correo" name="correo"
               placeholder="Ej: maria@correo.com" required>

        <button type="submit">Registrar alumno</button>
    </form>

    <!-- ── Listado ──────────────────────────────────────────────────────── -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Fecha de registro</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query(
                "SELECT id, nombre, correo, fecha_registro
                 FROM alumnos
                 ORDER BY fecha_registro DESC"
            );
            $alumnos = $stmt->fetchAll();

            if (empty($alumnos)):
            ?>
                <tr>
                    <td colspan="4" class="empty">No hay alumnos registrados aún.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($alumnos as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['nombre']) ?></td>
                    <td><?= htmlspecialchars($row['correo']) ?></td>
                    <td><?= $row['fecha_registro'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
