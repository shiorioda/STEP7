
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品一覧
        </h2>
    </x-slot>
   
  {{-- 検索フォーム   --}}
  <div class="container">
    <form action="{{ route('search') }}" method="GET" enctype="multipart/form-data">  
      @csrf
        <select name="company" id="company" class="select-company" class=" hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700 dark:text-white dark:border-gray-600" type="button">All categories <svg aria-hidden="true" class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          <option value="">All categories</option>
          @foreach($companies as $company)
          <option name="" value="{{ $company->id }}">{{ $company->company_name }}</option>
          @endforeach
        </select>
        <div class="keyword" class="relative w-full">
            <input type="text" name="keyword" id="keyword" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-l-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Search here!">
            <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </div>
    </form>
  </div>


  <div class="container">
    <button onclick="location.href='./create'" class="button" class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
      新規登録
    </button>

    <div class="alert">
    @if (session('success'))
    <div class="alert alert-success p-4">
      {{ session('success') }}
    </div>
    @endif
  </div>
  </div>

  {{-- 商品一覧テーブル --}}
  <div class="table-container" class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="table-header" class="px-6 py-3">
                    No.
                </th>
                <th scope="col" class="table-header" class="px-6 py-3">
                  イメージ
                </th>
                <th scope="col" class="table-header" class="px-6 py-3">
                    商品名
                </th>
                <th scope="col" class="table-header" class="px-6 py-3">
                    価格
                </th>
                <th scope="col" class="table-header" class="px-6 py-3">
                    在庫数
                </th>
                <th scope="col" class="table-header" class="px-6 py-3">
                    メーカー
                </th>
                <th scope="col" class="table-header" class="px-6 py-3"></th>
                <th scope="col" class="table-header" class="px-6 py-3"> </th>
            </tr>
        </thead>
        <tbody>
          @foreach ($products as $product)
            <tr class="table-row" class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                <td class="table-data" class="px-6 py-4">
                  {{ $product->id }}
                </td>
                <td class="table-data" class="px-6 py-4">
                  <img width="50px" src="{{ asset('storage/image/' . $product->image_path) }}" />
                </td>
                <td class="table-data" class="px-6 py-4">
                  {{ $product->product_name }}
                </td>
                <td class="table-data" class="px-6 py-4">
                  {{ $product->price }}
                </td>
                <td class="table-data" class="px-6 py-4">
                  {{ $product->stock }}
                </td>
                <td class="table-data" class="px-6 py-4">
                  {{ $product->company->company_name }}
                </td>
                <td class="table-data" class="px-6 py-4">
                  <button class="table-button" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick="window.location.href='{{ route('show', $product->id) }}'">詳細</button>
                </td>
                <td class="table-data" class="px-6 py-4">
                  <form method="post" action="{{ route('delete',$product->id) }}">
                    @csrf
                    @method('DELETE')
                    <button class="table-button" type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" onclick='return confirm("削除しますか？");'>削除</button>
                  </form>
                </td>
            </tr>
          @endforeach
        </tbody>
    </table>
  </div>


</x-app-layout>