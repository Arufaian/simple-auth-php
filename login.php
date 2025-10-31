<?php
    include "./koneksi.php";
    session_start();

    if ($_POST['login']) {
        $user     = $_POST['username'];
        $password = md5($_POST['password']);

        $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user'");
        $data  = mysqli_fetch_assoc($query);

        if ($data) {
            if ($password === $data['password']) {
                $_SESSION['username'] = $data['username'];
                $_SESSION['level']    = $data['level'];
                header("location:dosen.php");
                exit;
            } else {
                echo "<script>alert('Password salah');window.location='login.php';</script>";
            }
        } else {
            echo "<script>alert('Username tidak ditemukan');window.location='login.php';</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login page</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <div class="container d-flex justify-content-center mt-5">
      <div class="card p-4 col-md-4 shadow">
        <h3 class="text-center">Login</h3>
        <form method="POST" action="">
          <div class="my-3">
            <input
              type="text"
              class="form-control"
              placeholder="Username"
              name="username"
            />
          </div>

          <div class="mb-3">
            <input
              type="password"
              class="form-control"
              placeholder="Password"
              name="password"
            />
          </div>

          <button class="bg-primary btn w-100 text-light" name="login" value="login">
            Login
          </button>
        </form>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
