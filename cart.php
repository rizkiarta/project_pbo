<?php
require_once 'includes/functions.php';
require_once 'includes/head.php';

// Ambil data
$items = getCartItems();
$subtotal = getCartTotal();
$shipping = getShippingFee();
$grand_total = getGrandTotal();
?>

<body>
    <div class="container-fluid page-header py-5">
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
                            <th scope="col">Produk</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total</th>
                            <th scope="col">Hapus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="img/<?php echo $item['image']; ?>" class="img-fluid rounded-circle" style="width: 80px; height: 80px;" alt="">
                                </div>
                            </td>
                            
                            <td>
                                <p class="mb-0 mt-4"><?php echo $item['name']; ?></p>
                            </td>
                            
                            <td>
                                <p class="mb-0 mt-4">Rp <?php echo number_format($item['price']); ?></p>
                            </td>
                            
                            <td>
                                <div class="input-group quantity mt-4" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <a href="update_quantity.php?id=<?php echo $item['product_id']; ?>&action=decrease" class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0" value="<?php echo $item['quantity']; ?>" readonly>
                                    <div class="input-group-btn">
                                        <a href="update_quantity.php?id=<?php echo $item['product_id']; ?>&action=increase" class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            
                            <td>
                                <p class="mb-0 mt-4">Rp <?php echo number_format($item['subtotal']); ?></p>
                            </td>
                            
                            <td>
                                <a href="update_quantity.php?id=<?php echo $item['product_id']; ?>&action=delete" class="btn btn-md rounded-circle bg-light border mt-4" onclick="return confirm('Hapus barang ini?')">
                                    <i class="fa fa-times text-danger"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded p-4">
                            <h1 class="display-6 mb-4">Total</h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <p class="mb-0">Rp <?php echo number_format($subtotal); ?></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Ongkir:</h5>
                                <p class="mb-0">Rp <?php echo number_format($shipping); ?></p>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Grand Total</h5>
                                <p class="mb-0 pe-4">Rp <?php echo number_format($grand_total); ?></p>
                            </div>
                            <a href="checkout.php" class="btn btn-primary rounded-pill px-4 py-3 w-100">Checkout</a>
                        </div>
                    </div>
                </div>

                <?php endif; ?>
            </div>
        </div>
    </div>

<?php require_once 'includes/footer.php'; ?>