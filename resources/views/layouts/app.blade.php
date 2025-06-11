<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>@yield('title', 'Dashboard')</title>
		<script src="https://cdn.tailwindcss.com"></script>
		<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet" />
	</head>
	<body class="bg-gray-100 text-gray-800 bg-[url(https://cdn.neowin.com/news/images/galleries/4971/1749539165_macos_26_wallpaper_light.webp)] bg-gray-50 bg-no-repeat bg-cover bg-cover">
		<div
			x-data="{
    sidebarOpen: JSON.parse(localStorage.getItem('sidebarOpen')) ?? true,
    currentPage: '{{ (request()->routeIs('dashboard') ? 'dashboard' : (request()->routeIs('catalogue') ? 'catalogue' : (request()->routeIs('category') ? 'category' : (request()->routeIs('pos') ? 'pos' : (request()->routeIs('sale-orders.index') || request()->routeIs('sale-orders.show') ? 'sale-orders' : ''))))) }}',

    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
    }
}"

			x-init="$watch('sidebarOpen', value => localStorage.setItem('sidebarOpen', value))"
			class="flex h-screen"
		>
			<!-- Sidebar -->
			<div
				:class="sidebarOpen ? 'w-64 shadow-xl' : 'w-20 shadow-none bg-transparent border-none backdrop-blur-none'"
				class="transition-all duration-300 bg-white rounded-xl m-2 flex flex-col border border-gray-200 bg-white/30 backdrop-blur-md"
				style="border-radius: 1.5rem"
			>
				<div>
					<!-- Menu Toggle -->
					<div class="px-2 py-4">
						<div
							@click="toggleSidebar()"
							class="relative flex items-center rounded-xl text-gray-800 transition hover:bg-white cursor-pointer"
							:class="sidebarOpen ? 'w-10 h-10 justify-center' : 'p-2 gap-3 justify-center w-full'"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<!-- Toggle icon changes based on sidebarOpen -->
							<i :class="sidebarOpen ? 'ri-sidebar-fold-line text-xl' : 'ri-side-bar-line text-xl'" class="text-gray-800"></i>
						</div>
					</div>

					<!-- Nav links -->
					<nav class="flex flex-col px-2 py-4 space-y-2">
						<!-- Dashboard -->
						<a
							href="{{ route('dashboard') }}"
							@click.prevent="currentPage = 'dashboard'; window.location.href='{{ route('dashboard') }}'"
							:class="[
            'relative flex items-center gap-3 p-2 rounded-xl text-gray-800 transition',
            sidebarOpen ? '' : 'justify-center',
            currentPage === 'dashboard' ? 'bg-white/70 font-bold shadow-md backdrop-blur-sm' : 'hover:bg-white/50'
        ]"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<i class="ri-dashboard-line text-xl text-gray-800"></i>
							<span x-show="sidebarOpen">Dashboard</span>
							<div
								x-show="!sidebarOpen && hover && currentPage !== 'dashboard'"
								class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg z-10"
								x-cloak
							>
								Dashboard
							</div>
						</a>

						<!-- Products -->
						<a
							href="{{ route('catalogue') }}"
							@click.prevent="currentPage = 'catalogue'; window.location.href='{{ route('catalogue') }}'"
							:class="[
            'relative flex items-center gap-3 p-2 rounded-xl text-gray-800 transition',
            sidebarOpen ? '' : 'justify-center',
            currentPage === 'catalogue' ? 'bg-white/70 font-bold shadow-md' : 'hover:bg-white/50'
        ]"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<i class="ri-book-shelf-line text-xl text-gray-800"></i>
							<span x-show="sidebarOpen">Products</span>
							<div
								x-show="!sidebarOpen && hover && currentPage !== 'catalogue'"
								class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg z-10"
								x-cloak
							>
								Products
							</div>
						</a>

						<!-- Categories -->
						<a
							href="{{ route('category') }}"
							@click.prevent="currentPage = 'category'; window.location.href='{{ route('category') }}'"
							:class="[
            'relative flex items-center gap-3 p-2 rounded-xl text-gray-800 transition border-white',
            sidebarOpen ? '' : 'justify-center',
            currentPage === 'category' ? 'bg-white/70 font-bold shadow-md' : 'hover:bg-white/50'
        ]"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<i class="ri-apps-2-add-line text-xl text-gray-800"></i>
							<span x-show="sidebarOpen">Categories</span>
							<div
								x-show="!sidebarOpen && hover && currentPage !== 'category'"
								class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg z-10"
								x-cloak
							>
								Categories
							</div>
						</a>
                        <a
							href="{{ route('pos') }}"
							@click.prevent="currentPage = 'pos'; window.location.href='{{ route('pos') }}'"
							:class="[
            'relative flex items-center gap-3 p-2 rounded-xl text-gray-800 transition border-white',
            sidebarOpen ? '' : 'justify-center',
            currentPage === 'pos' ? 'bg-white/70 font-bold shadow-md' : 'hover:bg-white/50'
        ]"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<i class="ri-store-2-line text-xl text-gray-800"></i>
							<span x-show="sidebarOpen">Point of Sales</span>
							<div
								x-show="!sidebarOpen && hover && currentPage !== 'category'"
								class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg z-10"
								x-cloak
							>
								Point of Sales
							</div>
						</a>


						<a
    href="{{ route('sale-orders.index') }}"
    @click.prevent="currentPage = 'sale-orders'; window.location.href='{{ route('sale-orders.index') }}'"
    :class="[
        'relative flex items-center gap-3 p-2 rounded-xl text-gray-800 transition',
        sidebarOpen ? '' : 'justify-center',
        currentPage === 'sale-orders' ? 'bg-white/70 font-bold shadow-md' : 'hover:bg-white/50'
    ]"
    x-data="{ hover: false }"
    @mouseenter="hover = true"
    @mouseleave="hover = false"
>
    <i class="ri-file-list-3-line text-xl text-gray-800"></i>
    <span x-show="sidebarOpen">Sale Orders</span>
    <div
        x-show="!sidebarOpen && hover && currentPage !== 'sale-orders'"
        class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg z-10"
        x-cloak
    >
        Sale Orders
    </div>
</a>
					</nav>
				</div>

				<!-- Profile section (bottom of sidebar) -->
				<div class="mt-auto p-2 m-2 rounded-xl" x-data="{ open: false }">
					<div class="flex items-center gap-3" :class="sidebarOpen ? '' : 'justify-center '">
						<!-- Avatar -->
						<div class="relative bg-white rounded-full">
							<!-- <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-gray-400 transition" @click="open = !open" /> -->
							<img src="{{ asset('images/logo-short.png') }}" class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-gray-400 transition" @click="open = !open" />

							<!-- Dropdown (optional) -->
							<div x-show="open" @click.away="open = false" x-transition class="absolute left-0 bottom-full mb-2 w-48 bg-white/75 backdrop-blur-md border border-gray-200 rounded-xl shadow-lg z-50 p-4">
								<div class="text-md font-medium text-gray-700">
									{{ Auth::check() ? Auth::user()->name : 'N/A' }}
								</div>
								<div class="text-sm text-gray-500">
									{{ Auth::check() ? Auth::user()->email : 'N/A' }}
								</div>
								<form method="POST" action="/logout">
									@csrf
									<button type="submit" class="px-4 py-1 mt-4 border rounded-md shadow-sm bg-white text-red-600 hover:bg-red-100 transition"><i class="ri-logout-box-r-line"></i> Log out</button>
								</form>
							</div>
						</div>

						<!-- Name and logout (only when sidebar is open) -->
						<template x-if="sidebarOpen">
							<div class="flex-1">
								<div class="text-sm font-medium text-white whitespace-nowrap">
									{{ Auth::check() ? Auth::user()->name : 'N/A' }}
								</div>
								<div class="text-xs text-white whitespace-nowrap">
									{{ Auth::check() ? Auth::user()->email : 'N/A' }}
								</div>
							</div>
						</template>

						<template x-if="sidebarOpen">
							<form method="POST" action="/logout">
								@csrf
								<button type="submit" class="text-red-500 hover:text-red-700 text-sm" title="Logout">
									<i class="ri-logout-box-r-line text-xl"></i>
								</button>
							</form>
						</template>
					</div>
				</div>
			</div>

			<!-- Main Content -->
			<div class="flex-1 flex flex-col min-h-screen">
				<!-- Page Content -->
				<div class="flex-1 p-6 m-2 shadow-xl border border-gray-200 transition bg-white/50 backdrop-blur-md" style="border-radius: 1.5rem">
					@yield('content')
				</div>
			</div>
		</div>
	</body>
</html>
