{{-- AIに質問するView --}}
<x-appHplc-layout>
<div class="lg:w-full lg:flex">
  <div id="spinner" class="spinner"></div> {{-- ローディングスピナー用のタグ --}}
    <section class="lg:w-1/2 text-gray-900 body-font">
        <div class="container px-5 lg:py-40 py-12 mx-auto">
            <h1 class="ml-2 text-4xl"><span class="text-pink-500 font-bold">A</span>sk a Question About HPLC Analysis Data</h1>
            <div class="ml-2 h-1 w-20 bg-pink-500 rounded"></div>
            <br>
            <form action="{{ route('search') }}" method="POST" onsubmit="showSpinner()">
                @csrf
                <label class="ml-2 text-gray-600 " for="query">Enter your question:</label>
                <textarea class="ml-2 pl-2 w-full min-h-40 rounded-lg border border-pink-500" type="text" id="query" name="query" required></textarea>
                <div class="flex justify-end">
                    <button class="rounded-md bg-sky-500 py-2 px-3 mt-2 text-gray-50 hover:bg-sky-700 active:scale-95 active:shadow-lg transition-transform duration-100"  type="submit">ASK!</button>
                </div>
            </form>
        </div>
    </section>
    
    <section class="lg:w-1/2 text-gray-600 body-font">
        <div class="container px-5 lg:py-10 py-12 mx-auto">
          <div class="flex items-center lg:w-4/5 mx-auto border-b pb-10 mb-10 border-gray-200 sm:flex-row flex-col">
            <div class="sm:w-32 sm:h-32 h-20 w-20 sm:mr-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 flex-shrink-0">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="sm:w-16 sm:h-16 w-10 h-10" viewBox="0 0 24 24">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
              </svg>
            </div>
            <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
              <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Ask To AI</h2>
              <p class="leading-relaxed text-base">Feel free to ask any question you have. The AI will do its best to answer.</p>
              <p class="leading-relaxed text-base">You can even ask about codes, for example: 'Give me the analysis data for G0592.'</p>

            </div>
          </div>
          <div class="flex items-center lg:w-4/5 mx-auto border-b pb-10 mb-10 border-gray-200 sm:flex-row flex-col">
            <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
              <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Using SMILES Code</h2>
              <p class="leading-relaxed text-base">If you know the sample structure, it's best to search using SMILES.</p>
              <p class="leading-relaxed text-xs text-base"><span class="italic">JPN.</span>「MW:117.15でアミノ基を持つSMILScode:CCC(NC)C(=O)Oの分析をします。似たような化合物の分析条件を教えて下さい。」</p>
              <p class="leading-relaxed text-xs text-base"><span class="italic">ENG.</span> "I am analyzing a compound with a molecular weight of 117.15 and an amino group with the SMILES code: CCC(NC)C(=O)O. Please provide the analysis conditions for similar compounds."</p>
              <p class="leading-relaxed text-xs text-base"><span class="italic">CHN.</span> "我正在分析一个分子量为117.15且含有氨基的化合物，SMILES代码为：CCC(NC)C(=O)O。请提供类似化合物的分析条件。"</p>
              
            </div>
            <div class="sm:w-32 sm:order-none order-first sm:h-32 h-20 w-20 sm:ml-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 flex-shrink-0">
                <div class="text-6xl fa-regular fa-face-smile-beam" style="color: #f75588;"></div>           
            </div>
          </div>
          <div class="flex items-center lg:w-4/5 mx-auto sm:flex-row flex-col">
            <div class="sm:w-32 sm:h-32 h-20 w-20 sm:mr-10 inline-flex items-center justify-center rounded-full bg-pink-100 text-pink-500 flex-shrink-0">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="sm:w-16 sm:h-16 w-10 h-10" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow sm:text-left text-center mt-6 sm:mt-0">
              <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Like Your Boss or Colleagues</h2>
              <p class="leading-relaxed text-base">Ideally, it's like asking <span class="text-xl">your Boss or colleagues</span> for advice.</p>
              <p class="leading-relaxed text-base">It's even better if you include the characteristics of the compound you want to analyze-things like molecular weight, functional groups, or compound-related keywords!</p>
            </div>
          </div>
        </div>
    </section>

</div>
</x-appHplc-layout>