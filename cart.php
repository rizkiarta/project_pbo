<?php
require_once 'includes/functions.php';
require_once 'includes/head.php';
// Cek navbar/header
if (file_exists('includes/navbar.php')) require_once 'includes/navbar.php';

$items = getCartItems();
?>

<body>
    <div class="container-fluid page-header py-5 mb-5">
        <h1 class="text-center text-white display-6">Keranjang Belanja</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active text-white">Cart</li>
        </ol>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <?php if (empty($items)): ?>
                    <div class="text-center py-5">
                        <h3>Keranjang Kosong</h3>
                        <a href="index.php" class="btn btn-primary rounded-pill py-3 px-5 mt-3">Belanja Dulu</a>
                    </div>
                <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <img src="img/<?php echo $item['image']; ?>" class="img-fluid rounded-circle" style="width: 80px; height: 80px;" alt="">
                            </td>
                            <td><p class="mb-0 mt-4"><?php echo $item['name']; ?></p></td>
                            <td><p class="mb-0 mt-4">Rp <?php echo number_format($item['price']); ?></p></td>
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <a href="update_quantity.php?id=<?php echo $item['product_id']; ?>&action=decrease" class="btn btn-sm btn-minus rounded-circle bg-light border"><i class="fa fa-minus"></i></a>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0" value="<?php echo $item['quantity']; ?>" readonly>
                                    <div class="input-group-btn">
                                        <a href="update_quantity.php?id=<?php echo $item['product_id']; ?>&action=increase" class="btn btn-sm btn-plus rounded-circle bg-light border"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td><p class="mb-0 mt-4">Rp <?php echo number_format($item['subtotal']); ?></p></td>
                            <td>
                                <a href="update_quantity.php?id=<?php echo $item['product_id']; ?>&action=delete" class="btn btn-md rounded-circle bg-light border mt-4" onclick="return confirm('Hapus?')"><i class="fa fa-times text-danger"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row justify-content-end">
                    <div class="col-lg-4">
                        <div class="bg-light rounded p-4">
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0">Total:</h5>
                                <p class="mb-0">Rp <?php echo number_format(getCartTotal()); ?></p>
                            </div>
                            <a href="checkout.php" class="btn btn-primary rounded-pill w-100">Checkout</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php require_once 'includes/footer.php'; ?>