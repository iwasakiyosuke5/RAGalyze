<x-appHplc-layout>

    <section class="text-gray-600 body-font">
        <div class="container px-5 py-24 mx-auto">
          <div class="flex flex-col text-center w-full mb-20">
            <h2 class="text-xs text-pink-500 tracking-widest font-medium title-font mb-1"></h2>
            <div class="text-4xl text-pink-500 fa-solid fa-pills"></div>
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Tools for <span class="text-pink-500">HPLC</span></h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base"></p>
            <div class="flex mt-6 justify-center">
              <div class="w-16 h-1 rounded-full bg-pink-500 inline-flex"></div>
            </div>
          </div>
          <div class="flex flex-wrap">
            <div class="xl:w-1/4 lg:w-1/2 md:w-full px-8 py-6 border-l-2 border-gray-200 border-opacity-60">
              <a href="{{ route('hplcRequest') }}" class="hover:border-b hover:border-pink-500 text-lg sm:text-xl text-gray-900 font-medium title-font mb-2">Register Data</a>
              <p class="leading-relaxed text-base my-3">You will request an AI to summarize the HPLC chromatogram (PNG data). Then, you can review, edit, and register the AI's response.</p>
              <a href="{{ route('hplcRequest') }}" class="text-pink-500 inline-flex items-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
                <p class="px-2 py-1 hover:rounded-lg hover:bg-pink-100">Go!</p>
              </a>
            </div>
            <div class="xl:w-1/4 lg:w-1/2 md:w-full px-8 py-6 border-l-2 border-gray-200 border-opacity-60">
              <a href="{{ route('hplcQuestion') }}" class="hover:border-b hover:border-pink-500 text-lg sm:text-xl text-gray-900 font-medium title-font mb-2">Ask AI a Question</a>
              <p class="leading-relaxed text-base my-3">Ask the AI for the information you want regarding the accumulated analysis data.</p>
              <a href="{{ route('hplcQuestion') }}" class="text-pink-500 inline-flex items-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
                <p class="px-2 py-1 hover:rounded-lg hover:bg-pink-100">Go!</p>
              </a>
            </div>
            <div class="xl:w-1/4 lg:w-1/2 md:w-full px-8 py-6 border-l-2 border-gray-200 border-opacity-60">
              <a href="{{ route('hplcMyPosts') }}" class="hover:border-b hover:border-pink-500 text-lg sm:text-xl text-gray-900 font-medium title-font mb-2">View My Posts</a>
              <p class="leading-relaxed text-base my-3">You can review the data you have registered. You can also delete the data after reviewing.</p>
              <a href="{{ route('hplcMyPosts') }}" class="text-pink-500 inline-flex items-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
                <p class="px-2 py-1 hover:rounded-lg hover:bg-pink-100">Go!</p>
              </a>
            </div>
            <div class="xl:w-1/4 lg:w-1/2 md:w-full px-8 py-6 border-l-2 border-gray-200 border-opacity-60">
              <a href="{{ route('hplcRecord') }}" class="hover:border-b hover:border-pink-500 text-lg sm:text-xl text-gray-900 font-medium title-font mb-2">Our Records</a>
              <p class="leading-relaxed text-base my-3">You can check the number of registrations by each laboratory and view the individual registration count for members of your laboratory.</p>
              <a href="{{ route('hplcRecord') }}" class="text-pink-500 inline-flex items-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                  <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
                <p class="px-2 py-1 hover:rounded-lg hover:bg-pink-100">Go!</p>
              </a>
            </div>
          </div>
        </div>
      </section>

</x-appHplc-layout>