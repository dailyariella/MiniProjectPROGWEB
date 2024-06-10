<?php
session_start();
include_once "koneksi.php";

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: tropictix.php");
    exit;
}

if (!isset($_SESSION['loggedin'])) {
    session_unset();
    header("Location: login.php");
    exit;
}

$login_logout_link = isset($_SESSION['loggedin']) ? '<a href="tropictix.php?logout=true"><button id="loginlogout">Logout</button></a>' : '<a href="login.php"><button id="loginlogout">Login</button></a>';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_SESSION['username'];
    $id_tiket = $_POST['id_tiket'];
    $jumlah = $_POST['jumlah'];
    $atasnama = $_POST['atasnama'];
    $nohp = $_POST['nohp'];
    $emailbeli = $_POST['emailbeli'];
    $total_harga = $_POST['total_harga'];

    $sql = "SELECT stock FROM tiket WHERE id_tiket = $id_tiket";
    $result = $koneksi->query($sql);
    $row = $result->fetch_assoc();
    $current_stock = $row['stock'];

    if ($current_stock >= $jumlah) {
        $new_stock = $current_stock - $jumlah;
        $sql = "UPDATE tiket SET stock = $new_stock WHERE id_tiket = $id_tiket";
        $koneksi->query($sql);

        $sql = "INSERT INTO pembelian (id_user, id_tiket, jumlah, atasnama, nohp, emailbeli, total_harga) 
                VALUES ('$id_user', '$id_tiket', '$jumlah', '$atasnama', '$nohp', '$emailbeli', '$total_harga')";
        if ($koneksi->query($sql) === TRUE) {
            echo "<script>alert('Pemesanan Berhasil. Kembali ke Home.'); window.location.href = 'TropicTIX.php';</script>";
        } else {
            echo "<script>alert('Error: " . $sql . "\\n" . $koneksi->error . "');</script>";        }
    } else {
        echo "<script>alert('Stok tidak mencukupi. Kembali.'); window.location.href = 'pembelian.php?id=$id_Konser';</script>";
    }
    $koneksi->close();
    exit;
}

$id_Konser = $_GET['id'];
$sql = "SELECT * FROM tiket WHERE id_konser = $id_Konser";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="StylesheetPembelian.css">
    <link rel="shortcut icon" type="image/x-icon" href="ttix.png" />
</head>
<body>
<div class="floating-menu">
    <div class="menu-content">
        <div class="logo">
        <a href="tropictix.php"><h1>TropicTIX</h1></a>
        </div>
        <div id="floating-right" class="user_action">
            <form id="searchbar2" action="searchpage.php" method="GET">
                <input type="text" id="searchvalue2" name="searchValue" placeholder="Cari Konser">
                <button id="searchbutton2" type="submit">Cari</button>
            </form>
            <a href="daftarbelanja.php"><i class="fas fa-shopping-basket"></i></a>
            <?php echo $login_logout_link ?>
        </div>
    </div>
</div>
<header>
    <div class="head_1">
        <a href="TropicTIX.php">
            <h1>TropicTIX</h1>
        </a>
        <h6>Where the Beat Meets the Beach</h6>
    </div>
    <form id="searchbar">
        <input type="text" id="searchvalue" placeholder="Cari Konser">
        <button id="searchbutton" type="submit">Cari</button>
    </form>
</header>
<div class="bcrumb">
    <ul class="breadcrumb">
        <li>
            <a href="TropicTIX.php">Home</a>
        </li>
        <li>
            <a href="detailkonser.php?id=<?php echo $id_Konser; ?>">
                <?php
                $sql = "SELECT judul_konser FROM konser WHERE id_konser = $id_Konser";
                $result1 = $koneksi->query($sql);
                $row = $result1->fetch_assoc();
                echo $row['judul_konser'];
                ?>
            </a>
        </li>
        <li>
            <a href="pembelian.php?id=<?php echo $id_Konser; ?>">Pembelian</a>
        </li>
    </ul>
</div>
<hr>
<?php echo "<a href='detailkonser.php?id=" . $id_Konser . "'><button class='btn-kembali'>&lt Kembali</button></a>"; ?>
<main>
    <p class="pemesanan">Menu Pembelian</p>
    <fieldset>
        <legend>Pilih Tiket Kamu</legend>
        <div class="ticket">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='ticket-item' onclick='selectTicket(" . $row['id_tiket'] . ")'>";
                    echo "<img src='gambar/tiket/" . $row['image_path'] . "' alt=''>";
                    echo "<div class='ticket-details'>";
                    echo "<h2>" . $row['jenis_tiket'] . "</h2>";
                    echo "<p class='stok'>Stok Tersedia: " . $row['stock'] . "</p>";
                    echo "<p>Rp " . $row['harga'] . "</p>";
                    echo "<input type='radio' name='ticket' id='" . $row['id_tiket'] . "' value='" . $row['id_tiket'] . "' data-harga='" . $row['harga'] . "'>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "Tidak ada tiket tersedia.";
            }
            ?>
        </div>
    </fieldset>
    <fieldset>
        <form id="formbeli" action="" method="POST">
            <input type="hidden" name="id_user" value="<?php echo $_SESSION['username']; ?>">
            <input type="hidden" name="id_tiket" id="id_tiket">
            <input type="hidden" name="total_harga" id="total_harga">
            <table>
                <tr>
                    <td><label>Jumlah Tiket :</label></td>
                    <td><input type="number" id="jumlahTiket" name="jumlah" min="1" max="10" value="1" required><br><br></td>
                </tr>
                <tr>
                    <td><label>Nama:</label></td>
                    <td><input type="text" id="nama" name="atasnama" required><br><br></td>
                </tr>
                <tr>
                    <td><label>Nomor Telepon:</label></td>
                    <td><input type="tel" id="nomorTelepon" name="nohp" pattern="[0-9]{10,12}" required><br><br></td>
                </tr>
                <tr>
                    <td><label>Email:</label></td>
                    <td><input type="email" id="email" name="emailbeli" required><br><br></td>
                </tr>
                <tr>
                    <td><input type="reset" value="Batal"></td>
                    <td><input type="submit" value="Beli Tiket"></td>
                </tr>
            </table>
        </form>
    </fieldset>
    <fieldset>
        <legend>Total Harga</legend>
        <div id="totalHarga">Rp 0</div>
    </fieldset>
</main>
<hr>
<footer>
    <p>&copy; 2024 TropicTIX. All rights reserved.</p>
    <div class="sosmeds">
        <i class="fab fa-house"></i>
        <a href="#"><i class="fab fa-facebook"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
    </div>
</footer>
<script src="pembelian.js" ></script>
<script src="menuatas.js"></script>
</body>
</html>
