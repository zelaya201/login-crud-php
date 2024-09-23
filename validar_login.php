<?php
// Mostrar errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db_conexion.php'; // Importacion de la base de datos

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password']; 

    // Consulta para obtener el usuario
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verificar la contraseña hasheada con password_verify()
        if (password_verify($password, $user['clave'])) {
            // Si la contraseña es correcta, inicia sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['usuario'];
            header("Location: index.php"); // Redirigir al CRUD
            exit();
        } else {
            header("Location: login.php?error=Contraseña incorrecta");
            exit();
        }
    } else {
        header("Location: login.php?error=Usuario o contraseña incorrectos");
        exit();
    }
} else {
    echo "Faltan datos.";
}
?>

