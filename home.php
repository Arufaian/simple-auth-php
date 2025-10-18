<?php
    session_start();

    // Cek apakah user sudah login
    if (! isset($_SESSION['username'])) {
        header("location:login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
      crossorigin="anonymous"
    />
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="text-center">Selamat Datang</h3>
            <p class="text-center">
                Anda login sebagai <strong><?php echo $_SESSION['username'];?></strong><br>
                Level: <span class="badge bg-primary"><?php echo $_SESSION['level'];?></span>
            </p>
            <div class="text-center">
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>
