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
                currentPage: '{{ request()->routeIs('dashboard') ? 'dashboard' : (request()->routeIs('catalogue') ? 'catalogue' : (request()->routeIs('category') ? 'category' : (request()->routeIs('pos') ? 'pos' : ''))) }}',
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
				:class="sidebarOpen ? 'w-64 shadow-xl' : 'w-20 shadow-none bg-transparent border-none'"
				class="transition-all duration-300 bg-white rounded-xl m-2 flex flex-col border border-gray-200"
				style="backdrop-filter: blur(10px); border-radius: 1.5rem"
			>
				<div>
					<!-- Menu Toggle -->
					<div class="px-2 py-4">
						<div
							@click="toggleSidebar()"
							class="relative flex items-center rounded text-gray-800 transition hover:bg-gray-300 cursor-pointer"
							:class="sidebarOpen ? 'w-10 h-10 justify-center' : 'p-2 gap-3 justify-center w-full'"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<!-- Toggle icon changes based on sidebarOpen -->
							<i :class="sidebarOpen ? 'ri-sidebar-fold-line text-xl' : 'ri-side-bar-line text-xl'" class="text-gray-800"></i>

							<!-- Tooltip when sidebar is closed -->
							<div x-show="!sidebarOpen && hover" class="absolute right-full top-1/2 -translate-y-1/2 mr-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg" x-cloak>
								Toggle Menu
							</div>
						</div>
					</div>

					<!-- Nav links -->
					<nav class="flex flex-col px-2 py-4 space-y-2">
						<!-- Dashboard -->
						<a
							href="{{ route('dashboard') }}"
							@click.prevent="currentPage = 'dashboard'; window.location.href='{{ route('dashboard') }}'"
							:class="[
                    'relative flex items-center gap-3 p-2 rounded text-gray-800 transition',
                    sidebarOpen ? '' : 'justify-center',
                    currentPage === 'dashboard' ? 'bg-gray-200 font-bold' : 'hover:bg-gray-300'
                ]"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<i class="ri-dashboard-line text-xl text-gray-800"></i>
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
                    'relative flex items-center gap-3 p-2 rounded text-gray-800 transition',
                    sidebarOpen ? '' : 'justify-center',
                    currentPage === 'catalogue' ? 'bg-gray-200 font-bold' : 'hover:bg-gray-300'
                ]"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<i class="ri-book-shelf-line text-xl text-gray-800"></i>
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
                    'relative flex items-center gap-3 p-2 rounded text-gray-800 transition',
                    sidebarOpen ? '' : 'justify-center',
                    currentPage === 'category' ? 'bg-gray-200 font-bold' : 'hover:bg-gray-300'
                ]"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<i class="ri-apps-2-add-line text-xl text-gray-800"></i>
							<span x-show="sidebarOpen">Categories</span>
							<div x-show="!sidebarOpen && hover" class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg" x-cloak>
								Categories
							</div>
						</a>
						<!-- POS -->
						<a
							href="{{ route('pos') }}"
							@click.prevent="currentPage = 'pos'; window.location.href='{{ route('pos') }}'"
							:class="[
                    'relative flex items-center gap-3 p-2 rounded text-gray-800 transition',
                    sidebarOpen ? '' : 'justify-center',
                    currentPage === 'pos' ? 'bg-gray-200 font-bold' : 'hover:bg-gray-300'
                ]"
							x-data="{ hover: false }"
							@mouseenter="hover = true"
							@mouseleave="hover = false"
						>
							<i class="ri-shopping-cart-2-line text-xl text-gray-800"></i>
							<span x-show="sidebarOpen">POS</span>
							<div x-show="!sidebarOpen && hover" class="absolute left-full top-1/2 -translate-y-1/2 ml-2 whitespace-nowrap bg-white text-gray-800 text-xs rounded px-2 py-1 shadow-lg" x-cloak>
								POS
							</div>
						</a>
					</nav>
				</div>

				<!-- Profile section (bottom of sidebar) -->
				<div class="mt-auto p-2 border-t border-gray-200 border border-gray-200 m-2 rounded-xl" x-data="{ open: false }">
					<div class="flex items-center gap-3" :class="sidebarOpen ? '' : 'justify-center bg-transparent'">
						<!-- Avatar -->
						<div class="relative">
							<!-- <img src="https://i.pravatar.cc/40" class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-gray-400 transition" @click="open = !open" /> -->
							<img src="{{ asset('images/logo-short.png') }}" class="w-10 h-10 rounded-full cursor-pointer border-2 border-gray-300 hover:border-gray-400 transition" @click="open = !open" />

							<!-- Dropdown (optional) -->
							<div x-show="open" @click.away="open = false" x-transition class="absolute left-0 bottom-full mb-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-50 p-4">
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

						<!-- Name and logout (only when sidebar is open) -->
						<template x-if="sidebarOpen">
							<div class="flex-1">
								<div class="text-sm font-medium text-gray-700 whitespace-nowrap">
									{{ Auth::check() ? Auth::user()->name : 'N/A' }}
								</div>
								<div class="text-xs text-gray-500 whitespace-nowrap">
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
				<div class="flex-1 p-6 m-2 bg-white shadow-xl border border-gray-200 transition" style="border-radius: 1.5rem">
					@yield('content')
				</div>
			</div>
		</div>
	</body>
</html>
