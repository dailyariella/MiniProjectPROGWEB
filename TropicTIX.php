<?php
session_start();
include_once "koneksi.php";

if (isset($_SESSION['loggedin']) === true) {
    $login_logout_link = '<a href="login.php"><button id="loginlogout">Logout</button></a>';
} else {
    $login_logout_link = '<a href="login.php"><button id="loginlogout">Login</button></a>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TropicTIX</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="head_1">
            <h1>TropicTIX</h1>
            <h6>Where the Beat Meets the Beach</h6>
        </div>
        <?php include 'searchbar.php'; ?>
        <div class="user_action">
            <?php echo $login_logout_link; ?>
    </div>
    </header>
    <hr>
    <main>
        <h2>Tonton Konser Paling Seru bersama <span class="tptix">TropicTIX</span></h2>
        <div class="container">
            <?php
            $sql = "SELECT * FROM konser";
            $result = $koneksi->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='konserdetail'>";
                    echo "<img src='" . $row['gambar'] . "'><br>";
                    echo "<label class='labelkonser'>" . $row['tanggal'] . " <span>Rp " . $row['harga'] . "</span></label>";
                    echo "<label class='labelkonser2'>" . $row['judul_Konser']. " Bersama ".$row['penyanyi'] . "</label>";
                    echo "<a href='detailkonser.php?id=" . $row['id_Konser'] . "'>"; 
                    echo "<button class='detailkonser'>Read More</button>";
                    echo "</a>";
                    echo "</div>";
                }
            } else {
                echo "0 hasil";
            }
            $koneksi->close();
            ?>
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
