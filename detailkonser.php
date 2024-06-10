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

include 'koneksi.php';
$id_konser = $_GET['id'];

$sql = "SELECT * FROM konser WHERE id_Konser = $id_konser";
$result = $koneksi->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Konser</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="stylesheet.css">
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
                <a href="daftarbelanja.php"><i class="fas fa-shopping-basket"></i></i></a>
                <?php echo $login_logout_link ?>
            </div>
        </div>
    </div>
<header>
    <div class="head_1">
        <a href="TropicTIX.php"><h1>TropicTIX</h1></a>
        <h6>Where the Beat Meets the Beach</h6>
    </div>
    <form id="searchbar">
        <input type="text" id="searchvalue" placeholder="Cari Konser"> 
        <button id="searchbutton" type="submit">Cari</button>
    </form>
</header>
<div class="bcrumb">
    <ul class="breadcrumb">
        <li><a href="TropicTIX.php">Home</a></li>
        <?php
        $sql = "SELECT judul_konser FROM konser WHERE id_konser = $id_konser";
        $result1 = $koneksi->query($sql);
        $row = $result1->fetch_assoc();
        echo "<li><a href='detailkonser.php?id=" . $id_konser . "'>" . $row['judul_konser'] . "</a></li>";
        ?>
    </ul>
</div>
<hr>
<a href="TropicTIX.php"><button class="btn-kembali">&lt Kembali</button></a>
<!-- echo "<a href='detailkonser.'><button class='btn-kembali'>&lt Kembali</button></a>"; -->

<main>
    <?php
    // include 'koneksi.php';
    // $id_konser = $_GET['id'];

    // $sql = "SELECT * FROM konser WHERE id_Konser = $id_konser";
    // $result = $koneksi->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<table id='table_1'>";
            echo "<tr>";
            echo "<td><img src='gambar/detail/". htmlspecialchars($row['gambardetail']) . "' alt=''></td>";
            echo "<td>";
            echo "<div id='detailkonser'>";
            echo "<p class='judulkonser'>" . htmlspecialchars($row['judul_Konser']) . "</p>";
            echo "<p class='tglkonser'>" . htmlspecialchars($row['tanggal_2']) . " <span id='wktkonser'>" . htmlspecialchars($row['waktu_mulai']) . "</span></p>";
            echo "<p class='tempatkonser'>" . htmlspecialchars($row['lokasi']) . "</p>";
            echo "<p class='penyanyi'>" . htmlspecialchars($row['penyanyi']) . "</p>";
            echo "</div>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            
            // Deskripsi konser
            echo "<p class='deskripsi-konser'>" . htmlspecialchars($row['deskripsi']) . "</p>";

            // Ticket section
            echo "<fieldset class='fstick'>";
            echo "<legend><p>Beli Tiketmu!</p></legend>";
            echo "<div class='main-container'>";
            echo "<div class='tickets-container'>";
            $sql_tickets = "SELECT * FROM tiket WHERE id_konser = $id_konser";
            $result_tickets = $koneksi->query($sql_tickets);

            if ($result_tickets->num_rows > 0) {
                while ($ticket = $result_tickets->fetch_assoc()) {
                    echo "<div class='ticket'>";
                    echo "<h2>" . htmlspecialchars($ticket['jenis_tiket']) . "</h2>";
                    echo "<p class='stock'>Stok Tersedia: " . htmlspecialchars($ticket['stock']) . "</p>";
                    echo "<p>Rp " . htmlspecialchars($ticket['harga']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No tickets available for this concert.</p>";
            }
            echo "</div>";
            echo "<div class='seatplan'>";
            echo "<img src='gambar/STAGE.png' alt=''>";
            echo "<p>Denah Panggung</p>";
            echo "</div>";
            echo "</div>";
            echo "<a href='pembelian.php?id=" . $id_konser . "'><button class='beli-button'>Beli</button></a>";
            
            echo "</fieldset>";
            
            // Daftar aturan konser
            echo "<fieldset class='fstick'>";
            echo "<legend><p>Aturan Konser</p></legend>";
            echo "<table id='table_2'>";
            echo "<tr>";
            echo "<td>";
            echo "<h3>Aturan Konser</h3>";
            echo "<ul>";
            echo "<li><span id='poinlist'>Usia:</span> " . htmlspecialchars($row['aturan_Konser']) . "</li>";
            echo "</ul>";
            echo "</td>";
            echo "<td>";
            echo "<h3>Daftar Lagu Yang di Bawakan</h3>";
            echo "<ol>";
            $daftar_lagu = explode(",", htmlspecialchars($row['daftar_lagu']));
            foreach($daftar_lagu as $lagu) {
                echo "<li>" . $lagu . "</li>";
            }
            echo "</ol>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</fieldset>";
        }
    } else {
        echo "Data konser tidak ditemukan";
    }
    ?>
</main>
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