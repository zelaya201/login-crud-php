<?php
session_start();
include 'navbar.php';
require 'db_conexion.php';

// Regenerar el ID de sesión para prevenir ataques de fijación de sesión
session_regenerate_id(true);

// Obtener todos los usuarios excepto el que está logeado
$sql = "SELECT * FROM usuarios WHERE id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $logged_user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Contenido principal -->
    <div class="container mt-4">
        <?php 
            if (isset($_SESSION['success_message'])) {
                echo "<div class='alert alert-success' id='alert-message'>" . $_SESSION['success_message'] . "</div>";
                unset($_SESSION['success_message']); // Eliminar el mensaje de la sesión para que no se muestre nuevamente
            }
        ?>
        <div class="row mb-3">
            <div class="col">
                <h3>Usuarios</h3>
            </div>
            <div class="col">
                <a href="nuevo_usuario.php" class="btn btn-primary float-end">
                    <i class="bi bi-plus-circle"></i> Nuevo
                </a>
            </div>
        </div>        

        <!-- Tabla de usuarios -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 70%;">Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['usuario']; ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                            <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar el usuario: <?php echo $row['usuario']; ?>?');">
                                <i class="bi bi-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No hay usuarios registrados</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   
    <!-- JavaScript para ocultar el mensaje después de 5 segundos -->
    <script>
        // Esperar 5 segundos (5000 ms) antes de ocultar el mensaje
        setTimeout(function() {
            var alertMessage = document.getElementById('alert-message');
            if (alertMessage) {
                alertMessage.style.display = 'none'; // Ocultar el mensaje
            }
        }, 2000); // Cambia el número de milisegundos si deseas un tiempo diferente
    </script>
</body>
</html>
