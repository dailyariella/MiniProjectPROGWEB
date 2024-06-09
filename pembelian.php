<?php
session_start(); // Memulai session

if (isset($_SESSION['loggedin']) === false) {
    header("Location: login.php");
    exit;
}
if (isset($_SESSION['loggedin']) === true) {
    $login_logout_link = '<a href="logout.php"><button id="loginlogout">Logout</button></a>';
} else {
    $login_logout_link = '<a href="login.php"><button id="loginlogout">Login</button></a>';
}

include_once "koneksi.php";

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
</head>
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


<body>
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
    <?php
    echo "<a href='detailkonser.php?id=" . $id_Konser . "'><button class='btn-kembali'>&lt Kembali</button></a>";
    ?>
    <main>
        <p class="pemesanan">Menu Pemesanan</p>
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
            <form id="formbeli" action="pemesanansukses.html">
                <table>
                    <tr>
                        <td>
                            <label>Jumlah Tiket :</label>
                        </td>
                        <td>
                            <input type="number" id="jumlahTiket" min="1" max="10" value="1" required disabled><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nama:</label>
                        </td>
                        <td>
                            <input type="text" required disabled><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Nomor Telepon:</label>
                        </td>
                        <td>
                            <input type="tel" pattern="[0-9]{10,12}" required disabled><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Email:</label>
                        </td>
                        <td>
                            <input type="email" required disabled><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="reset" value="Batal" disabled>
                        </td>
                        <td>
                            <input type="submit" value="Beli Tiket" disabled>
                        </td>
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

    <script>
        function selectTicket(ticketId) {
            // Mendapatkan elemen radio button yang sesuai
            var radioButton = document.getElementById(ticketId);
            radioButton.checked = true;

            // Mendapatkan semua elemen radio button
            var radioButtons = document.querySelectorAll("input[name='ticket']");
            var selectedPrice = 0;

            // Menghapus kelas 'selected' dari semua elemen
            var ticketItems = document.querySelectorAll('.ticket-item');
            ticketItems.forEach(function(item) {
                item.classList.remove('selected');
            });

            // Menambahkan kelas 'selected' ke elemen yang dipilih dan mendapatkan harga tiket yang dipilih
            radioButtons.forEach(function(radioButton) {
                if (radioButton.checked) {
                    selectedPrice = parseInt(radioButton.getAttribute('data-harga'));
                    radioButton.closest('.ticket-item').classList.add('selected');
                }
            });

            // Mendapatkan jumlah tiket
            var jumlahTiket = document.getElementById('jumlahTiket').value;

            // Menghitung total harga
            var totalHarga = selectedPrice * jumlahTiket;

            // Menampilkan total harga
            document.getElementById('totalHarga').innerText = 'Rp ' + totalHarga.toLocaleString('id-ID');

            var formInputs = document.querySelectorAll('#formbeli input');
            formInputs.forEach(function(input) {
                input.disabled = false;
            });
        }
        document.getElementById('jumlahTiket').addEventListener('input', function() {
            selectTicket(document.querySelector("input[name='ticket']:checked").id);
        });

        var radioButtons = document.querySelectorAll("input[name='ticket']");
        radioButtons.forEach(function(radioButton) {
            radioButton.addEventListener('change', function() {
                selectTicket(radioButton.id);
            });
        });
        var ticketItems = document.querySelectorAll('.ticket-item');
        ticketItems.forEach(function(item) {
            item.addEventListener('click', function() {
                selectTicket(item.querySelector("input[name='ticket']").id);
            });
        });
    </script>
    <script src="menuatas.js"></script>
</body>
</html>