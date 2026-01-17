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



    // Product Quantity (Untuk halaman detail product manual)
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


// ==========================================
// FITUR TAMBAHAN (Di luar wrapper jQuery)
// ==========================================

// Fungsi Update Quantity Cart (Untuk fitur cart modern/sidebar)
function updateQuantity(productId, change, button) {
    const row = button.closest('tr');
    if (!row) return;

    const quantityDisplay = row.querySelector('.quantity-display');
    const subtotalDisplay = row.querySelector('.subtotal-display');
    
    // Ambil elemen Sidebar berdasarkan ID
    const sidebarSubtotalDisplay = document.getElementById('sidebar-subtotal');
    const sidebarGrandTotalDisplay = document.getElementById('sidebar-grand-total');

    // Cek apakah elemen ada (jika tidak ada, abaikan update sidebar)
    const hasSidebar = sidebarSubtotalDisplay && sidebarGrandTotalDisplay;

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
                
                if (remainingRows > 0 && hasSidebar) {
                    // Update total sidebar saja karena baris dihapus
                    sidebarSubtotalDisplay.innerHTML = data.sidebar_subtotal;
                    sidebarGrandTotalDisplay.innerHTML = data.grand_total;
                } else {
                    // Kalau keranjang kosong atau tidak ada sidebar, reload
                    location.reload(); 
                }
            } else {
                // Update baris item
                quantityDisplay.value = data.quantity;
                subtotalDisplay.innerHTML = data.subtotal;
                
                // Update Sidebar jika ada
                if (hasSidebar) {
                    sidebarSubtotalDisplay.innerHTML = data.sidebar_subtotal;
                    sidebarGrandTotalDisplay.innerHTML = data.grand_total;
                }
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

// ==========================================
// FITUR AJAX ADD TO CART (NO RELOAD)
// ==========================================
document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault(); // Mencegah reload form standar
        
        const form = this.closest('form');
        if (!form) return;

        const formData = new FormData(form);
        const currentScroll = window.pageYOffset; 

        // Ubah tombol jadi loading
        const originalContent = this.innerHTML;
        this.disabled = true;
        this.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Menambah...';

        fetch('add_to_cart.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 1. Update Badge di Navbar
                const badge = document.querySelector('.cart-count');
                if (badge) {
                    badge.textContent = data.cart_count;
                    
                    // Efek animasi "pop" kecil pada badge
                    badge.style.transform = "scale(1.5)";
                    setTimeout(() => badge.style.transform = "scale(1)", 200);
                }
                
                // 2. Ubah tombol jadi tanda sukses
                this.innerHTML = '<i class="fa fa-check me-2 text-success"></i> Masuk Keranjang';
                this.classList.remove('border-secondary'); // Opsional: ganti style tombol
                this.classList.add('border-success');
                
                // 3. Reset tombol setelah 1 detik
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.classList.remove('border-success');
                    this.classList.add('border-secondary');
                    this.disabled = false;
                }, 1000);

            } else {
                // Jika gagal (misal belum login)
                // Kita redirect ke login karena di add_to_cart.php sudah kita set redirect login
                // Tapi untuk UX lebih baik, kita reload halaman agar redirect PHP jalan
                window.location.href = window.location.href;
            }
        })
        .catch(err => {
            console.error(err);
            // Jika error koneksi, reload halaman agar fallback PHP jalan
            window.location.href = window.location.href;
        });
    });
});