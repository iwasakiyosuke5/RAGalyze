{{-- AIにpngデータを要約依頼するview --}}
<x-appHplc-layout>
    <div class="lg:w-full lg:flex px-3">
        <div id="spinner" class="spinner"></div> {{-- ローディングスピナー用のタグ --}}
        <section class="lg:w-2/5 text-gray-900 body-font">
            <div class="container px-5 lg:py-40 py-12 mx-auto">
                <h1 class="ml-2 text-4xl"><span class="text-pink-500 font-bold">R</span>egister HPLC Chromatogram</h1>
                <div class="ml-2 h-1 w-20 bg-pink-500 rounded"></div>
                <br>
                <div class="container px-5 pt-16 mx-auto">
                    <div class="text-center">
                        <h1 class="ml-2 text-pink-500"></h1>
                        {{-- <form action="{{ route('convert.png') }}" method="POST" enctype="multipart/form-data" onsubmit="showSpinner()">
                            @csrf
                            <input class="ml-2" type="file" name="image_file" accept="image/png" placeholder="gsg" required>
                            <button class="rounded-md bg-sky-500 py-2 px-3 text-gray-50 hover:bg-sky-700" type="submit">Request AI Summary</button>
                        </form> --}}
                        <form action="{{ route('convert.png') }}" method="POST" enctype="multipart/form-data" onsubmit="return handleFormSubmit()">
                            @csrf
                            <div class="file-input-container my-2">
                                <label for="file" class="text-2xl custom-file-label border-2 border-pink-500 rounded py-2 px-3 cursor-pointer hover:bg-pink-200">Click And Choose PNG:</label>
                                <input type="file" name="image_file" id="file" class="file-input hidden" accept="image/png" onchange="updateFileName()" required>

                            </div>
                            <div id="file-name" class="file-name my-3 text-xl font-bold">No file chosen</div>
                            <input class="text-2xl rounded-md bg-sky-500 py-2 px-3 text-gray-50 hover:bg-sky-700 cursor-pointer active:scale-95 active:shadow-lg transition-transform duration-100" type="submit" value="Request AI Summary" name="submit">
                        </form> 
                        
                    </div>
                    
                </div>
            </div>
        </section>
        
        <section class="lg:w-3/5 text-gray-600 body-font">
            <div class="container px-5 lg:py-auto py-12 mx-auto">
              <div class="flex items-center lg:w-4/5 mx-auto lg:border-t-0 border-t lg:pt-0 pt-5 pb-10 mb-10 border-gray-200 sm:flex-row flex-col">
                <div class="sm:w-32 sm:h-32 h-20 w-20 sm:mr-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 flex-shrink-0">
                    <div class="text-6xl fa-regular fa-circle-check" style="color: #f75588;"></div>
                </div>
                <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
                    <h2 class="text-gray-900 text-xl title-font font-medium mb-2">Request When Registering</h2>
                    <p class="leading-relaxed text-gray-700 text-lg">1. You will need to prepare a "PNG image".</p>
                    <div class="ml-5">
                        <p class="leading-relaxed text-base">The file should be in .png format.</p>
                        <p class="leading-relaxed text-base">If you have a PDF or other file format, please convert it to PNG beforehand.</p>
                    </div>
                    <br>
                    <p class="leading-relaxed text-gray-700 text-lg">2. The information on your PNG image doesn’t have to be perfect, but...</p>
                    <div class="ml-5">
                        <p class="leading-relaxed text-base">AI will read the analysis conditions and peaks from the image and summarize the data, so it's recommended to include as much information as possible.</p>
                        <p class="leading-relaxed text-base">After the AI summary, you can also add details yourself to complete the data.</p>
                    </div>
                    <br>
                    <p class="leading-relaxed text-gray-700 text-lg">3. Be sure to include the "Structural Formula" in the image.</p>
                    <div class="ml-5">
                        <p class="leading-relaxed text-base">It plays a key role in ensuring the accuracy of the AI's response.</p>    
                    </div>
                    <br>
                    <p class="leading-relaxed text-gray-700 text-lg">4. Don't forget to prepare the "SMILES Code" for the structure.</p>
                    <div class="ml-5">
                        <p class="leading-relaxed text-base">This will be required after the AI summary.</p>
                        <p class="leading-relaxed text-base">With the SMILES code, the AI can provide even more accurate analytical data.</p>    
                    </div>
                </div>
                
              </div>
            </div>
        </section>
    
    </div>


    <section class="text-gray-900 body-font">

    </section>

    <script>
        function updateFileName() {
            const fileInput = document.getElementById('file');
            const fileNameDisplay = document.getElementById('file-name');
            if (fileInput.files.length > 0) {
                fileNameDisplay.textContent = fileInput.files[0].name;
            } else {
                fileNameDisplay.textContent = 'No file chosen';
            }
        }

function validateFileName() {
            const fileInput = document.getElementById('file');
            const fileName = fileInput.files[0].name;
            const validPattern = /^[a-zA-Z0-9._-]+$/;

            if (!validPattern.test(fileName)) {
                alert('Invalid file name. Please use only alphanumeric characters, -, and _.');
                return false;
            }

            return true;
        }

        function handleFormSubmit() {
            if (!validateFileName()) {
                return false;
            }

            showSpinner();
            return true;
        }
    </script>


</x-appHplc-layout>