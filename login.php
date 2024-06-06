<?php
include_once "koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE id_user = '$username' AND password = '$password'";
    $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: tropictix.php");
    } else {
        $error_message = "Username atau Password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TropicTIX - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="head_1">
            <h1>TropicTIX</h1>
            <h6>Where the Beat Meets the Beach</h6>
        </div>
    </header>
    <hr>
    <main>
        <h2>Login to <span class="tptix">TropicTIX</span></h2>
        <div class="container login-container">
            <form class="login-form" action="login.php" method="post">
                <?php if (!empty($error_message)): ?>
                    <div class="error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukan Username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukan Password" required>
                
                <button type="submit">Login</button>
            </form>
            <p>Belum Punya Akun? <a href="register.php">Daftar</a></p>
        </div>
    </main>
    <hr>
    <footer>
        <p>&copy; 2024 TropicTIX. All rights reserved.</p>
        <div class="sosmeds">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
    </footer>
</body>
</html>
