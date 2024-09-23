<?php
session_start();
require 'db_conexion.php';
include 'navbar.php';

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Hashear la contraseña

    // Encriptar la contraseña usando password_hash()
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Comprobar que no estén vacíos
    if (!empty($username) && !empty($password)) {
        // Insertar el usuario en la base de datos con la contraseña hasheada
        $sql = "INSERT INTO usuarios (usuario, clave) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Usuario añadido con éxito.";
            header("Location: index.php"); // Redirigir a la página del CRUD
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al añadir usuario.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Por favor, complete todos los campos.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h4>Nuevo Usuario</h4>
        <form action="nuevo_usuario.php" method="POST" class="mt-4">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
