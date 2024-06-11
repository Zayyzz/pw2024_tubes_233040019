<?php
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);

if ($stmt = $con->prepare("SELECT * FROM produk WHERE nama=?")) {
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $result = $stmt->get_result();
    $produk = $result->fetch_assoc();
    $stmt->close();
}

if ($produk) {
    if ($stmtTerkait = $con->prepare("SELECT * FROM produk WHERE kategori_id=? AND id!=? LIMIT 4")) {
        $stmtTerkait->bind_param("ii", $produk['kategori_id'], $produk['id']);
        $stmtTerkait->execute();
        $resultTerkait = $stmtTerkait->get_result();
    }
} else {
    // Handle case where product does not exist, e.g., redirect to an error page
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online || Detail Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mb-4">
                    <img src="img/<?php echo htmlspecialchars($produk['foto']); ?>" class="w-100" alt="">
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <h1><?php echo htmlspecialchars($produk['nama']); ?></h1>
                    <p class="fs-6"><?php echo htmlspecialchars($produk['detail']); ?></p>
                    <p class="text-harga">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                    <p class="fs-5">Status Ketersediaan : <strong><?php echo htmlspecialchars($produk['ketersediaan_stok']); ?></strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- produk terkait -->
    <div class="container-fluid py-5 warna1">
        <div class="container">
            <h2 class="text-center text-white mb-5">Produk Terkait</h2>

            <div class="row">
                <?php while ($data = $resultTerkait->fetch_assoc()) { ?>
                <div class="col-md-6 col-lg-3 mb-3">
                    <a href="produk-detail.php?nama=<?php echo htmlspecialchars($data['nama']); ?>">
                        <img src="img/<?php echo htmlspecialchars($data['foto']); ?>" class="img-fluid img-thumbnail" alt="">
                    </a>
                </div>
                <?php } ?>
                <?php $stmtTerkait->close(); ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php require "foother.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
