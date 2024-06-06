<?php
include_once "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_User = trim($_POST["id_User"]);
    $nama = trim($_POST["nama"]);
    $no_telepon = trim($_POST["no_telepon"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    if (empty($id_User) || empty($nama) || empty($no_telepon) || empty($email) || empty($password)) {
        $message = "Please fill in all fields.";
    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters long.";
    } elseif (!ctype_alnum($no_telepon)) {
        $message = "Phone number must be alphanumeric.";
    } else {
        $stmt_check_username = $koneksi->prepare("SELECT id_user FROM user WHERE id_user = ?");
        $stmt_check_username->bind_param("s", $id_User);
        $stmt_check_username->execute();
        $stmt_check_username->store_result();

        if ($stmt_check_username->num_rows > 0) {
            $message = "Username already taken.";
        } else {
            $stmt = $koneksi->prepare("INSERT INTO user (id_user, nama, no_telepon, email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $id_User, $nama, $no_telepon, $email, $password);
            if ($stmt->execute()) {
                $message = "Registration successful! <a href='login.php'>Click here to login</a>";
            } else {
                $message = "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $stmt_check_username->close();
    }
    mysqli_close($koneksi);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TropicTIX - Registration</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <script>
        function validateForm() {
            const password = document.forms["registrationForm"]["password"].value;
            const phone = document.forms["registrationForm"]["no_telepon"].value;
            const phonePattern = /^[a-zA-Z0-9]+$/;

            if (password.length < 8) {
                alert("Password must be at least 8 characters long.");
                return false;
            }

            if (!phone.match(phonePattern)) {
                alert("Phone number must be alphanumeric.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <header>
        <div class="head_1">
            <h1>TropicTIX</h1>
            <h6>Where the Beat Meets the Beach</h6>
        </div>
        <form id="searchbar">
            <input type="text" id="searchvalue" placeholder="Cari Konser"> 
            <button id="searchbutton" type="submit">Cari</button>
        </form>
    </header>
    <hr>
    <main>
        <h2>Register to <span class="tptix">TropicTIX</span></h2>
        <div class="container login-container">
            <form name="registrationForm" class="login-form" action="register.php" method="POST" onsubmit="return validateForm()">
                <label for="id_User">ID User:</label>
                <input type="text" name="id_User" maxlength="20" required><br>
                <label for="nama">Nama:</label>
                <input type="text" name="nama" maxlength="50" required><br>
                <label for="no_telepon">No Telepon:</label>
                <input type="text" name="no_telepon" maxlength="12" required><br>
                <label for="email">Email:</label>
                <input type="email" name="email" maxlength="50" required><br>
                <label for="password">Password:</label>
                <input type="password" name="password" minlength="8" required><br>
                <button type="submit">Register</button>
            </form>
            <?php
            if (isset($message)) {
                echo "<p>$message</p>";
            }
            ?>
            <p>Sudah Punya Akun? <a href="login.php">Login</a></p>
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