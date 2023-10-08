
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
                        <!-- <label for=""><input type="checkbox">Recuérdame</label>
                        <a href="#">Olvidé mi contraseña</a> -->
                    </div>
                    <button class="btn">Ingresar</button>
                    <div class="create-account">
                        <p>¿Aún no tienes una cuenta?<a style="color:blueviolet; text-decoration:none" href="./pages/register.php" class="register-link"> Regístrate aquí</a></p>
                    </div>
                </form>
            </div>
  
</body>
</html> 



