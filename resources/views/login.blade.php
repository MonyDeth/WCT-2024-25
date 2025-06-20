<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Login - Small POS</title>
		<script src="https://cdn.tailwindcss.com"></script>
		<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
	</head>
	<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
		@if(session('success') || session('error') || $errors->any())
		<div
			x-data="{ show: true, progress: 100 }"
			x-show="show"
			x-transition.opacity.duration.500ms
			x-init="
            let totalTime = 3000;
            let intervalTime = 30;
            let decrement = 100 / (totalTime / intervalTime);
            let interval = setInterval(() => {
                if (progress <= 0) {
                    setTimeout(() => show = false, 50); // Fade out after progress finishes
                    clearInterval(interval);
                } else {
                    progress -= decrement;
                }
            }, intervalTime);
        "
			class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-sm bg-white shadow-lg rounded-lg p-4 border border-gray-300 text-sm text-gray-800"
		>
			<button @click="show = false" class="absolute top-2 right-2 text-gray-500 hover:text-black text-lg leading-none">&times;</button>

			@if(session('success'))
			<div class="text-green-600 font-semibold">{{ session('success') }}</div>
			@endif @if(session('error'))
			<div class="text-red-600 font-semibold">{{ session('error') }}</div>
			@endif @if($errors->any())
			<div class="text-red-600 font-semibold">
				{{ $errors->first() }}
			</div>
			@endif

			<!-- Progress bar -->
			<div class="w-full mt-2 h-1 bg-gray-200 rounded overflow-hidden">
				<div class="h-full bg-blue-500 transition-all duration-100" :style="{ width: progress + '%' }"></div>
			</div>
		</div>
		@endif

		<div class="max-w-3xl w-full mx-auto bg-card text-card-foreground flex flex-col gap-6 rounded-xl border shadow-sm overflow-hidden p-0">
			<div class="grid p-0 md:grid-cols-2">
                <!-- Login Form -->
				<form action="{{ url('/login') }}" method="POST" class="p-6 space-y-4 bg-white">
					<div class="bg-transparent rounded-t-xl">
						<h1 class="text-gray-800 text-2xl font-bold">Log in</h1>
						<p class="text-gray-600 mt-1 text-sm">Log in to access the POS</p>
					</div>
					@csrf
					<div>
						<label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
						<input type="email" id="email" name="email" required class="w-full px-3 py-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 shadow-sm" />
					</div>
					<div>
						<label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
						<input type="password" id="password" name="password" required class="w-full px-3 py-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500 shadow-sm" />
					</div>
					<button type="submit" class="w-full bg-gray-800 text-white font-semibold py-2 rounded-md hover:bg-gray-700 transition">Log In</button>
					<div class="p-6 border-t text-center text-sm text-gray-600">
						Don't have an account?
						<a href="{{ url('/register') }}" class="px-4 py-1 ms-2 border rounded-md shadow-sm text-gray-600 hover:bg-gray-100 transition">Register here</a>
					</div>
				</form>

                <!-- Banner -->
                <div class="bg-muted relative hidden md:block">
                    <img src="https://frutiger-aero.org/img/frutiger-aero-1.webp" class="absolute inset-0 h-full w-full object-cover" />
                </div>
			</div>
		</div>
	</body>

    
</html>
