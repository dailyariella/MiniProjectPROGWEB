<?php
include_once "koneksi.php";
session_start();

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE id_user = ? AND password = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("location: tropictix.php");
        exit;
    } else {
        $error_message = "Username atau password salah";
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
    <link rel="shortcut icon" type="image/x-icon" href="ttix.png" />
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
                <input type="text" id="username" name="username" placeholder="Username" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                
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
