<?php
session_start();
include_once "koneksi.php";

if (isset($_SESSION['loggedin']) === true) {
    $login_logout_link = '<a href="logout.php"><button id="loginlogout">Logout</button></a>';
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
    <div class="floating-menu">
        <div class="menu-content">
            <div class="logo">
                <h1>TropicTIX</h1>
            </div>
            <div id="floating-right" class="user_action">
                <form id="searchbar2" action="searchpage.php" method="GET">
                    <input type="text" id="searchvalue2" name="searchValue" placeholder="Cari Konser"> 
                    <button id="searchbutton2" type="submit">Cari</button>
                </form>
                <?php echo $login_logout_link ?>
            </div>
        </div>
    </div>
    <header id="main-header">
        <div class="head_1">
            <h1>TropicTIX</h1>
            <h6>Where the Beat Meets the Beach</h6>
        </div>
        <div id="search-container">
            <?php include 'searchbar.php'; ?>
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
                    echo "<img src='gambar/home/". htmlspecialchars($row['gambar']) . "'><br>";
                    echo "<label class='labelkonser'>" . htmlspecialchars($row['tanggal_2']) . " <span>Rp " . htmlspecialchars($row['harga']) . "</span></label>";
                    echo "<label class='labelkonser2'>" . htmlspecialchars($row['judul_Konser']). "</label>";
                    echo "<label class='labelkonser3'>" . htmlspecialchars($row['penyanyi']) . "</label>";
                    echo "<a href='detailkonser.php?id=" . htmlspecialchars($row['id_Konser']) . "'>"; 
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

    <script src="menuatas.js"></script>
</body>
</html>
