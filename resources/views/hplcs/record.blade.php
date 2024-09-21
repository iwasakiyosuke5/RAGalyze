<x-appHplc-layout>
    <section class="text-gray-600 body-font">
        <div class="container px-3 py-12 mx-auto">

            <div>
                <div>
                    <div class="flex flex-wrap w-full mb-10">
                        <div class="lg:w-1/3 w-full mb-6 lg:mb-0 lg:my-10">
                          <h1 class="sm:text-4xl text-2xl font-medium title-font px-2 mb-2 text-gray-900"><span class="text-pink-500 font-bold">O</span>ur Records</h1>
                          <div class="h-1 w-20 bg-pink-500 rounded ml-2"></div>
                        </div>
                        <div class="lg:w-2/3 w-full grid place-items-center">
                            <p class="px-auto text-lg leading-relaxed text-gray-500">On this page, you can track your HPLC analysis data with ease: 
                                <br><span class="pl-3">1. Your most recent AI queries, this might help you when you ask!</span>
                                <br><span class="pl-3">2. Annual registration stats by Lab/Institute,</span>
                                <br><span class="pl-3">3. Contributions by lab members. (MGs can also see other Lab.)</span>
                            <br>Currently, the database holds <span class="text-gray-700 font-bold">{{ $resultsCount }} entries</span>. Happy analyzing!</p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="xl:flex w-full">
                {{-- 左：Recent AI --}}
                <div class="xl:w-1/2 border-2 border-sky-500 mx-2 my-1 p-1 rounded-lg min-h-[36rem]">
                    <div>
                        <p class="text-xl mb-5">1. Recent AI Queries 30</p>
                    </div>
                    <div>
                        @if($recent30s->count())
                        <div class="text-rap overflow-x-auto">
                            <table class="min-w-full table-auto"> <!-- ここでテーブルを追加 -->
                                <thead>
                                <tr class="text-sm text-center">
                                    <th class="font-semibold">User</th>
                                    <th class="font-semibold">Qeury</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($recent30s as $recent30)
                                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-sky-50' : 'bg-gray-50' }}">
                                    <td class="text-center border w-1/6 px-2 py-2 text-xs">{{ $recent30->user->name }} ({{ $recent30->user->department }}) </td>
                                    <td class="border px-4 py-2 text-xs">{{ $recent30->query }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table> <!-- テーブルの終了タグ -->

                            <div class="my-2">
                                {{ $recent30s->links('vendor.pagination.customRecord-tailwind') }}
                            </div>

                        </div>

                        @else
                            <p>No proposals found.</p>
                        @endif
                    </div>
                </div>

                {{-- 右 --}}
                <div class="xl:w-1/2">
                    {{-- 右上：Department毎 --}}
                    <div class="border-2 border-sky-500 mx-2 my-1 p-1 rounded-lg min-h-[18rem]">
                        <div>
                            <p class="text-xl mb-5">2. Annual Registration Stats For Lab</p>
                        </div>
                        <div class="flex text-rap overflow-x-auto">
                            <div class="w-1/2 mb-4 flex justify-center ">
                                <div class="mx-auto pt-4">
                                    <label for="yearSelect">Select Year:</label>
                                    <select class="rounded-lg border border-pink-500" id="yearSelect">
                                        @foreach($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="w-1/2 mb-4 mx-auto">
                                <table id="departmentTable" class="mx-5 table-auto">
                                    <thead>
                                        <tr class="text-sm text-center">
                                            <th class="font-semibold w-1/5 px-4 py-1">Lab</th>
                                            <th class="font-semibold w-1/5 px-4 py-1">Lab's Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Ajaxでデータが挿入される -->
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                        
                    </div>

                    {{-- 右下：Lab毎 --}}
                    <div class="border-2 border-sky-500 mx-2 my-1 p-1 rounded-lg min-h-[18rem]">
                        <div>
                            <p class="text-xl mb-5">3. Personal Stats In your Lab ({{ Auth::user()->department }})</p>
                            @if(Auth::user()->position == 'GL' || Auth::user()->position == 'GM')
                                <div class="ml-12">
                                    <label for="departmentSelect" class="">Select Lab:</label>
                                    <select id="departmentSelect" class="rounded-lg text-sm border border-pink-500" >
                                        <option value="{{ Auth::user()->department }}">Your Lab</option>
                                        @foreach($departments as $department)
                                            @if($department != Auth::user()->department)
                                                <option value="{{ $department }}">{{ $department }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="p-3">
                            <div class="flex text-rap">
                                <div class="w-full">
                                    <div class=" overflow-x-auto">
                                        <table id="personalStatsTable" class="table-auto w-full">
                                            <thead>
                                                <tr class="text-sm text-center">
                                                    <th class="px-12 py-2 sticky left-0 bg-gray-100">User</th>
                                                    <!-- 年ごとの列が生成される -->
                                                    @foreach($years as $year)
                                                        <th class="font-semibold px-10 py-1">{{ $year }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Ajaxでデータが挿入される -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        // 部署ごとの登録数を取得
        function loadDepartmentCount(year) {
            $.ajax({
                url: "{{ route('api.departmentCount') }}",
                method: 'GET',
                data: { year: year },
                success: function(data) {

                    $('#departmentTable tbody').empty();
                    $.each(Object.values(data.annuals), function(index, details) {
                        let rowClass = index % 2 == 1 ? 'bg-sky-50' : 'bg-gray-50';
                        console.log('Row index:', index);
                        $('#departmentTable tbody').append(
                            '<tr class="' + rowClass + ' text-center">' +
                                '<td class="border px-2 py-2 text-xs">' + details.department + '</td>' +
                                '<td class="border px-4 py-2 text-xs">' + details.count + '</td>' +
                            '</tr>'
                        );
                    });


                },
                error: function(xhr, status, error) {
                    console.error('Error fetching department data:', error);
                }
            });
        }

        // 所属部署のユーザーごとの投稿数を取得
        function loadPersonalStats(year, department) {
        $.ajax({
            url: "{{ route('api.personalStats') }}",
            method: 'GET',
            data: { year: year, department: department },
            success: function(data) {
                $('#personalStatsTable tbody').empty();
                $.each(data.userStats, function(index, user) {
                    let rowClass = index % 2 == 1 ? 'bg-sky-50' : 'bg-gray-50';
                    let row = '<tr class="' + rowClass + ' text-center">' +
                                '<td class="border px-2 py-2 text-xs sticky left-0 w-1/4 ' + rowClass + '">' + user.name + '</td>';
                    $.each(data.years, function(i, year) {
                        let count = user.posts[year] ? user.posts[year] : 0;
                        row += '<td class="border x-4 py-2 text-xs">' + count + '</td>';
                    });
                    row += '</tr>';
                    $('#personalStatsTable tbody').append(row);
                });
            }
        });
    }


        // 初期ロード時に現在の年のデータをロード
        let currentYear = new Date().getFullYear();
        loadDepartmentCount(currentYear);
        let currentDepartment = "{{ Auth::user()->department }}";
        loadPersonalStats(currentYear, currentDepartment);

        // 年の選択肢が変更された場合にデータを再ロード
        $('#yearSelect').change(function() {
            let selectedYear = $(this).val();
            loadDepartmentCount(selectedYear);
        });
        $('#departmentSelect').change(function() {
            let selectedDepartment = $(this).val();
            console.log('Selected Department:', selectedDepartment);
            loadPersonalStats(null, selectedDepartment);
        });
    });
</script>


</x-appHplc-layout>