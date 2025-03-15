@extends('guest.layouts.app')

@section('title', "Home")

@section('content')
@if(isset($nomor_meja))
    <div class="bg-blue-100 p-4 rounded-lg shadow-md text-center">
        <h2 class="text-lg font-semibold">Nomor Meja: {{ $nomor_meja }}</h2>
    </div>
@endif

<!-- Search Bar -->
<div class="container text-center mt-3">
    <input type="text" id="searchBar" class="form-control" placeholder="Cari menu..." onkeyup="searchMenu()">
</div>

<!-- Filter Kategori -->
<div class="container mb-4 text-center">
    <div class="d-flex flex-wrap justify-content-center">
        <button class="btn btn-outline-primary m-2 filter-btn active" data-filter="all">Semua</button>
        @foreach($kategori as $kat)
            <button class="btn btn-outline-primary m-2 filter-btn" data-filter="kategori-{{ $kat->id }}">
                @if($kat->logo)
                    <img src="{{ asset('storage/' . $kat->logo) }}" class="rounded-circle" width="50" height="50" alt="{{ $kat->nama_kategori }}">
                @endif
                {{ $kat->nama_kategori }}
            </button>
        @endforeach
    </div>
</div>

<!-- Daftar Menu -->
<div class="container">
    <h2 class="text-center mb-4">Daftar Menu</h2>
    <div class="row" id="menuList">
        @foreach($menus as $menu)
        <div class="col-md-4 mb-4 menu-item kategori-{{ $menu->kategori->id ?? 'none' }}">
            <div class="card">
                <a href="#" data-bs-toggle="modal" data-bs-target="#menuModal{{ $menu->id }}">
                    @if($menu->gambar)
                        <img src="{{ asset('storage/' . $menu->gambar) }}" class="card-img-top" alt="{{ $menu->nama_makanan }}">
                    @else
                        <img src="{{ asset('images/default-menu.jpg') }}" class="card-img-top" alt="Default Image">
                    @endif
                </a>
                <div class="card-body text-center">
                    <h5 class="card-title">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#menuModal{{ $menu->id }}">
                            {{ $menu->nama_makanan }}
                        </a>
                    </h5>
                    <p class="card-text">Harga: Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="menuModal{{ $menu->id }}" tabindex="-1" aria-labelledby="menuModalLabel{{ $menu->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="menuModalLabel{{ $menu->id }}">{{ $menu->nama_makanan }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        @if($menu->gambar)
                            <img src="{{ asset('storage/' . $menu->gambar) }}" class="img-fluid mb-3" alt="{{ $menu->nama_makanan }}">
                        @else
                            <img src="{{ asset('images/default-menu.jpg') }}" class="img-fluid mb-3" alt="Default Image">
                        @endif
                        <p><strong>Harga:</strong> Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                        <p><strong>Kategori:</strong> {{ $menu->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</p>
                        <p class="text-muted">{{ $menu->deskripsi }}</p>
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

<!-- Filter & Search Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterButtons = document.querySelectorAll(".filter-btn");
        const menuItems = document.querySelectorAll(".menu-item");

        filterButtons.forEach(button => {
            button.addEventListener("click", function() {
                filterButtons.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");

                let filterValue = this.getAttribute("data-filter");

                menuItems.forEach(item => {
                    if (filterValue === "all" || item.classList.contains(filterValue)) {
                        item.style.display = "block";
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        });
    });

    function searchMenu() {
        let input = document.getElementById("searchBar").value.toLowerCase();
        let menuItems = document.querySelectorAll(".menu-item");

        menuItems.forEach(item => {
            let menuName = item.querySelector(".card-title").innerText.toLowerCase();
            if (menuName.includes(input)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
