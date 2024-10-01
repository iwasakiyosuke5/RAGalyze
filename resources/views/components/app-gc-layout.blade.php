<!-- resources/views/components/app-gc-layout.blade.php -->
@extends('layouts.appGc')

@section('content')
    {{ $slot }}
@endsection

<style>

    .spinner {
        display: none;
        border: 16px solid black;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        /* width: 120px;
        height: 120px; */
        /*下記はバージョン違い  */

        width: 6em;
        height: 6em;
        margin-top: -3.0em;
        margin-left: -3.0em;
        /* border-radius: 50%;
        border: 0.25em solid #ccc;
        border-top-color: #333; */
        animation: spin 500ms linear infinite;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%); 
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

/* ファイルデータ用 */
</style>

<script>
        function showSpinner() {
            document.getElementById("spinner").style.display = "block";

            setTimeout(() => {
            const elements = document.querySelectorAll('input[type="submit"]', 'button[type="submit"]');
            elements.forEach(element => {
                element.disabled = true;
                
            });
            }, 0);

            const navLinks = document.querySelectorAll('nav a, nav button');
            navLinks.forEach(link => {
                link.style.pointerEvents = 'none'; // クリックを無効化
                link.style.opacity = '0.5';        // 視覚的にも無効化された状態を示す
            });
        }
</script>