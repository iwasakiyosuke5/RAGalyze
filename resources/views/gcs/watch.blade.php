<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/862824129a.js" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a>
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200 cursor-not-allowed" />
                            </a>
                        </div>
        
                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link  class="text-indigo-800 hover:text-indigo-500 hover:border-b-2 hover:border-indigo-500 cursor-not-allowed">
                                {{ __('Select Equip.') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link class="text-green-800 hover:text-green-500 hover:border-b-2 hover:border-green-500 cursor-not-allowed">
                                {{ __('GC') }}
                            </x-nav-link>
                        </div>
                    </div>
        
                    <div class="flex">
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link class="text-black hover:text-green-500 hover:border-b-2 hover:border-green-500 cursor-not-allowed">
                                {{ __('Register') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link class="text-black hover:text-green-500 hover:border-b-2 hover:border-green-500 cursor-not-allowed">
                                {{ __('Ask') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link class="text-black hover:text-green-500 hover:border-b-2 hover:border-green-500 cursor-not-allowed">
                                {{ __('My Posts') }}
                            </x-nav-link>
                        </div>
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <x-nav-link class="text-black hover:text-green-500 hover:border-b-2 hover:border-green-500 cursor-not-allowed">
                                {{ __('Our Records') }}
                            </x-nav-link>
                        </div>
                    </div>
                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div class="italic">
                            Only <span class="text-indigo-500">'1. Data Upload'</span> or 
                            <br>
                            <span class="text-rose-500">'2. Upload Other Data'</span> are clickable.
                        </div>
                    </div>
        

                </div>
            </div>
        
            </div>
        </nav>

    
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
{{-- 画面左 --}}
            <div class="flex w-full">
                <div class="w-1/3 border-r-2">
                    <div class="justify-center">
                        <div class="m-2">
                            <h1 class="text-md">Review the AI summary and add any additional information in the <span class="text-green-500 font-bold">input field</span>.</h1>
                            <div class="text-gray-600">
                                <p class="text-sm">1. Fill in any missing analysis conditions.</p>
                                <p class="text-sm">2. Keywords: chemical formula, molecular weight, Functional Groups, Structural Info. (Trisaccharide Chain, Triphenylamine Seleton), Intermediate No, Experiment Note Number, or any other information that helps the AI find relevant data.</p>
                                <br>
                                <p class="text-sm">If you know the structure, also input the <span class="text-green-500 font-bold">"SMILES code."</span></p>
                                <p class="text-sm">The AI might fill in the "SMILES code," <span class="text-green-500">but it often makes mistakes</span>, so it's best to input it yourself.</p>
                                
                            </div>
                            
        
                        </div>

                        <br>
                        <div class="mx-2">
        
                            <div class="rounded-md border-2 border-sky-500">
                                <h1>Example 1: M1112</h1>
                                <img class="w-2/5" src="{{ asset('img/M1112.png') }}" alt="">
                                <p>Keywords: 4,5-Methylenedithio-1,3-dithiole-2-thione</p>
                                <p>C4H2S5:210.36. Tetrathiafulvalene(TTF) derivative.</p>  
                                <div class="bg-gray-300">
                                    <p class="text-sm italic">もし日本語で記載したら、C4H2S5:210.36。テトラチアフルバレン（TTF）誘導体。</p>    
                                </div>
                                <p>SMILEScode: C1SC2=C(S1)SC(=S)S2</p> 
                                   
                            </div>
                            <br>
                            <div class="rounded-md border-2 border-sky-500">
                                <h1>Example 2: Synthetic Intermediate B</h1>
                                <img class="w-2/5" src="{{ asset('img/A1172.png') }}" alt="">
                                <p>Keywords: C9H18N2O2 = 186.26. 3-Aminopyrrolidine derivative with Boc protection. Chiral compound.</p>
                                <p>Starting material for custom product Z5xyz</p>
                                <div class="bg-gray-300">
                                    <p class="text-sm italic">もし日本語で記載したら、C9H18N2O2 = 186.26。3-アミノピロリジン誘導体, Boc保護有り。</p>
                                    <p class="text-sm italic">キラル化合物。特注品Z5xyzの出発原料。</p>    
                                </div>
                                <p>SMILEScode: CC(C)(C)OC(=O)NC1CCNC1</p>
                            </div>
        
                        </div>
            
                    </div>
                </div>
                {{-- 画面中央 --}}
                <div class="w-1/3">
                    <div class="">
                        <div>
                            <h1 class="ml-2 text-lg text-green-500">AI-Summarized Text</h1>
                        </div>
                        <div class="ml-2 mr-2">
                            <form action="{{ route('gc_upload') }}" method="POST" enctype="multipart/form-data" class="">
                                @csrf
                                <textarea class="w-full rounded-md border-2 border-green-500" name="text_data" id="" cols="" rows="30">{{ $textData }}</textarea>
                                <input type="hidden" name="file_path" value={{ $filePath }}>
                                <div class="grid place-items-end">
                                    <button class="rounded-md bg-sky-500 p-2 w-1/3 text-gray-50 hover:bg-sky-700 active:scale-95 active:shadow-lg transition-transform duration-100" type="submit">1.Data Upload</button>
                                </div>
                                
                            </form>
                            <br>
                            
                            <form action="{{ route('deleteAndRedirectGc') }}" method="POST">
                                @csrf
                                <input type="hidden" name="file_path" value="{{ $filePath }}">
                                <div class="grid place-items-end">
                                    <button class="rounded-md bg-rose-500 p-2 w-1/3 hover:text-gray-300 active:scale-95 active:shadow-lg transition-transform duration-100" type="submit">2.Upload Other Data</button>
                                </div>
                            </form>
                        
                        </div>

                    </div>
                </div>
                
                
        {{-- 画面右 --}}
                <div class="w-1/3 border-l-2">
                    {{-- pngの表示 --}}
                    <div  class="zoom-container border-4 border-black mr-2">
                        <img src="data:image/png;base64,{{ $imageData }}" alt="Uploaded Image" class="zoom-image"  id="zoom-image">
                    </div>
                </div>
            </div>

        </div>

        <style>
            .zoom-container {
                width: 100%;
                height: 800px; /* 表示エリアの高さを指定 */
                overflow-y: auto; /* 縦方向のスクロールを有効に */
                overflow-x: auto; /* 横方向のスクロールを有効に */
                position: relative;
                border: 1px solid #ccc; /* 画像の周りに枠を追加 */
                cursor: zoom-in;
            }
    
            .zoom-image {
                width: 100%;
                height: 100%;
                object-fit: contain; /* 画像をコンテナ内に収める */
                transition: transform 0.3s ease; /* 拡大縮小のスムーズなトランジション */
    
                
            }
    
            /* 拡大時の状態 */
            .zoomed {
                cursor: zoom-out; /* 拡大時のカーソル */
                height: auto;
            }
        </style>
    
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const image = document.getElementById('zoom-image');
                let isZoomed = false; // 現在のズーム状態を追跡
    
                image.addEventListener('click', function (event) {
                    if (!isZoomed) {
                        const rect = image.getBoundingClientRect();
                        const offsetX = event.clientX - rect.left;
                        const offsetY = event.clientY - rect.top;
    
                        const scale = 2;
                        const originX = (offsetX / rect.width) * 100;
                        const originY = (offsetY / rect.height) * 100;
    
                        image.style.transformOrigin = `${originX}% ${originY}%`;
                        image.style.transform = `scale(${scale})`;
                        image.classList.add('zoomed');
                        isZoomed = true;
                    } else {
                        image.style.transform = `scale(1)`;
                        image.classList.remove('zoomed');
                        isZoomed = false;
                    }
                });
            });
        </script>
    


    </body>
    



    

</html>
