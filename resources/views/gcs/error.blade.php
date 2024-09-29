<x-app-layout>
    <div class="container mx-auto text-center mt-20">
        <h1 class="text-3xl font-bold text-red-500">Time Error</h1>
        <p class="text-lg mt-4">You will be redirected shortly...</p>
    </div>

    <!-- 3秒後に指定のURLにリダイレクトするスクリプト -->
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('GcQuestion') }}"; // リダイレクト先のURL
        }, 3000); // 3秒後にリダイレクト
    </script>
</x-app-layout>
