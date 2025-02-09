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

<div class="container mt-5">
    <h2 class="text-center mb-4">Menu Makanan</h2>

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
                    <span class="badge bg-primary">{{ $menu->kategori }}</span>
                </div>
            </div>
        </div>

        <!-- Modal Detail Menu -->
        <div class="modal fade" id="menuModal{{ $menu->id }}" tabindex="-1" aria-labelledby="menuModalLabel{{ $menu->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="menuModalLabel{{ $menu->id }}">{{ $menu->nama }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('storage/' . $menu->gambar) }}" class="img-fluid mb-3" alt="{{ $menu->nama }}" style="max-height: 300px;">
                        <p><strong>Keterangan:</strong> {{ $menu->keterangan }}</p>
                        <p><strong>Kategori:</strong> <span class="badge bg-primary">{{ $menu->kategori }}</span></p>
                        <h4 class="text-success">Rp {{ number_format($menu->harga, 0, ',', '.') }}</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
$(document).ready(function() {
    $(".filter-btn").click(function() {
        var category = $(this).data("filter");
        $(".menu-item").hide();
        $(".menu-item[data-category='" + category + "']").show();
    });

    $("#searchInput").on("keyup", function() {
        var searchText = $(this).val().toLowerCase();
        $(".menu-item").each(function() {
            var menuName = $(this).data("name");
            if (menuName.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>

</body>
</html>
