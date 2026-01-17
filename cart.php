<?php
require_once 'includes/config.php';
require_once 'includes/head.php';
require_once 'includes/spinner.php';
$current_page = 'shop';
require_once 'includes/navbar.php';
?>

<body>

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5 mb-5">
        <div class="container py-5">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Cart</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Single Page Header End -->


    <!-- Cart Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cart_items = getCartItems(); // Dari functions.php
                        $cart_total = getCartTotal();
                        $shipping = getShippingFee();
                        $grand_total = getGrandTotal();

                        if (empty($cart_items)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <h5>Keranjang belanja kosong</h5>
                                    <a href="index.php" class="btn border-secondary rounded-pill px-4 py-3 text-primary mt-3">
                                        Mulai Belanja
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <th scope="row">
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo htmlspecialchars($item['image']); ?>"
                                                class="img-fluid me-5 rounded-circle"
                                                style="width: 80px; height: 80px;"
                                                alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 mt-4 fw-bold"><?php echo htmlspecialchars($item['name']); ?></p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4">Rp <?php echo number_format($item['price']); ?></p>
                                    </td>
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border"
                                                    onclick="updateQuantity(<?php echo $item['id']; ?>, -1, this)">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control form-control-sm text-center border-0 quantity-display"
                                                value="<?php echo $item['quantity']; ?>" readonly>
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border"
                                                    onclick="updateQuantity(<?php echo $item['id']; ?>, 1, this)">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Subtotal cell -->
                                    <td class="mb-0 mt-4 fw-bold subtotal-display">
                                        Rp <?php echo number_format($item['subtotal']); ?>
                                    </td>
                                    <td>
                                        <a href="remove_from_cart.php?id=<?php echo $item['id']; ?>"
                                            class="btn btn-md rounded-circle bg-light border mt-4">
                                            <i class="fa fa-times text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="row g-4 justify-content-end">
                <div class="col-8"></div>
                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                    <div class="bg-light rounded">
                        <div class="p-4">
                            <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                            <div class="d-flex justify-content-between mb-4">
                                <h5 class="mb-0 me-4">Subtotal:</h5>
                                <!-- Hapus class cart-total-display, ganti dengan id khusus -->
                                <p class="mb-0" id="sidebar-subtotal">Rp <?php echo number_format($cart_total); ?></p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Shipping</h5>
                                <div>
                                    <p class="mb-0">Flat rate: Rp <?php echo number_format($shipping); ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0 me-4">Total:</h5>
                                <!-- Hapus class cart-total-display, ganti dengan id khusus -->
                                <p class="mb-0 fw-bold" id="sidebar-grand-total">Rp <?php echo number_format($grand_total); ?></p>
                            </div>
                        </div>
                        <div class="py-4 text-center">
                            <a href="checkout.php" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase w-100">
                                Proceed Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart Page End -->

    <?php
    require_once 'includes/footer.php';
    ?>