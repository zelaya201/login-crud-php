<?php
// Mostrar errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db_conexion.php';
include 'navbar.php';

// Obtener el usuario por ID
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_id = $_POST['id'];

    if (!empty($username)) {
        // Actualizar el nombre de usuario
        $query = "UPDATE usuarios SET usuario = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $username, $user_id);
        $stmt->execute();
    }

    if (!empty($password)) {
        // Si se ingresó una nueva contraseña, encriptarla
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $query = "UPDATE usuarios SET clave = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $hashed_password, $user_id);
        $stmt->execute();
    }

    if ($stmt->affected_rows > 0) {
        if ($user_id == $_SESSION['user_id']) {
            $_SESSION['username'] = $username; //Actualizamos la sesion con el nuevo nombre de usuario
        }

        $_SESSION['success_message'] = "Usuario actualizado con éxito.";
        header("Location: index.php"); // Redirigir a la página del CRUD
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el usuario.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h4>Editar Usuario</h4>
    <form action="editar_usuario.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id'];?>">
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['usuario'] ?>" required>
        </div>
        <div class="mb-4">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
