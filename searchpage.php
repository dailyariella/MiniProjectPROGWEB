<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TropicTIX - Search Results</title>
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
    <hr>
    <main>
        <h2>Hasil Pencarian untuk "<span class="tptix"><?php echo htmlspecialchars($_GET['searchValue']); ?></span>"</h2>
        <div class="container">
            <?php
            // Koneksi ke database
            include_once "koneksi.php";

            // Cek apakah ada nilai pencarian
            if (isset($_GET['searchValue'])) {
                $searchValue = '%' . $koneksi->real_escape_string($_GET['searchValue']) . '%';
                $sql = "SELECT * FROM konser WHERE judul_Konser LIKE ? OR penyanyi LIKE ? OR daftar_lagu LIKE ? OR harga LIKE ?";
                $stmt = $koneksi->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('ssss', $searchValue, $searchValue, $searchValue, $searchValue);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<div class='konserdetail'>";
                            echo "<img src='" . htmlspecialchars($row['gambar']) . "'><br>";
                            echo "<label class='labelkonser'>" . htmlspecialchars($row['tanggal']) . " <span>Rp " . htmlspecialchars($row['harga']) . "</span></label>";
                            echo "<label class='labelkonser2'>" . htmlspecialchars($row['judul_Konser']) . " Bersama " . htmlspecialchars($row['penyanyi']) . "</label>";
                            echo "<a href='detailkonser.php?id=" . htmlspecialchars($row['id_Konser']) . "'>"; 
                            echo "<button class='detailkonser'>Read More</button>";
                            echo "</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "Tidak ada konser dengan kata kunci '" . htmlspecialchars($_GET['searchValue']) . "'";
                    }
                    $stmt->close();
                } else {
                    echo "Error preparing statement: " . $koneksi->error;
                }
            } else {
                echo "Tidak ada kata kunci pencarian yang diberikan.";
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
