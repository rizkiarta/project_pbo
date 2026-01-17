(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner(0);


    // Fixed Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.fixed-top').addClass('shadow');
        } else {
            $('.fixed-top').removeClass('shadow');
        }
    });


    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({ scrollTop: 0 }, 1500, 'easeInOutExpo');
        return false;
    });


    // Testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 2000,
        center: false,
        dots: true,
        loop: false,
        margin: 25,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: { items: 1 },
            576: { items: 1 },
            768: { items: 1 },
            992: { items: 2 },
            1200: { items: 2 }
        }
    });


    // vegetable carousel
    $(".vegetable-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        center: false,
        dots: true,
        loop: true,
        margin: 25,
        nav: true,
        navText: [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsiveClass: true,
        responsive: {
            0: { items: 1 },
            576: { items: 1 },
            768: { items: 2 },
            992: { items: 3 },
            1200: { items: 4 }
        }
    });


    // Modal Video
    $(document).ready(function () {
        var $videoSrc;
        $('.btn-play').click(function () {
            $videoSrc = $(this).data("src");
        });
        console.log($videoSrc);

        $('#videoModal').on('shown.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
        })

        $('#videoModal').on('hide.bs.modal', function (e) {
            $("#video").attr('src', $videoSrc);
        })
    });



    // Product Quantity (Untuk halaman detail product biasanya)
    $('.quantity button').on('click', function () {
        var button = $(this);
        var oldValue = button.parent().parent().find('input').val();
        if (button.hasClass('btn-plus')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        button.parent().parent().find('input').val(newVal);
    });

})(jQuery);


// Fungsi Update Quantity Cart
function updateQuantity(productId, change, button) {
    const row = button.closest('tr');
    if (!row) return;

    const quantityDisplay = row.querySelector('.quantity-display');
    const subtotalDisplay = row.querySelector('.subtotal-display');
    
    // Ambil elemen Sidebar berdasarkan ID
    const sidebarSubtotalDisplay = document.getElementById('sidebar-subtotal');
    const sidebarGrandTotalDisplay = document.getElementById('sidebar-grand-total');

    // Cek apakah elemen ada
    if (!quantityDisplay || !subtotalDisplay || !sidebarSubtotalDisplay || !sidebarGrandTotalDisplay) {
        console.error('Elemen tidak ditemukan!');
        return;
    }

    fetch('update_quantity.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'product_id=' + productId + '&change=' + change
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.remove || data.quantity <= 0) {
                    row.remove(); // Hapus baris kalau quantity 0
                    
                    // Cek apakah masih ada sisa barang di tabel
                    const remainingRows = document.querySelectorAll('tbody tr').length;
                    
                    if (remainingRows > 0) {
                        // Update total sidebar saja karena baris dihapus
                        sidebarSubtotalDisplay.innerHTML = data.sidebar_subtotal;
                        sidebarGrandTotalDisplay.innerHTML = data.grand_total;
                    } else {
                        // Kalau keranjang kosong, reload
                        location.reload(); 
                    }
                } else {
                    // Update baris item
                    quantityDisplay.value = data.quantity;
                    subtotalDisplay.innerHTML = data.subtotal;
                    
                    // Update Sidebar
                    sidebarSubtotalDisplay.innerHTML = data.sidebar_subtotal;
                    sidebarGrandTotalDisplay.innerHTML = data.grand_total;
                }

                // Update badge keranjang di navbar
                const badge = document.querySelector('.cart-count');
                if (badge) badge.textContent = data.cart_count;
            } else {
                alert(data.message || 'Gagal update keranjang');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Koneksi error, coba lagi');
        });
}

// Fitur Add to Cart tanpa reload
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const currentScroll = window.pageYOffset; 

        this.disabled = true;
        this.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Adding...';

        fetch('add_to_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'product_id=' + productId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const badge = document.querySelector('.cart-count');
                if (badge) {
                    badge.textContent = data.cart_count;
                }
                alert(data.message); 
                this.innerHTML = '<i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart';
            } else {
                alert(data.message || 'Gagal menambahkan ke keranjang');
                this.innerHTML = '<i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart';
            }
            this.disabled = false;
            window.scrollTo(0, currentScroll);
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan koneksi');
            this.innerHTML = '<i class="fa fa-shopping-bag me-2 text-primary"></i> Add to Cart';
            this.disabled = false;
            window.scrollTo(0, currentScroll);
        });
    });
});