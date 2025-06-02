<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Small POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 ">

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
        @endif

        @if(session('error'))
            <div class="text-red-600 font-semibold">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="text-red-600 font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Progress bar -->
        <div class="w-full mt-2 h-1 bg-gray-200 rounded overflow-hidden">
            <div
                class="h-full bg-blue-500 transition-all duration-100"
                :style="{ width: progress + '%' }"
            ></div>
        </div>
    </div>
@endif


    <div class="max-w-md w-full bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Banner -->
        <div class="bg-sky-800 p-6 rounded-t-xl">
            <h1 class="text-white text-2xl font-semibold">Small POS</h1>
            <p class="text-indigo-200 mt-1 text-sm">Log in to access the POS</p>
        </div>

        <!-- Form -->
        <form action="{{ url('/login') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-sky-500" />
            </div>
            <button type="submit"
                class="w-full bg-sky-800 text-white font-semibold py-2 rounded-md hover:bg-sky-700 transition">Log In</button>
        </form>

        <!-- Footer -->
        <div class="p-6 border-t text-center text-sm text-gray-600">
            Don't have an account?
            <a href="{{ url('/register') }}" class="text-sky-600 hover:underline">Register here</a>
        </div>
    </div>
</body>
</html>
