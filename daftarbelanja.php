<?php
session_start();
include_once "koneksi.php";

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: tropictix.php");
    exit;
}
if (isset($_SESSION['loggedin']) === false) {
    session_unset();
    header("Location: login.php");
    exit;
}
if (isset($_SESSION['loggedin']) === true) {
    $login_logout_link = '<a href="tropictix.php?logout=true"><button id="loginlogout">Logout</button></a>';
} else {
    $login_logout_link = '<a href="login.php"><button id="loginlogout">Login</button></a>';
}
function ambilDataPembelian() {
    include "koneksi.php";
    $pembelian = array();

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        $id_user = $_SESSION['username'];
        $query = "SELECT * FROM pembelian WHERE id_user = '$id_user'";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            $pembelian[] = $row;
        }
    }

    return $pembelian;
}

$pembelian = ambilDataPembelian();

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
    <title>TropicTIX</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="Styles.css">
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
                <a href="#"><i class="fas fa-shopping-basket"></i></i></a>
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
    <?php foreach ($pembelian as $item): ?>
        <?php
        $id_tiket = $item['id_tiket'];
        $query_tiket = "SELECT * FROM konser INNER JOIN tiket ON konser.id_Konser = tiket.id_Konser WHERE tiket.id_tiket = '$id_tiket'";
        $result_tiket = mysqli_query($koneksi, $query_tiket);
        $row_tiket = mysqli_fetch_assoc($result_tiket);
        ?>
        <div class="tiket">
            <img src="gambar/tiket/<?php echo $row_tiket['image_path']; ?>" alt="">
            <p id="jumlahtiket">Jumlah : <?php echo $item['jumlah']; ?> Tiket</p>
            <p id="totalharga">Total Harga : Rp <?php echo $item['jumlah'] * $row_tiket['harga']; ?></p>
            <button onclick="hapusPembelian(<?php echo $item['id_pembelian']; ?>)">Hapus</button>
            <button onclick="bayar(<?php echo $item['id_pembelian']; ?>)">Bayar</button>
        </div>
    <?php endforeach; ?>
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
