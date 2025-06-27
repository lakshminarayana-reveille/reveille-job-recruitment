<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Reveille Technologies</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li class="border-r border-gray-300 pr-4"><a href="{{ route('admin.applications') }}" class="hover:text-gray-300">Applications</a></li>
                    <li>
                        <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="hover:text-gray-300 cursor-pointer">Logout</button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</body>
</html>
