<?php
session_start();
require 'db_conexion.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Usuario eliminado con éxito.";
        header("Location: index.php"); // Redirigir a la página del CRUD
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el usuario.</div>";
    }
}
?>
