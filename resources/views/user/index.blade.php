<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Food4U</a>
        <button class="btn btn-warning position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
            🛒 Keranjang 
            <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                0
            </span>
        </button>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Menu Makanan</h2>

    <!-- Alert Notifikasi -->
    <div id="alert" class="alert alert-success d-none text-center" role="alert">
        Pesanan berhasil ditambahkan ke keranjang!
    </div>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari menu...">
    </div>

    <!-- Tombol Filter Kategori -->
    <div class="text-center mb-4">
        <button class="btn btn-primary filter-btn" data-filter="MANTUL">MANTUL</button>
        <button class="btn btn-success filter-btn" data-filter="JAJANAN">JAJANAN</button>
        <button class="btn btn-warning filter-btn" data-filter="SEGER">SEGER</button>
        <button class="btn btn-danger filter-btn" data-filter="MANIS">MANIS</button>
    </div>

    <div class="row" id="menuContainer">
        @foreach($menus as $menu)
        <div class="col-md-3 mb-4 menu-item" data-category="{{ $menu->kategori }}" data-name="{{ strtolower($menu->nama) }}">
            <div class="card">
                <img src="{{ asset('storage/' . $menu->gambar) }}" class="card-img-top img-fluid" alt="{{ $menu->nama }}" data-bs-toggle="modal" data-bs-target="#menuModal{{ $menu->id }}">
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $menu->nama }}</h5>
                    <p class="text-muted">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    <button class="btn btn-sm btn-primary add-to-cart" data-id="{{ $menu->id }}" data-name="{{ $menu->nama }}" data-price="{{ $menu->harga }}">Add to Cart</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Keranjang -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Keranjang Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="cartList" class="list-group"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <a href="{{ route('pesanan.checkout') }}" class="btn btn-success">Checkout</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function updateCartView() {
        $.get("{{ route('pesanan.get') }}", function(data) {
            let cartList = $("#cartList");
            cartList.empty();
            if (data.length === 0) {
                cartList.append("<li class='list-group-item text-center'>Keranjang kosong</li>");
            } else {
                data.forEach(item => {
                    cartList.append(`<li class='list-group-item d-flex justify-content-between'>
                        ${item.name} - Rp ${item.price}
                        <button class="btn btn-sm btn-danger remove-from-cart" data-id="${item.id}">❌</button>
                    </li>`);
                });
            }
            $("#cartCount").text(data.length);
        });
    }

    $(".add-to-cart").click(function() {
        var menuId = $(this).data("id");
        var menuName = $(this).data("name");
        var menuPrice = $(this).data("price");

        $.post("{{ route('pesanan.add') }}", {
            _token: "{{ csrf_token() }}",
            id: menuId,
            name: menuName,
            price: menuPrice
        }, function() {
            $("#alert").removeClass("d-none").fadeIn().delay(2000).fadeOut();
            updateCartView();
        });
    });

    $(document).on("click", ".remove-from-cart", function() {
        var menuId = $(this).data("id");

        $.post("{{ route('pesanan.remove') }}", {
            _token: "{{ csrf_token() }}",
            id: menuId
        }, function() {
            updateCartView();
        });
    });

    updateCartView();
});
</script>

</body>
</html>
