<?php
    require "koneksi.php";

    // Query untuk mendapatkan kategori
    $queryKategori = mysqli_query($con, "SELECT * FROM kategori");

    // get produk by nama produk/keyword
    if(isset($_GET['keyword'])){
        $keyword = '%' . $con->real_escape_string($_GET['keyword']) . '%';
        $stmt = $con->prepare("SELECT * FROM produk WHERE nama LIKE ?");
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $queryProduk = $stmt->get_result();
    }
    // get produk by kategori
    else if(isset($_GET['kategori'])){
        $kategori = $con->real_escape_string($_GET['kategori']);
        $stmtKategori = $con->prepare("SELECT id FROM kategori WHERE nama = ?");
        $stmtKategori->bind_param("s", $kategori);
        $stmtKategori->execute();
        $resultKategori = $stmtKategori->get_result();
        $kategoriId = $resultKategori->fetch_assoc();

        if($kategoriId) {
            $stmtProduk = $con->prepare("SELECT * FROM produk WHERE kategori_id = ?");
            $stmtProduk->bind_param("i", $kategoriId['id']);
            $stmtProduk->execute();
            $queryProduk = $stmtProduk->get_result();
        } else {
            // Jika kategori tidak ditemukan, hasilkan queryProduk kosong
            $queryProduk = $con->query("SELECT * FROM produk WHERE 0");
        }
    }
    // get produk default
    else{
        $queryProduk = mysqli_query($con, "SELECT * FROM produk");
    }

    $countData = mysqli_num_rows($queryProduk);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online || Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <!-- banner -->
    <div class="container-fluid banner-produk d-flex align-items-center">
        <div class="container">
            <h1 class="text-white text-center">Produk</h1>
        </div>
    </div>

    <!-- body -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5">
                <h3>Kategori</h3>
                <ul class="list-group">
                    <?php while($kategori = mysqli_fetch_array($queryKategori)){ ?>
                    <a class="no-decoration" href="produk.php?kategori=<?php echo $kategori['nama']; ?>">
                        <li class="list-group-item"><?php echo $kategori['nama']; ?></li>
                    </a>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-9">
                <h3 class="text-center mb-3">Produk</h3>
                <div class="row">
                    <?php
                        if($countData<1){
                    ?>
                        <h4 class="text-center my-5">Produk Yang Dicari Tidak Tersedia</h4>
                    <?php
                        }
                    ?>

                    <?php while($produk = mysqli_fetch_array($queryProduk)){ ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="image-box">
                                <img src="img/<?php echo $produk['foto']; ?>" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $produk['nama']; ?></h4>
                                <p class="card-text text-truncate"><?php echo $produk['detail']; ?></p>
                                <p class="card-text text-harga"><?php echo $produk['harga']; ?></p>
                                <a href="produk-detail.php?nama=<?php echo $produk['nama']; ?>" class="btn warna5 text-white">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- foother -->
     <?php require "foother.php";?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
