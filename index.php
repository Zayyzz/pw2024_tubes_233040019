<?php
    require "koneksi.php";
    $queryProduk = mysqli_query($con, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Complatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php require "navbar.php"; ?>
<!-- banner -->
    <div class="container-fluid banner d-flex align-items-center">
        <div class="container text-center text-white">
            <h1>Raja Game</h1>
            <h3>Mau Cari Apa?</h3>
            <div class="col-md-8 offset-md-2">
                <form method="get" action="produk.php">
            <div class="input-group input-group-lg my-4">
                <input type="text" class="form-control" placeholder="Nama Barang" aria-label="Recipient's username" aria-describedby="basic-addon2" name="keyword">
                <button type="submit" class="btn warna2 text-white">Telusuri</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- highlight kategori -->
       <div class="container-fluid backround py-5">
            <div class="container text-center text-white">
                <h3>Kategori Terlaris</h3>

                <div class="row mt-5">
                    <div class="col-md-4 mb-3">
                        <div class="highlighted-kategori kategori-ps-3 d-flex justify-content-center
                        align-items-center">
                            <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Games%20PS%203">game playstation 3</a></h4>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="highlighted-kategori kategori-ps-4 d-flex justify-content-center
                        align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?keyword=ps4">game playstation 4</a></h4></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="highlighted-kategori kategori-ps-5 d-flex justify-content-center
                        align-items-center">
                        <h4 class="text-white"><a class="no-decoration" href="produk.php?kategori=Games%20PS%205">game playstation 5</a></h4></div>
                    </div>
                </div>
            </div>
       </div>

       <!-- tentang kami -->
        <div class="container-fluid warna3 py-5">
            <div class="container text-center text-white">
                <h3>Tentang Kami</h3>
                <p class="fs-5 mt-3">
                    Kami Rajagame selalu ingin memberikan yang terbaik
                        Kami hadir untuk para Gamer di Indonesia
                </p>
            </div>
        </div>

        <!-- produk -->
         <div class="container-fluid backround1 py-5">
            <div class="container text-center text-white">
                <h3>Produk</h3>

                <div class="row mt-5">
                <?php while($data = mysqli_fetch_array($queryProduk)){ ?>
                <div class="col-sm-6 col-md-4 mb-4">
                    <div class="card h-100">
                       <div class="image-box">
                       <img src="img/<?php echo $data['foto']; ?>" class="card-img-top" alt="...">
                       </div>
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $data['nama']; ?></h4>
                            <p class="card-text text-truncate"><?php echo $data['detail']; ?></p>
                            <p class="card-text text-harga">Rp <?php echo $data['harga']; ?></p>
                            <a href="produk-detail.php?nama=<?php echo $data['nama'];?>" class="btn warna5 text-white">Lihat Detail</a>
                        </div>
                        </div>
                    </div>
                <?php } ?>
                    
                </div>
                <a class="btn btn-outline-warning mt-3 p-2 fs-4" href="produk.php">See More</a>
            </div>
         </div>

         <!-- foother -->
          <?php require "foother.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>