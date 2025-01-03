<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-1 flex justify-between">
                <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block px-2 rounded text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    {{ __('新增紀錄') }}
                </button>

                @if (Session::has('message'))
                    <span class="w-1/3 rounded shadow-xl text-center text-gray-600 font-semibold bg-teal-400">{{ Session::get('message') }}</span>
                @elseif ($errors->any())
                    <span class="w-1/3 rounded shadow-xl text-center text-white text-sm font-semibold bg-red-900">{{ __('無效操作 請重新嘗試') }}</span>
                @endif

                <div></div>
            </div>

            <div class="max-w-screen overflow-x-auto">
                <table class="table-fixed border border-slate-300 w-full">
                    <thead>
                        <tr>
                            <th class="border-b border-slate-300 w-20">
                                {{ __('名稱') }}
                                <br>
                                <form method="GET" action="{{ url()->current() }}" class="inline-block">
                                    <input type="text" name="name_search" value="{{ request('name_search') }}" placeholder="搜尋名稱" class="mt-1 p-1 border rounded w-full" onchange="this.form.submit()">
                                </form>
                            </th>
                            <th class="border-b border-slate-300 w-28">{{ __('學名') }}</th>
                            <th class="border-b border-slate-300 w-20">@sortablelink('famname', '科名')</th>
                            <th class="border-b border-slate-300 w-20">@sortablelink('genname', '屬名')</th>
                            <th class="border-b border-slate-300 w-24">{{ __('別名') }}</th>
                            <th class="border-b border-slate-300 w-20">@sortablelink('type', '型態')</th>
                            <th class="border-b border-slate-300 w-24">{{ __('藥用部位') }}</th>
                            <th class="border-b border-slate-300 w-28">{{ __('功效') }}</th>
                            <th class="border-b border-slate-300 w-20">@sortablelink('area', '區域')</th>
                            <th class="border-b border-slate-300 w-16"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($records as $record)
                            <tr>
                                <td class="text-center border-b border-slate-300">{{ $record->name }}</td>
                                <td class="text-center border-b border-slate-300">{{ $record->sciname }}</td>
                                <td class="text-center border-b border-slate-300">{{ $record->famname }}</td>
                                <td class="text-center border-b border-slate-300">{{ $record->genname }}</td>
                                <td class="text-center border-b border-slate-300">{{ $record->alias }}</td>
                                <td class="text-center border-b border-slate-300">{{ $record->type }}</td>
                                <td class="text-center border-b border-slate-300">{{ $record->medparts }}</td>
                                <td class="text-center border-b border-slate-300">{{ $record->effect }}</td>
                                <td class="text-center border-b border-slate-300">{{ $record->area }}</td>
                                <td class="text-center border-b border-slate-300">
                                    <button data-modal-target="edit-modal-{{ $record->id }}" data-modal-toggle="edit-modal-{{ $record->id }}" class="m-1 px-2 rounded text-white bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        {{ __('編輯') }}
                                    </button>
                                    <button data-modal-target="popup-modal-{{ $record->id }}" data-modal-toggle="popup-modal-{{ $record->id }}" class="m-1 px-2 rounded text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        {{ __('刪除') }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {!! $records->appends(request()->except('page'))->render() !!}
            {{-- {{ $records->onEachSide(3)->links() }} --}}
        </div>
    </div>

    {{-- 新增視窗 --}}
    <div id="crud-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            {{-- Modal content --}}
            <div class="relative bg-white rounded-lg shadow">
                {{-- Modal header --}}
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-300 rounded-t">
                    <h3 class="text-lg font-semibold text-gray-900">
                        {{ __('新增資料') }}
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">{{ __('關閉') }}</span>
                    </button>
                </div>
                {{-- Modal body --}}
                <form class="p-4 md:p-5" action="{{ route('herbhome.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">{{ __('名稱') }}<label class="text-red-600">{{ __('*') }}</label></label>
                            <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            @error('name')
                                <span class="text-sm text-red-600">{{ __('請輸入名稱') }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="sciname" class="block mb-2 text-sm font-medium text-gray-900">{{ __('學名') }}<label class="text-red-600">{{ __('*') }}</label></label>
                            <input type="text" id="sciname" name="sciname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            @error('sciname')
                                <span class="text-sm text-red-600">{{ __('請輸入學名') }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="famname" class="block mb-2 text-sm font-medium text-gray-900">{{ __('科名') }}<label class="text-red-600">{{ __('*') }}</label></label>
                            <input type="text" id="famname" name="famname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            @error('famname')
                                <span class="text-sm text-red-600">{{ __('請輸入科名') }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="genname" class="block mb-2 text-sm font-medium text-gray-900">{{ __('屬名') }}<label class="text-red-600">{{ __('*') }}</label></label>
                            <input type="text" id="genname" name="genname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            @error('genname')
                                <span class="text-sm text-red-600">{{ __('請輸入屬名') }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="alias" class="block mb-2 text-sm font-medium text-gray-900">{{ __('別名') }}</label>
                            <input type="text" id="alias" name="alias" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            @error('alias')
                                <span class="text-sm text-red-600">{{ __('請輸入別名') }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900">{{ __('型態') }}<label class="text-red-600">{{ __('*') }}</label></label>
                            <input type="text" id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            @error('type')
                                <span class="text-sm text-red-600">{{ __('請輸入型態') }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="medparts" class="block mb-2 text-sm font-medium text-gray-900">{{ __('藥用部位') }}</label>
                            <input type="text" id="medparts" name="medparts" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            @error('medparts')
                                <span class="text-sm text-red-600">{{ __('請輸入藥用部位') }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="effect" class="block mb-2 text-sm font-medium text-gray-900">{{ __('功效') }}</label>
                            <input type="text" id="effect" name="effect" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            @error('effect')
                                <span class="text-sm text-red-600">{{ __('請輸入功效') }}</span>
                            @enderror
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="area" class="block mb-2 text-sm font-medium text-gray-900">{{ __('區域') }}</label>
                            <input type="text" id="area" name="area" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                            
                            <!-- Dropdown menu -->
                            <div id="dropdownSearch" class="absolute z-10 hidden bg-white rounded-lg shadow w-60">
                                <div class="p-3">
                                    <label for="input-group-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="text" id="input-group-search" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                                    </div>
                                </div>
                                <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700" aria-labelledby="area">

                                </ul>
                            </div>
                            
                            @error('area')
                                <span class="text-sm text-red-600">{{ __('請輸入區域') }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="px-2 rounded text-white inline-flex bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 group-invalid:pointer-events-none group-invalid:opacity-30">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        {{ __('確認新增') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- 編輯視窗 --}}
    @foreach ($records as $record)
        <div id="edit-modal-{{ $record->id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                {{-- Modal content --}}
                <div class="relative bg-white rounded-lg shadow">
                    {{-- Modal header --}}
                    <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-300 rounded-t">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ __('編輯資料') }}
                        </h3>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-toggle="edit-modal-{{ $record->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">{{ __('關閉') }}</span>
                        </button>
                    </div>
                    {{-- Modal body --}}
                    <form class="p-4 md:p-5" action="{{ route('herbhome.update', $record->id) }}" method="POST">
                        @csrf
                        @method('patch')
                        
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('名稱') }}<label class="text-red-600">{{ __('*') }}</label></label>
                                <input type="text" id="name-{{ $record->id }}" name="name" value="{{ $record->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                @error('name')
                                    <span class="text-sm text-red-600">{{ __('請輸入名稱') }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="sciname-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('學名') }}<label class="text-red-600">{{ __('*') }}</label></label>
                                <input type="text" id="sciname-{{ $record->id }}" name="sciname" value="{{ $record->sciname }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                @error('sciname')
                                    <span class="text-sm text-red-600">{{ __('請輸入學名') }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="famname-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('科名') }}<label class="text-red-600">{{ __('*') }}</label></label>
                                <input type="text" id="famname-{{ $record->id }}" name="famname" value="{{ $record->famname }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                @error('famname')
                                    <span class="text-sm text-red-600">{{ __('請輸入科名') }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="genname-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('屬名') }}<label class="text-red-600">{{ __('*') }}</label></label>
                                <input type="text" id="genname-{{ $record->id }}" name="genname" value="{{ $record->genname }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                @error('genname')
                                    <span class="text-sm text-red-600">{{ __('請輸入屬名') }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="alias-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('別名') }}</label>
                                <input type="text" id="alias-{{ $record->id }}" name="alias" value="{{ $record->alias }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                @error('alias')
                                    <span class="text-sm text-red-600">{{ __('請輸入別名') }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="type-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('型態') }}<label class="text-red-600">{{ __('*') }}</label></label>
                                <input type="text" id="type-{{ $record->id }}" name="type" value="{{ $record->type }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                @error('type')
                                    <span class="text-sm text-red-600">{{ __('請輸入型態') }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="medparts-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('藥用部位') }}</label>
                                <input type="text" id="medparts-{{ $record->id }}" name="medparts" value="{{ $record->medparts }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                @error('medparts')
                                    <span class="text-sm text-red-600">{{ __('請輸入藥用部位') }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="effect-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('功效') }}</label>
                                <input type="text" id="effect-{{ $record->id }}" name="effect" value="{{ $record->effect }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                @error('effect')
                                    <span class="text-sm text-red-600">{{ __('請輸入功效') }}</span>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="area-{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900">{{ __('區域') }}</label>
                                <input type="text" id="area-{{ $record->id }}" name="area" value="{{ $record->area }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full">
                                
                                <div id="dropdownSearch-{{ $record->id }}" class="absolute z-10 hidden bg-white rounded-lg shadow w-60">
                                    <div class="p-3">
                                        <label for="input-group-search-{{ $record->id }}" class="sr-only">Search</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                                </svg>
                                            </div>
                                            <input type="text" id="input-group-search-{{ $record->id }}" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search">
                                        </div>
                                    </div>
                                    <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700" aria-labelledby="area-{{ $record->id }}">
                                        
                                    </ul>
                                </div>
                                
                                @error('area')
                                    <span class="text-sm text-red-600">{{ __('請輸入區域') }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-2 rounded text-white inline-flex bg-orange-500 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                {{ __('確認編輯') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- 刪除視窗 --}}
    @foreach ($records as $record)
        <div id="popup-modal-{{ $record->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow">
                    <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="popup-modal-{{ $record->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">{{ __('關閉') }}</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500">{{ __('確認刪除該筆紀錄?') }}</h3>

                        <div class="flex justify-center">
                            <form action="{{ route('herbhome.destroy', $record->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="px-2 mx-2 rounded text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                    {{ __('確認') }}
                                </button>
                            </form>

                            <button data-modal-hide="popup-modal-{{ $record->id }}" type="button" class="px-2 mx-2 rounded text-gray-900 bg-white focus:outline-none border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">
                                {{ __('取消') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('[id^="area"]');
            const menus = document.querySelectorAll('[id^="dropdownSearch"]');
            const searchFields = document.querySelectorAll('[id^="input-group-search"]');
            
            const options = [
                '蕨類區',
                '有毒植物區',
                '香藥草區-東方藥圃區',
                '香藥草區-歐式藥園區',
                '香藥草區-清冠一號區',
                '水生植物區',
                '蔬果區',
                '喬木區',
                '灌木區',
                '花卉區',
                '茶區',
                '斜坡區',
            ];

            // Function to init dropdown options
            function initOptions() {
                menus.forEach(menu => {
                    let html = '';
                    const list = menu.querySelector('ul');
                    options.forEach(option => html += `
                        <li>
                            <div class="flex items-center ps-2 rounded hover:bg-gray-100">
                                <label class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded">${option}</label>
                            </div>
                        </li>
                    `);
                    list.innerHTML = html;
                });
            }

            // Function to populate the dropdown with options
            function populateDropdown(filteredOptions, index) {
                const list = menus[index].querySelector('ul');
                list.innerHTML = filteredOptions.map(option => `
                    <li>
                        <div class="flex items-center ps-2 rounded hover:bg-gray-100">
                            <label class="w-full py-2 ms-2 text-sm font-medium text-gray-900 rounded">${option}</label>
                        </div>
                    </li>
                `).join('');
            }

            // Function to filter options based on input
            function filterOptions(searchField, index) {
                const searchTerm = searchField.value.toLowerCase();
                const filteredOptions = options.filter(option => option.toLowerCase().includes(searchTerm));
                populateDropdown(filteredOptions, index);
            }

            function showMenu(index) {
                menus.forEach((menu, idx) => {
                    menu.style.display = idx === index ? 'block' : 'none';
                });
            }

            function hideAllMenus() {
                menus.forEach(menu => menu.style.display = 'none');
            }

            // Init dropdown options
            initOptions();

            inputs.forEach((input, index) => {
                input.addEventListener('focus', () => {
                    showMenu(index);
                });
            });

            searchFields.forEach((searchField, index) => {
                searchField.addEventListener('focus', () => {
                    showMenu(index);
                });

                searchField.addEventListener('input', () => {
                    filterOptions(searchField, index);
                });
            });

            menus.forEach((menu, index) => {
                menu.addEventListener('click', (event) => {
                    if (event.target.tagName === 'LABEL') {
                        inputs[index].value = event.target.textContent;
                        hideAllMenus();
                    }
                });
            });

            document.addEventListener('click', (event) => {
                const isClickInsideMenu = Array.from(menus).some(menu => menu.contains(event.target));
                const isClickInsideInput = Array.from(inputs).some(input => input.contains(event.target));
                const isClickInsideSearchField = Array.from(searchFields).some(searchField => searchField.contains(event.target));

                if (!isClickInsideMenu && !isClickInsideInput && !isClickInsideSearchField) {
                    hideAllMenus();
                }
            });
        });
    </script>
</x-app-layout>
