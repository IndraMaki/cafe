<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food4U</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-white min-h-screen flex flex-col items-start justify-start">
    <!-- Logo -->
    <div class="p-6">
        <div class="flex items-center gap-2">
        <img src="/assets/img/logo-login-admin.png" alt="Food4U Logo" class="w-40 h-auto">
        </div>
    </div>
    <!-- Login Card -->
  <div class="flex flex-col items-center justify-center px-10 w-full h-3/4">
    <div class="bg-[#660018] text-white rounded-lg shadow-lg px-8 py-10 w-full max-w-sm">
      <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>

      <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
        @csrf
        <input
          type="text"
          name="username"
          placeholder="Masukan Username"
          class="w-full px-4 py-2 rounded-md text-gray-700 focus:outline-none"
          required
        />
        <input
          type="password"
          name="password"
          placeholder="Masukan Password"
          class="w-full px-4 py-2 rounded-md text-gray-700 focus:outline-none"
          required
        />
        @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
        <button
          type="submit"
          class="w-full bg-[#1E2D58] hover:bg-[#1a2549] text-white font-semibold py-2 rounded-md transition"
        >
          Login
        </button>
      </form>
    </div>
  </div>
</body>
</html>
