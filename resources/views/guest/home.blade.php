@extends('guest.layouts.app')

@section('title', "Home")

@section('content')
@if(isset($nomor_meja))
    <div class="bg-blue-100 p-4 rounded-lg shadow-md text-center">
        <h2 class="text-lg font-semibold">Nomor Meja: {{ $nomor_meja }}</h2>
    </div>
@endif

<!-- Atas -->
<section class="max-w-lg mx-auto bg-nf-primary rounded-full flex items-center">
    <div class="flex items-center bg-white rounded-full p-1 mr-4 shadow-md w-full max-w-lg">
        <input type="text" placeholder="Search Food Here" 
            class="flex-grow text-xs text-gray-700 bg-white border-none rounded-full px-4 py-2 focus:ring-2 focus:outline-none">
        <button class="p-2 rounded-full transition">
            <svg class="w-5 h-5 text-nf-primary cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z"/>
            </svg>
        </button>
    </div>
    <button>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M17 18C15.89 18 15 18.89 15 20C15 20.5304 15.2107 21.0391 15.5858 21.4142C15.9609 21.7893 16.4696 
            22 17 22C17.5304 22 18.0391 21.7893 18.4142 21.4142C18.7893 21.0391 19 20.5304 19 20C19 19.4696 18.7893 
            18.9609 18.4142 18.5858C18.0391 18.2107 17.5304 18 17 18ZM1 2V4H3L6.6 11.59L5.24 14.04C5.09 14.32 5 14.65 
            5 15C5 15.5304 5.21071 16.0391 5.58579 16.4142C5.96086 16.7893 6.46957 17 7 17H19V15H7.42C7.3537 15 7.29011 
            14.9737 7.24322 14.9268C7.19634 14.8799 7.17 14.8163 7.17 14.75C7.17 14.7 7.18 14.66 7.2 14.63L8.1 
            13H15.55C16.3 13 16.96 12.58 17.3 11.97L20.88 5.5C20.95 5.34 21 5.17 21 5C21 4.73478 20.8946 4.48043 
            20.7071 4.29289C20.5196 4.10536 20.2652 4 20 4H5.21L4.27 2M7 18C5.89 18 5 18.89 5 20C5 20.5304 5.21071 
            21.0391 5.58579 21.4142C5.96086 21.7893 6.46957 22 7 22C7.53043 22 8.03914 21.7893 8.41421 21.4142C8.78929 
            21.0391 9 20.5304 9 20C9 19.4696 8.78929 18.9609 8.41421 18.5858C8.03914 18.2107 7.53043 18 7 18Z" 
            fill="#F8F8F8"/>
        </svg>
    </button>
</section>

<!-- Filter Kategori -->
{{-- <div class="container mb-4 text-center">
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
</div> --}}

<!-- Daftar Menu -->
{{-- <div class="container">
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
</div> --}}

{{-- Rekomendasi --}}
<section id="rekomendasi" class="pt-5">
    <h2 class="text-base font-bold text-slate-50 pb-1">Rekomendasi Saya</h2>
    <div class="w-full overflow-x-auto whitespace-nowrap py-2 text-slate-50">
        <div class="flex gap-4">
            <div class="w-60 rounded-xl flex flex-col items-center">
                <img src="/assets/img/nasi-goreng.png" alt="Makanan" class="w-max h-24 object-cover rounded-lg">
                <h2 class="h2 font-bold mt-2 text-center">Nasi Goreng</h2>
                <p class="h3 pb-1">Rp 25.000</p>
                <button class="h3 mt-1 px-3 py-1 bg-nf-sixth rounded-full hover:bg-opacity-80 transition">Add to Cart</button>
            </div>
        
            <div class="w-60 rounded-xl flex flex-col items-center">
                <img src="/assets/img/nasi-bakar.png" alt="Makanan" class="w-max h-24 object-cover rounded-lg">
                <h2 class="h2 font-bold mt-2 text-center">Nasi Bakar</h2>
                <p class="h3 pb-1">Rp 30.000</p>
                <button class="h3 mt-1 px-3 py-1 bg-nf-sixth rounded-full hover:bg-opacity-80 transition">Add to Cart</button>
            </div>
        </div>
    </div>
</section>

{{-- Kategori --}}
<div id="kategori" class="flex gap-2 justify-center py-2">
    <button id="btn-makanan" class="w-20 h-11 bg-nf-third hover:bg-orange-600 rounded-xl flex items-center justify-center">
        <img src="/assets/img/icon/makanan.svg" alt="Makanan" class="w-6 h-5">
    </button>
    <button id="btn-minuman" class="w-20 h-11 bg-nf-fourth hover:bg-yellow-600 rounded-xl flex items-center justify-center">
        <img src="/assets/img/icon/minuman.svg" alt="Minuman" class="w-6 h-5">
    </button>
    <button id="btn-desert" class="w-20 h-11 bg-nf-third hover:bg-orange-600 rounded-xl flex items-center justify-center">
        <img src="/assets/img/icon/desert.svg" alt="Dessert" class="w-6 h-5">
    </button>
    <button id="btn-snack" class="w-20 h-11 bg-nf-fourth hover:bg-yellow-600 rounded-xl flex items-center justify-center">
        <img src="/assets/img/icon/snack.svg" alt="Snack" class="w-6 h-5">
    </button>
</div>

<section id="menu" class="max-w-md h-auto py-2">
    <section class="makanan flex flex-col pb-4 gap-4 w-full max-w-md h-auto rounded-lg overflow-hidden">
        <h2 class="text-base font-bold text-slate-50">Makanan</h2>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/nasi-goreng.png" alt="Nasi Goreng" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Nasi Goreng</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 35.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-nf-fiveth rounded-full hover:bg-yellow-700 transition">
                    Add to Cart
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/mie-goreng.png" alt="Mie Goreng Jawa" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Mie Goreng Jawa</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 25.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-nf-fiveth rounded-full hover:bg-yellow-700 transition">
                    Add to Cart
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/katsu.png" alt="Chicken Katsu" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Ayam Katsu</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 30.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-nf-fiveth rounded-full hover:bg-yellow-700 transition">
                    Add to Cart
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/cumi-tepung.png" alt="Cumi Goreng" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Cumi Goreng</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 45.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-nf-fiveth rounded-full hover:bg-yellow-700 transition">
                    Add to Cart
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/nasi.png" alt="Nasi" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Nasi</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 8.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-nf-fiveth rounded-full hover:bg-yellow-700 transition">
                    Add to Cart
                </button>
            </div>
        </div>
    </section>
    <section class="minuman flex flex-col gap-4 w-full max-w-md h-auto rounded-lg overflow-hidden">
        <h2 class="text-base font-bold text-slate-50">Minuman</h2>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/teh.jpg" alt="Es Teh" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Es Teh</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 15.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-green-800 rounded-full hover:bg-green-900 transition">
                    Add to Cart
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/dalgona.jpg" alt="Kopi Dalgona" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Kopi Dalgona</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 26.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-green-800 rounded-full hover:bg-green-900 transition">
                    Add to Cart
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/thai-tea.jpg" alt="Thai Tea" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Thai Tea</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 24.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-green-800 rounded-full hover:bg-green-900 transition">
                    Add to Cart
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/matcha.jpg" alt="Matcha Latte" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Matcha Latte</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 24.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-green-800 rounded-full hover:bg-green-900 transition">
                    Add to Cart
                </button>
            </div>
        </div>
        <div class="grid grid-cols-4">
            <div class="col-span-2">
                <img src="/assets/img/smoties.jpg" alt="Alpukat Smoothie" class="w-32 h-20 object-cover rounded-lg">
            </div>
            <div class="col-span-2 flex flex-col justify-center items-start p-1">
                <h2 class="text-sm font-bold text-slate-50">Alpukat Smoothie</h2>
                <p class="text-xs font-semibold mt-1 ml-2 text-slate-50">Rp 34.000</p>
                <button class="mt-2 px-3 py-1 text-xs font-semibold text-slate-50 bg-green-800 rounded-full hover:bg-green-900 transition">
                    Add to Cart
                </button>
            </div>
        </div>
    </section>
</section>

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
