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
    
    const buttons = document.querySelectorAll('button[id^="btn-"]');
    const sections = document.querySelectorAll('#menu > section');
    const rekomendasi = document.getElementById('rekomendasi');
    const kategori = document.getElementById('kategori');

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetClass = btn.id.replace('btn-', '');
            const targetSection = document.querySelector(`section.${targetClass}`);

            // Cek apakah tombol sudah aktif
            const isActive = btn.classList.contains('active');

            if (isActive) {
            // Jika tombol sudah aktif, kembali ke kondisi awal (semua tombol off, semua section terlihat)
                buttons.forEach((b) => {
                    b.classList.remove('active');
                    b.style.opacity = '100%';
                });
                sections.forEach((s) => s.classList.remove('hidden'));
                rekomendasi.classList.remove('hidden');
            } else {
                // Matikan semua tombol dan tampilkan semua section
                buttons.forEach((b) => {
                    b.classList.remove('active');
                    b.style.opacity = '50%';
                });
                sections.forEach((s) => s.classList.add('hidden'));

                rekomendasi.classList.add('hidden');
                kategori.classList.add('mt-2');
                btn.classList.add('active');
                btn.style.opacity = '100%';
                targetSection.classList.remove('hidden');
            }
        });
    });

    function cartHandler() {
        return {
            open: false,
            food: {},
            addToCart(food) {
                fetch('/keranjang', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: food.id,
                        name: food.name,
                        price: food.price,
                        image: food.image
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                })
                .catch(err => {
                    console.error(err);
                });
            }
        };
    }
</script>