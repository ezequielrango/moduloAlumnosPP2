<!-- index.php -->
<!-- <!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body>
    <h1>Iniciar sesión</h1>
    <form action="./pages/login.php" method="post">
                <input type="text" name="email" placeholder="Email" maxlength="25" required="required" />
                <input type="password" name="contraseña" placeholder="contraseña" required="required" />
                <button type="submit" value="Ingresar" class="btn btn-primary btn-block btn-large">Ingresar</button>
            </form>
    <p>¿Aún no tienes una cuenta? <a href="./pages/register.php">Regístrate aquí</a></p>
</body>
</html> -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="./assets/css/login.css" />
  <title>Login</title>
</head>

<body>
<div class="login-section">
            <div class="form-box login">
                <form action="./pages/login.php"  method="post" >
                    <h2>Iniciar Sesión</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input name="email" type="email" required>
                        <label >Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                        <input name="contraseña" type="password" required>
                        <label>Contraseña</label>
                    </div>
                    <div class="remember-password">
                        <label for=""><input type="checkbox">Recuérdame</label>
                        <a href="#">Olvidé mi contraseña</a>
                    </div>
                    <button class="btn">Ingresar</button>
                    <div class="create-account">
                        <p>¿Aún no tienes una cuenta?<a style="color:blueviolet; text-decoration:none" href="./pages/register.php" class="register-link"> Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
  
</body>
</html> 



<!-- <!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro de Usuario</h1>
    
    <form action="register_process.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br><br>
        
        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono"><br><br>
        <label for="dni">DNI:</label>
        <input type="text" name="dni" required><br><br> 
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" required><br><br>
        
        <input type="submit" value="Registrarse">
    </form>
</body>
</html> -->