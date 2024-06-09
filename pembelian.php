<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <link rel="stylesheet" href="StylesheetPembelian.css">
</head>
<body>
    <header>
        <div class="head_1">
            <a href="../TropicTIX.html">
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
            <li><a href="TropicTIX.php">Home</a></li>
            <li><a href="detailkonser.php">Kygo-KidsInLove</a></li>
            <li>Pemesanan</li>

          </ul>
    </div>
    <hr>
    <a href="detailkonser.php"><button class="btn-kembali">&lt Kembali</button></a>

    <main>

        <p class="pemesanan">Menu Pemesanan</p>
        <fieldset>
            <legend>Pilih Tiket Kamu</legend>
        <div class="ticket">
            <div class="ticket-item">
                <img src="gambar/bpass.jpg" alt="">
                <div class="ticket-details">
                    <h2>Bronze Ticket</h2>
                    <p class="stok">Stok Tersedia: 100</p>
                    <p>Rp 325.000</p>
                    <input type="radio" name="ticket" id="bronze" value="bronze">
                    <label for="bronze">Pilih Bronze</label>
                </div>
            </div>
            <div class="ticket-item">
                <img src="gambar/gpass.jpg" alt="">
                <div class="ticket-details">
                    <h2>Gold Ticket</h2>
                    <p class="stok">Stok Tersedia: 50</p>
                    <p>Rp 425.000</p>
                    <input type="radio" name="ticket" id="gold" value="gold">
                    <label for="gold">Pilih Gold</label>
                </div>
            </div>
            <div class="ticket-item">
                <img src="gambar/ppass.jpg" alt="">
                <div class="ticket-details">
                    <h2>Platinum Ticket</h2>
                    <p class="stok">Stok Tersedia: 20</p>
                    <p>Rp 525.000</p>
                    <input type="radio" name="ticket" id="platinum" value="platinum">
                    <label for="platinum">Pilih Platinum</label>
                </div>
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
                                <input type="number" min="1" max="10" value="1" required><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Nama:</label>
                            </td>
                            <td>
                                <input type="text" required><br><br>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Nomor Telepon:</label>

                            </td>
                            <td>
                                <input type="tel" pattern="[0-9]{10,12}" required><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Email:</label>
                            </td>
                            <td>
                                <input type="email" required><br><br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="reset" value="Batal">
                            </td>
                            <td>
                                <input type="submit" value="Beli Tiket">
                            </td>
                        </tr>
                    </table>
            </form>
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
</body>

</html>