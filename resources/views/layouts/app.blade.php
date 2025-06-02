<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>@yield('title', 'Dashboard')</title>
		<script src="https://cdn.tailwindcss.com"></script>
		<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet" />
	</head>
	<body class="bg-gray-100 text-gray-800">
		<div
            x-data="{
                sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen')) ?? true,
                currentPage: '{{ request()->routeIs('dashboard') ? 'dashboard' : (request()->routeIs('catalogue') ? 'catalogue' : (request()->routeIs('category') ? 'category' : '') ) }}',
                toggleSidebar() {
                this.sidebarOpen = !this.sidebarOpen;
                localStorage.setItem('sidebarOpen', this.sidebarOpen);
                }
            }"
            x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))"
            class="flex h-screen"
            >
			<!-- Sidebar -->
			<div :class="sidebarOpen ? 'w-64 shadow-xl' : 'w-20 shadow-sm' " class="transition-all duration-300 bg-white rounded-xl m-2 flex flex-col border border-gray-200" style="backdrop-filter: blur(10px);">
				<nav class="flex-1 px-2 py-4 space-y-2 ">
					<div class="flex items-center justify-center">
						<img x-show="sidebarOpen" src="{{ asset('images/logo-long.png') }}" alt="Logo" class="h-12 object-contain" />
						<img x-show="!sidebarOpen" src="{{ asset('images/logo-short.png') }}" alt="Logo Short" class="h-12 object-contain" />
					</div>
                    <hr class="border-gray-200"/>

                    <!-- To dashboard -->
                    <a
                        href="{{ route('dashboard') }}"
                        @click.prevent="currentPage = 'dashboard'; window.location.href='{{ route('dashboard') }}'"
                        :class="[
                        'relative flex items-center font-semibold gap-3 p-2 rounded text-gray-800 transition',
                        sidebarOpen ? '' : 'justify-center',
                        currentPage === 'dashboard' ? 'bg-gray-200 font-bold' : 'hover:bg-gray-300'
                        ]"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <i class="ri-dashboard-fill text-xl text-gray-800"></i>
                        <span x-show="sidebarOpen">Dashboard</span>

                        <div x-show="!sidebarOpen && hover" class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg" x-cloak>
                        Dashboard
                        </div>
                    </a>

                    <!-- Products -->
                    <a
                        href="{{ route('catalogue') }}"
                        @click.prevent="currentPage = 'catalogue'; window.location.href='{{ route('catalogue') }}'"
                        :class="[
                        'relative flex items-center font-semibold gap-3 p-2  rounded text-gray-800 transition',
                        sidebarOpen ? '' : 'justify-center',
                        currentPage === 'catalogue' ? 'bg-gray-200 font-bold' : 'hover:bg-gray-300'
                        ]"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <i class="ri-book-shelf-fill text-xl text-gray-800"></i>
                        <span x-show="sidebarOpen">Products</span>

                        <div x-show="!sidebarOpen && hover" class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg" x-cloak>
                        Products
                        </div>
                    </a>

                    <!-- Categories -->
                    <a
                        href="{{ route('category') }}"
                        @click.prevent="currentPage = 'category'; window.location.href='{{ route('category') }}'"
                        :class="[
                        'relative flex items-center font-semibold gap-3 p-2 rounded text-gray-800 transition',
                        sidebarOpen ? '' : 'justify-center',
                        currentPage === 'category' ? 'bg-gray-200 font-bold' : 'hover:bg-gray-300'
                        ]"
                        x-data="{ hover: false }"
                        @mouseenter="hover = true"
                        @mouseleave="hover = false"
                    >
                        <i class="ri-apps-2-add-fill text-xl text-gray-800"></i>
                        <span x-show="sidebarOpen">Categories</span>

                        <div x-show="!sidebarOpen && hover" class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg" x-cloak>
                        Categories
                        </div>
                    </a>

				</nav>
			</div>

			<!-- Main Content -->
			<div class="flex-1 flex flex-col">
				<!-- Top bar -->
				<div class="flex justify-between items-center bg-white p-2 rounded-xl m-2 border border-gray-200">
					<a class="flex items-center justify-start p-2 w-10 h-10 rounded-md hover:bg-gray-200 text-gray-800 transition"
                    :class="sidebarOpen ? '' : 'justify-center'"
                    @click="toggleSidebar()">
						<i class="ri-menu-fill text-2xl"></i>
					</a>

					<div class="relative" x-data="{ open: false }">
						<img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-gray-400" @click="open = !open" />
						<div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-50 p-4">
							<div class="text-sm font-medium text-gray-700">
								{{ Auth::check() ? Auth::user()->name : 'N/A' }}
							</div>
							<div class="text-xs text-gray-500">
								{{ Auth::check() ? Auth::user()->email : 'N/A' }}
							</div>
							<hr class="my-2" />
							<form method="POST" action="/logout">
								@csrf
								<button type="submit" class="w-full text-left text-red-500 hover:text-red-700 text-sm">
									Log out
								</button>
							</form>
						</div>
					</div>
				</div>

				<!-- Page Content Goes Here -->
				<div class="p-4 m-2 bg-white rounded-xl m-2 border border-gray-200 h-auto transition">
					@yield('content')
				</div>
			</div>
		</div>
	</body>
</html>
