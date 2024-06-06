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
<header>
    <div class="head_1">
        <a href="../TropicTIX.php"><h1>TropicTIX</h1></a>
        <h6>Where the Beat Meets the Beach</h6>
    </div>
    <form id="searchbar">
        <input type="text" id="searchvalue" placeholder="Cari Konser"> 
        <button id="searchbutton" type="submit">Cari</button>
    </form>
</header>
<div class="bcrumb">
    <ul class="breadcrumb">
        <li><a href="../TropicTIX.php">Home</a></li>
        <li>Kygo-kids in love</li>
      </ul>
</div>
<hr>
<a href="TropicTIX.php"><button class="btn-kembali">&lt Kembali</button></a>

    <main>
        <?php
        include 'koneksi.php';
        $id_konser = $_GET['id'];

        $sql = "SELECT * FROM konser WHERE id_Konser = $id_konser";
        $result = $koneksi->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<table id='table_1'>";
                echo "<tr>";
                echo "<td><img src='" . $row['gambar'] . "' alt=''></td>";
                echo "<td>";
                echo "<div id='detailkonser'>";
                echo "<p class='judulkonser'>" . $row['judul_Konser'] . "</p>";
                echo "<p class='tglkonser'>" . $row['tanggal'] . " <span id='wktkonser'>" . $row['waktu_mulai'] . "</span></p>";
                echo "<p class='tempatkonser'>" . $row['lokasi'] . "</p>";
                echo "<p class='hargatiket'>Rp " . $row['harga'] . "</p>";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                
                // Deskripsi konser
                echo "<p class='deskripsi-konser'>" . $row['deskripsi'] . "</p>";
                
                // Daftar aturan konser
                echo "<fieldset class='fstick'>";
                echo "<legend><p>Aturan Konser</p></legend>";
                echo "<table id='table_2'>";
                echo "<tr>";
                echo "<td>";
                echo "<h3>Aturan Konser</h3>";
                echo "<ul>";
                echo "<li><span id='poinlist'>Usia:</span> " . $row['aturan_Konser'] . "</li>";
                echo "</ul>";
                echo "</td>";
                echo "<td>";
                echo "<h3>Daftar Lagu Yang di Bawakan</h3>";
                echo "<ol>";
                // Pecah daftar lagu menjadi array
                $daftar_lagu = explode(",", $row['daftar_lagu']);
                foreach($daftar_lagu as $lagu) {
                    echo "<li>$lagu</li>";
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
        $koneksi->close();
        ?>
    </main>
    <?php
    include_once "footer.php";
    ?>
</body>
</html>
