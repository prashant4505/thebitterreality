<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - The Bitter Reality</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="grid min-h-screen place-items-center bg-slate-950 px-4">
    <form method="post" action="{{ route('admin.login.store') }}" class="w-full max-w-md rounded-3xl bg-white p-8 shadow-2xl">
        @csrf
        <h1 class="text-3xl font-black">Admin Login</h1>
        <p class="mt-2 text-slate-600">Secure editorial access for The Bitter Reality.</p>
        @error('email')<p class="mt-4 rounded-xl bg-red-100 p-3 text-sm font-bold text-red-700">{{ $message }}</p>@enderror
        <label class="mt-6 block text-sm font-bold">Email</label>
        <input class="input mt-2" type="email" name="email" value="{{ old('email') }}" required autofocus>
        <label class="mt-4 block text-sm font-bold">Password</label>
        <input class="input mt-2" type="password" name="password" required>
        <label class="mt-4 flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="remember" value="1"> Remember me</label>
        <button class="btn-primary mt-6 w-full">Login</button>
    </form>
</body>
</html>
