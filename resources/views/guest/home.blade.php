@extends('guest.layouts.app')

@section('title', "| Home")

@section('content')

@if(session('nomor_hp'))
    <div class="hidden text-sm text-gray-600 text-center">
        Nomor HP: {{ session('nomor_hp') }}
    </div>
@endif

<style>
    .cart-icon {
      position: relative;
      display: inline-block;
      font-size: 24px;
    }

    .cart-count {
      position: absolute;
      top: -10px;
      right: -10px;
      background: red;
      color: white;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 12px;
    }
  </style>

<script src="https://unpkg.com/alpinejs" defer></script>

<!-- Atas -->
<div class="py-6 px-5" x-data="cartHandler()" x-init="init()">
    <a href="/keranjang" class="fixed p-3 bg-yellow-500 rounded-xl shadow-lg z-50 bottom-0 mb-10 hover:bg-yellow-700 transition-colors duration-200" style="margin-left:275px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none">
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
    </a>
    {{-- logout --}}
    <a class="flex overflow-x-auto items-center text-xs text-slate-50" href="{{ route('guest.logout') }}">
        <img src="/assets/img/ic-logout.png" alt="Makanan" class="w-8 h-auto">
        Logout
    </a>
    <section class="max-w-lg mx-auto py-2 bg-nf-primary rounded-full flex items-center">
        <form action="{{ route('search') }}" method="GET" class="flex items-center bg-white rounded-full p-1 mr-4 shadow-md w-full max-w-lg">
            <input type="text" name="query" placeholder="Search Food Here" 
                class="flex-grow text-xs text-gray-700 bg-white border-none rounded-full px-4 py-2 focus:ring-2 focus:outline-none">
            <button type="submit" class="p-2 rounded-full transition">
                <svg class="w-5 h-5 text-nf-primary cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z"/>
                </svg>
            </button>
        </form>
        <a href="/detail-pesanan">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"><path fill="#fff" d="M12 21q-3.45 0-6.012-2.287T3.05 13H5.1q.35 2.6 2.313 4.3T12 19q2.925 0 4.963-2.037T19 12t-2.037-4.962T12 5q-1.725 0-3.225.8T6.25 8H9v2H3V4h2v2.35q1.275-1.6 3.113-2.475T12 3q1.875 0 3.513.713t2.85 1.924t1.925 2.85T21 12t-.712 3.513t-1.925 2.85t-2.85 1.925T12 21m2.8-4.8L11 12.4V7h2v4.6l3.2 3.2z"/></svg>
        </a>
    </section>

    {{-- Rekomendasi --}}
    <section id="rekomendasi" class="pt-2" >
    <h2 class="text-base font-bold text-slate-50 pb-1">Rekomendasi Saya</h2>
    <div class="w-full overflow-x-auto whitespace-nowrap scroll-hidden py-2 text-slate-50">
        <div class="flex gap-4">
            @forelse ($rekomendasi as $menu)
                <div id="suggest" class="w-40 flex-shrink-0 rounded-xl flex flex-col items-center">
                    <div class="w-auto h-28">
                        <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_makanan }}" class="w-40 h-full object-cover rounded-lg">
                    </div>
                    <h2 class="h2 font-bold mt-2 text-center">{{ $menu->nama_makanan }}</h2>
                    <p class="h3 pb-1">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    <button 
                        class="h3 mt-1 px-3 py-1 bg-nf-sixth rounded-full hover:bg-opacity-80 transition"
                        @click="addToCart({
                            id: {{ $menu->id }},
                            name: '{{ $menu->nama_makanan }}',
                            price: {{ $menu->harga }},
                            image: '{{ asset('storage/' . $menu->gambar) }}'
                        })"
                    >
                        Add to Cart
                    </button>
                </div>
            @empty
                <p class="text-slate-300">Belum ada rekomendasi tersedia.</p>
            @endforelse
        </div>
    </div>
    </section>



    {{-- Kategori --}}
    <div id="kategori" class="flex gap-2 justify-center py-2">
        @foreach($kategori as $kat)
            @php
                $isGenap = $loop->iteration % 2 == 0;
                $bgClass = $isGenap ? 'bg-nf-fourth hover:bg-yellow-600' : 'bg-nf-third hover:bg-orange-600';
            @endphp

            <button id="btn-{{ $kat->nama_kategori }}" class="w-20 h-11 {{ $bgClass }} rounded-xl flex items-center justify-center" data-filter="kategori-{{ $kat->id }}">
                @if($kat->logo)
                    <img src="{{ asset('storage/' . $kat->logo) }}" class="w-8 h-8" alt="{{ $kat->nama_kategori }}">
                @endif
            </button>
        @endforeach
    </div>

    {{-- Menu --}}
    <section id="menu" class="mx-auto py-2">
        @foreach ($groupedMenus as $kategori => $menus)
            @php
                $isGenap = $loop->iteration % 2 == 0;
                $bgClass = $isGenap ? 'bg-green-800 rounded-full hover:bg-green-900' : 'bg-nf-fiveth rounded-full hover:bg-yellow-700';
            @endphp 
            <section class="{{ $kategori }} flex flex-col w-full max-w-md h-auto overflow-hidden">
                <h2 id="title" class="title text-base font-bold text-slate-50 mb-4">{{ $kategori }}</h2>
                {{-- <div class="grid grid-cols-4 gap-4"> --}}
                    @foreach ($menus as $menu)
                        <div class="cursor-pointer grid grid-cols-4 pb-4 overflow-hidden"
                            @click="food = {
                                id: {{ $menu->id }},
                                image: '{{ asset('storage/' . $menu->gambar) }}',
                                name: '{{ $menu->nama_makanan }}',
                                price: {{ $menu->harga }},
                                description: '{{ $menu->deskripsi }}',
                                category: '{{ $menu->kategori->nama_kategori ?? 'Tidak ada' }}'
                            }; open = true">
                            <div class="col-span-2">
                                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_makanan }}" class="w-36 h-24 object-cover rounded-lg">
                            </div>
                            <div class="col-span-2 flex flex-col justify-center items-start">
                                <h2 class="text-sm font-semibold text-slate-100">{{ $menu->nama_makanan }}</h2>
                                <p class="text-xs text-slate-200 mt-1 ml-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                <div class="pt-0">
                                    <button @click.stop="addToCart({
                                        id: {{ $menu->id }},
                                        name: '{{ $menu->nama_makanan }}',
                                        price: {{ $menu->harga }},
                                        image: '{{ asset('storage/' . $menu->gambar) }}'
                                    })" class="mt-3 px-3 py-1 text-xs font-semibold text-slate-50 {{ $bgClass }} transition">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                {{-- </div> --}}
            </section>
        @endforeach

        <!-- Modal -->
        <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
            <div class="bg-white rounded-lg max-w-sm w-full p-4 relative">
                <button class="absolute top-2 right-2 text-gray-500 hover:text-red-500" @click="open = false">✕</button>
                <img :src="food.image" alt="" class="w-full h-40 object-cover rounded-md mb-4">
                <h2 class="text-xl font-bold mb-1" x-text="food.name"></h2>
                {{-- <p class="text-sm text-gray-500 mb-1" x-text="food.category"></p> --}}
                <p class="text-sm text-gray-500 mb-1" x-text="'Rp ' + parseInt(food.price).toLocaleString('id-ID')"></p>
                <p class="text-gray-700 mt-2 text-sm" x-text="food.description"></p>

                <div class="py-4">
                    <button @click="addToCart(food)"
                        class="px-3 py-1 text-xs font-semibold text-slate-50 bg-nf-fiveth rounded-full hover:bg-yellow-700 transition">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </section>
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
    function cartHandler() {
        return {
            open: false,
            food: {},
            cart: JSON.parse(localStorage.getItem('cart')) || [],
            count: 0,
            show: false,
            message: '',
            init() {
                this.cart = JSON.parse(localStorage.getItem('cart')) || [];
                this.updateCount();
            }
            updateCount() {
                this.count = this.cart.reduce((acc, item) => acc + item.qty, 0);
            },
            addToCart(item) {
                let existing = this.cart.find(i => i.id === item.id);
                if (existing) {
                    existing.qty += 1;
                } else {
                    item.qty = 1;
                    this.cart.push(item);
                }
                localStorage.setItem('cart', JSON.stringify(this.cart));

                this.updateCount();  // update count setiap addToCart

                this.message = `${item.name} ditambahkan ke keranjang!`;
                this.show = true;
            }
        }
    }
</script>
<script>
    // Ambil cart dari localStorage
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Tampilkan jumlah item
    const cartCount = document.getElementById("cartCount");
    cartCount.textContent = cart.length;

    // Opsional: sembunyikan angka kalau kosong
    if (cart.length === 0) {
      cartCount.style.display = "none";
    } else {
      cartCount.style.display = "inline";
    }
  </script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
