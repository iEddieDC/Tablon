<?php include_once "../js/functions.js";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../bootstrap-4.5.2/css/bootstrap.min.css">
    <title>Login</title>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Iniciar Sesión</h5>
            <form action="../config/sesions_config/login_val.php" method="POST" class="form-signin">
              <div class="form-label-group">
                <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail">Nombre de usuario</label>
              </div>
              <div class="form-label-group">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Contraseña" required>
                <label for="inputPassword">Contraseña</label>

              </div>
              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Recordar contraseña</label>
              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>