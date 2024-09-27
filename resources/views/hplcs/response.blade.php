<x-appHplc-layout>
    <section class="text-gray-900 body-font">
  <div id="spinner" class="spinner"></div> {{-- ローディングスピナー用のタグ --}}
        <div class="container mx-auto mt-5 max-w-full">
                <div class="xl:flex xl:w-full">
                    <div class="xl:w-3/5">
                        <div class="ml-12 mr-12">
                            <div class="card-body">
                                <h5 class="text-xl font-semibold">Your Question :</h5>
                                <div class="text-gray-600 text-lg w-full p-2 bg-gray-50 rounded-lg border border-pink-500">{!! $question !!}</div>
                            </div>
                        </div>
                        <br>
                        <div class="ml-12 mr-12">
                            <div class="card-body">
                                <h5  class="text-xl font-semibold">AI Response :</h5>
                                <p class="italic text-xs text-gray-600">*Please ask again if there are any issues, such as the File_path not being displayed.</p>
                                <div class="text-gray-600 text-lg w-full p-2 bg-gray-50 rounded-lg border border-pink-500">{!! $aiResponse !!}</div>
                                <div class="grid place-items-end">
                                    <a href="{{ route('hplcQuestion') }}" class="rounded bg-sky-500 text-gray-50  hover:bg-sky-700 p-2 mt-1">Start Over</a>                                    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="ml-12 mr-12">
                            <div class="card-body">
                                <h5 class="text-xl font-semibold">Ask a Follow-up Question :</h5>
                                <form method="POST" action="{{ route('askAgain') }}" onsubmit="showSpinner()">
                                    @csrf
                                    <div class="form-group">
                                        <textarea class="pl-2 w-full min-h-40 rounded-lg border border-pink-500 text-lg" type="text" id="followupQuestion" name="followupQuestion" required></textarea>
                                    </div>
                                    <input type="hidden" name="previousQuestion" value="{{ $question }}">
                                    <input type="hidden" name="previousResponse" value="{{ $aiResponse }}">
                                    <div class="flex justify-end w-full">
                                        <button type="submit" class="rounded-md bg-sky-500 py-2 px-3 mt-2 text-gray-50 hover:bg-sky-700 active:scale-95 active:shadow-lg transition-transform duration-100">Ask Again</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="xl:w-2/5 border-l border-gray-200 xl:mt-0 mt-8">
                        <div class="xl:ml-4 ml-12 xl:mr-4 mr-12">
                            <h5 class="text-xl font-semibold mb-4">Top Data Sources Used by AI for This Answer:</h5>
                            <div class="overflow-y-scroll max-h-[44rem]">
                            @foreach($results as $result)
                                <div class="mb-4 p-4 bg-white rounded-lg shadow-lg border border-gray-300">
                                    <div class="card-body">
                                        <p class="text-gray-700 text-md mb-2">{{ $result['fragment']->content }}</p>
                                        <p class="text-gray-500 text-sm mb-2">
                                            <strong class="font-semibold text-gray-600">Similarity:</strong> <span class="text-sky-700">{{ $result['similarity'] }} </span>
                                        </p>
                                        <p class="text-gray-500 text-sm mb-2">
                                            <strong class="font-semibold text-gray-600">Posted by:</strong> <span class="text-sky-700">{{ $result['fragment']->user->name }}, {{ $result['fragment']->user->department }}</span>
                                        <p class="text-gray-500 text-sm">
                                            <strong class="font-semibold text-gray-600">File Path:</strong>
                                            <a href="{{ asset($result['fragment']->file_path) }}" class="text-sky-500 hover:text-sky-700" target="_blank">
                                                {{ $result['fragment']->file_path }}
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    
                
                
                </div>

        </div>
        
    </section>

    
</x-appHplc-layout>

