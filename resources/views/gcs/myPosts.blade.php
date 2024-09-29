<x-appGc-layout>
    <section class="text-gray-900 body-font">
    <body class="font-sans antialiased text-gray-900">
    
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
{{-- 画面左 --}}
            <div class="flex w-full">
                <div class="w-1/3 border-r-2">
                    <div class="justify-center">
                        <div class="m-4">
                            <h1 class=" text-4xl"><span class="text-green-500 font-bold">M</span>y Posts</h1>
                            <div class="h-1 w-20 bg-green-500 rounded"></div>
                            <br>
                            <div class="text-gray-600" >
                                <p class="text-md">Here is a list of the GC data you have registered.</p>
                                <p class="text-md">You can view details by selecting the data.</p>
                                <br>
                                <p class="text-md">You can also edit the displayed text field and update it <span class="rounded bg-sky-500 text-gray-50 px-1">(Refresh Data!)</span>.</p>
                                <p class="text-md">If you determine that the data is not appropriate for registration, you can also delete it <span class="rounded bg-rose-500 text-gray-900 px-1">(Delete Data!)</span>.</p>
    
                            </div>
                            
        
                        </div>
                        <br>

                        <div class="flex mx-2 rounded-md border-2 border-sky-500">
                            @php
                            $id = Auth::user()->id; // ログインユーザーのIDを取得
                            @endphp

                            <div class="rounded-lg border p-4 bg-white w-full">
                            <h3 class="text-gray-900">{{Auth::user()->name}} san's Posts</h3>
                            <p class="mb-4 text-gray-500"></p>
                            <form method="GET" action="{{ route('gcMyPosts') }}" class="mx-2">
                              <div>
                                @csrf
                                <input type="text" name="search" placeholder="Searching For Summury & File" value="{{ request('search') }}" class="px-2 py-2 border border-green-500 rounded placeholder:italic  placeholder:text-xs w-1/2" />
                                <button type="submit" class="rounded-md bg-sky-500 py-2 px-3 mt-2 text-gray-50 hover:bg-sky-700 active:scale-95 active:shadow-lg transition-transform duration-100">Search</button>
                                <!-- 検索解除ボタン -->
                                    @if(request('search'))
                                    <a href="{{ route('gcMyPosts') }}" class="rounded-md bg-gray-500 py-2 px-3 mt-2 text-gray-50 hover:bg-gray-700 active:scale-95 active:shadow-lg transition-transform duration-100">
                                        Reset
                                    </a>
                                    @endif
                              </div>
                              <p class="italic text-xs text-gray-500">(Not AI Search, Separated search by space is possible.)</p>
                            </form>
       
                            <br>
                            @if($mines->count())
                                <div class="overflow-x-auto">
                                <table class="min-w-full table-auto"> <!-- ここでテーブルを追加 -->
                                    <thead>
                                    <tr class="w-1/4 text-sm text-center">
                                        <th class="font-semibold">No</th>
                                        <th class="font-semibold">Upload Date</th>
                                        <th class="font-semibold">File Name</th>
                                        <th class="font-semibold">Detail</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($mines as $mine)
                                    <tr class="text-center">
                                        <td class="border px-4 py-2">{{ $mine->id }}</td>
                                        <td class="border px-4 py-2 text-xs">{{ $mine->updated_at->format('Y-m-d') }}</td>
                                        <td class="border px-4 py-2 text-xs">{{ basename($mine->file_path) }}</td>
                                        <td class="border px-4 py-2">
                                        <a href="{{ route('gcChooseData', ['id' => $mine->id, 'search' => request('search')]) }}" class="text-blue-500 hover:underline">🔍</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table> <!-- テーブルの終了タグ -->

                                <div class="my-2">
                                    {{ $mines->links('vendor.pagination.custom-tailwind') }}
                                </div>

                                </div>
 
                            @else
                                <p class="text-lg font-bold text-rose-600">No Posts found.</p>
                            @endif

                            </div>
                        </div>
                    </div>
                </div>
                {{-- 画面中央 --}}
                <div class="w-1/3">
                    <div class="">
                        <div>
                            <h1 class="mt-4 ml-2 text-xl">Selected Data Summary</h1>
                        </div>
                        @if(isset($textData) && !empty($textData))
                        <div class="">
                            <h1 class="ml-2 text-lg text-green-500">No:{{ $post->id }}</h1>
                            <div class="ml-2 mr-2">
                                <form action="{{ route('gcUpdateData', ['gc_result' => $post->id]) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Really Refresh?');">
                                    @csrf
                                    @method('PUT')
                                    <textarea class=" w-full rounded-md border-2 border-green-500" name="text_data" id="" cols="" rows="24">{{ $textData }}</textarea>
                                    <input type="hidden" name="file_path" value=>
                                    <div class="grid place-items-end">
                                        <button class="rounded-md bg-sky-500 mt-2 p-2 w-1/3 text-gray-50 hover:bg-sky-700 text-lg" type="submit">Refresh Data!</button>
                                    </div>
                                    
                                </form>
                                
                                
                                <form action="{{ route('gcDestroyData', ['gc_result' => $post->id]) }}" method="POST" onsubmit="return confirm('Really Delete?');">
                                    @csrf
                                    @method('DELETE') 
                                    <input type="hidden" name="file_path" value="{{ $post->file_path }}">
                                    <div class="grid place-items-end">
                                        <button class="rounded-md bg-rose-500 p-2 w-1/3 hover:bg-rose-700 text-lg" type="submit">Delete Data!</button>
                                    </div>
                                </form>
                            </div>
                            
                        
                        </div>
                        @else
                        <div class="ml-8">
                            <p class="text-gray-600 text-sm">Just press the 🔍 from the left side and it'll pop up!</p>
                        </div>
                        @endif

                    </div>
                </div>
                
                
        {{-- 画面右 --}}
                <div class="w-1/3 border-l-2">
                    <h1 class="mt-4 ml-2 text-xl">Selected Data Image</h1>
                    {{-- pngの表示 --}}
                    <div class="flex">
                        <div  class="zoom-container border-4 border-black mx-2 rounded-md">
                            @if(isset($imageData) && !empty($imageData))
                            <img src="data:image/png;base64,{{ $imageData }}" alt="Uploaded Image" class="zoom-image"  id="zoom-image">
                            @else
                            <div class="ml-8">
                                <p class="text-gray-600 text-sm">Just press the 🔍 from the left side and it'll pop up!</p>
                            </div>
                            @endif
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
    </section>
</x-appGc-layout>



    


