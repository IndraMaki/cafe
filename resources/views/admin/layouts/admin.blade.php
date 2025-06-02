<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food4U</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="/assets/img/pure-logo.png" sizes="190x104">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="flex min-h-screen bg-[#f0e8e8]">

    <!-- Sidebar -->
    <aside class="w-72 bg-[#660018] fixed h-full text-white flex flex-col py-6 px-4">
      
      <!-- Logo -->
      <div class="flex items-center gap-3 mb-12 px-2">
        <img src="/assets/img/logo-dashboard.png" alt="Logo" class="w-40 h-auto">
      </div>
  
      <!-- Menu Items -->
      <nav class="flex flex-col gap-2 w-auto text-sm font-medium ">
  
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg 
            {{-- ini lu sesuaiin sama root hrefnya nanti --}}
            {{ Route::is('admin.dashboard') ? 'bg-[#F8B602] font-semibold':'hover:bg-[#4a0011] transition'}}">
          <img src="/assets/img/ic-dashboard.png" alt="Dashboard" class="w-6 h-6">
          Dashboard
        </a>
  
        <a href="{{ route('admin.viewkategori') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg 
            {{ Route::is('admin.viewkategori') ? 'bg-[#F8B602] font-semibold':'hover:bg-[#4a0011] transition'}}">
          <img src="/assets/img/ic-kategori.png" alt="Kategori" class="w-6 h-6">
          Kategori
        </a>
  
        <!-- <a href="{{ route('admin.meja.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg 
            {{ Route::is('admin.meja.index') ? 'bg-[#F8B602] font-semibold' :'hover:bg-[#4a0011] transition'}}">
          <img src="/assets/img/ic-meja.png" alt="Meja" class="w-6 h-6">
          Meja
        </a> -->
  
        <a href="{{ route('admin.menu.index') }}" class="flex items-center gap-3 px-4 py-3 transition rounded-lg 
            {{ Route::is('admin.menu.index') ? 'bg-[#F8B602] font-semibold' :'hover:bg-[#4a0011] transition'}}">
            <img src="/assets/img/ic-menu.png" alt="Menu" class="w-6 h-6">
        Menu
        </a>

        <a href="{{ route('admin.pesanan.history') }}" class="flex items-center gap-3 px-4 py-3 w-auto rounded-lg 
            {{-- ini lu sesuaiin sama root hrefnya nanti --}}
            {{ Route::is('admin.pesanan.history') ? 'bg-[#F8B602] font-semibold':'hover:bg-[#4a0011] transition'}}">
          <img src="/assets/img/ic-history.png" alt="Order History" class="w-6 h-6">
          Order History
        </a>
  
        <a href="{{ route('admin.pesanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg 
            {{ Route::is('admin.pesanan.index') ? 'bg-[#F8B602] font-semibold':'hover:bg-[#4a0011] transition'}}">
          <img src="/assets/img/ic-bills.png" alt="Bills" class="w-6 h-6">
          Bills
        </a>
        
      </nav>
    </aside>
  
    <div class="ml-72 bg-[#f0e8e8] p-6 content w-full">
        @yield('content')
    </div>
  
</body>
</html>
