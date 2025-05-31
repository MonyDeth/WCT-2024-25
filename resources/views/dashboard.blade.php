<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet" />

</head>
<body class="bg-gray-100 text-gray-800">

<div x-data="{ sidebarOpen: true }" class="flex h-screen">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'w-64' : 'w-20'" class="transition-all duration-300 bg-white shadow-lg flex flex-col">
        <div class="flex items-center justify-between p-4">
            <span class="text-lg font-bold" x-show="sidebarOpen">MyApp</span>
            <button @click="sidebarOpen = !sidebarOpen" class="gap-3 flex rounded items-center p-2 text-gray-600 hover:bg-gray-200">
                <i class="ri-menu-fill text-2xl"></i>
            </button>
        </div>

        <nav class="flex-1 px-2 py-4 space-y-2">
            <a href="#"
               class="flex items-center gap-3 p-2 rounded hover:bg-gray-200 text-gray-800 transition"
               :class="sidebarOpen ? '' : 'justify-center'"
            >
                <i class="ri-dashboard-fill text-2xl h-8 w-8 text-center text-sky-800"></i>
                <span x-show="sidebarOpen">Dashboard</span>
            </a>
            <a href="#"
               class="flex items-center gap-3 p-2 rounded hover:bg-gray-200 text-gray-800 transition"
               :class="sidebarOpen ? '' : 'justify-center'"
            >
                 <i class="ri-shopping-cart-fill text-2xl h-8 w-8 text-center text-sky-800"></i>
                <span x-show="sidebarOpen">POS</span>
            </a>
        </nav>
    </div>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <!-- Top bar -->
        <div class="flex justify-end items-center bg-white p-4 shadow-md">
            <div class="relative" x-data="{ open: false }">
                <img src="https://i.pravatar.cc/40" @click="open = !open"
                     class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-sky-500"/>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-50 p-4">
                    <div class="text-sm font-medium text-gray-700">
                        {{ Auth::check() ? Auth::user()->name : 'N/A' }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ Auth::check() ? Auth::user()->email : 'N/A' }}
                    </div>
                    <hr class="my-2">
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit"
                                class="w-full text-left text-red-500 hover:text-red-700 text-sm">
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="p-6">
            <h1 class="text-2xl font-semibold">Welcome to Dashboard</h1>
            <p class="text-gray-600">This is an empty placeholder. Start building here.</p>
        </div>
    </div>
</div>

</body>
</html>
