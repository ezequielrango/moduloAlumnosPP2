<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/css/register.css" />
    <title>Registro</title>
</head>

<body>
    <div class="login-section">
        <div class="form-box login">
            <form action="register_process.php" method="post">
                <h2>Registrar usuario</h2>
                <div class="input-box">
                    <span class="icon"><i class='bx bx-user'></i></span>
                    <input name="nombre" type="text" required>
                    <label>Nombre</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class='bx bx-user'></i></span>
                    <input name="apellido" type="text" required>
                    <label>Apellido</label>
                </div>

                <div class="input-box">
                    <span class="icon"><i class='bx bx-at'></i></span>
                    <input name="email" type="text" required>
                    <label>Email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class='bx bx-phone'></i></span>
                    <input name="telefono" type="text" required>
                    <label>Telefono</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class='bx bx-news'></i></span>
                    <input name="dni" type="text" required>
                    <label>DNI</label>
                </div>
                <div class="input-box">
                    <span class="icon"><i class='bx bxs-envelope'></i></span>
                    <input name="contraseña" type="password" required>
                    <label>Contraseña</label>
                </div>
                <button class="btn">Registrar</button>

            </form>
        </div>

</body>

</html>