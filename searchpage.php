<?php
session_start();
include_once "koneksi.php";
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: tropictix.php");
    exit;
}
if (isset($_SESSION['loggedin']) === true) {
    $login_logout_link = '<a href="tropictix.php?logout=true"><button id="loginlogout">Logout</button></a>';
} else {
    $login_logout_link = '<a href="login.php"><button id="loginlogout">Login</button></a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TropicTIX - Search Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="head_1">
            <h1>TropicTIX</h1>
            <h6>Where the Beat Meets the Beach</h6>
        </div>
        <?php include 'searchbar.php'; ?>
    </header>
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
                <a href="daftarbelanja.php"><i class="fas fa-shopping-basket"></i></i></a>
                <?php echo $login_logout_link ?>
            </div>
        </div>
    </div>
    <hr>
    <a href="TropicTIX.php"><button class="btn-kembali">&lt Kembali</button></a>
    <main>
        <h2>Hasil Pencarian Konser untuk "<span class="tptix"><?php echo htmlspecialchars($_GET['searchValue']); ?></span>"</h2>
        <div class="container">
            <?php
            if (isset($_GET['searchValue'])) {
                $searchValue = '%' . $koneksi->real_escape_string($_GET['searchValue']) . '%';
                $sql = "SELECT * FROM konser WHERE judul_Konser LIKE ? OR penyanyi LIKE ? OR genre LIKE ? OR harga LIKE ? OR tanggal_2 LIKE ? or lokasi LIKE ? ORDER BY tanggal_2 ASC";
                $stmt = $koneksi->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param('ssssss', $searchValue, $searchValue, $searchValue, $searchValue, $searchValue, $searchValue);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='konserdetail'>";
                            echo "<img src='gambar/home/" . htmlspecialchars($row['gambar']) . "' alt='Konser Image'><br>";
                            echo "<label class='labelkonser'>" . htmlspecialchars($row['tanggal_2']) . " <span>Rp " . htmlspecialchars($row['harga']) . "</span></label>";
                            echo "<label class='labelkonser2'>" . htmlspecialchars($row['judul_Konser']) . "</label>";
                            echo "<label class='labelkonser3'>" . htmlspecialchars($row['penyanyi']) . "</label>";
                            echo "<a href='detailkonser.php?id=" . htmlspecialchars($row['id_Konser']) . "'>"; 
                            echo "<button class='detailkonser'>Read More</button>";
                            echo "</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Tidak ada konser dengan kata kunci '" . htmlspecialchars($_GET['searchValue']) . "'</p>";
                    }
                    $stmt->close();
                } else {
                    echo "<p>Error in prepared statement: " . htmlspecialchars($koneksi->error) . "</p>";
                }
            } else {
                echo "<p>Tidak ada kata kunci pencarian yang diberikan.</p>";
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
<script src="menuatas.js"></script>
 