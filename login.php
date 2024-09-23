<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5 rounded">
                    <div class="card-header text-center">
                        <h4>Inicio de Sesión</h4>
                    </div>
                    <div class="card-body">
                        <?php
                            if (isset($_GET['error'])) {
                                echo "<div class='alert alert-danger'>{$_GET['error']}</div>";
                            }
                        ?>
                        <form action="validar_login.php" method="POST" autocomplete="off">
                            <div class="form-group">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                                </div> 
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="#">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>