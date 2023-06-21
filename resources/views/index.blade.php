
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
      <div class="select">
        <select name="company" id="company"  class="select-company" type="button" type="button">
          <option value="">All categories</option>
          @foreach($companies as $company)
          <option value="{{ $company->id }}">{{ $company->company_name }}</option>
          @endforeach
        </select>
        <div class="keyword">
            <input type="text" name="keyword" id="keyword" class="keyword-box" placeholder="Search here!">
            <button type="submit" aria-label="検索"></button>
        </div>
      </div>
    </form>
  </div>

  {{-- 新規登録ボタンとアラートスペース --}}
  <div class="container">
    <button onclick="location.href='./create'" class="btn">新規登録</button>
    <div class="alert">
      @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
      @endif
    </div>
  </div>

  {{-- 商品一覧テーブル --}}
  <div class="table-container" >
    <table class="table">
      <thead>
        <tr>
          <th scope="col" class="table-header">No.</th>
          <th scope="col" class="table-header">イメージ</th>
          <th scope="col" class="table-header">商品名</th>
          <th scope="col" class="table-header">価格</th>
          <th scope="col" class="table-header">在庫数</th>
          <th scope="col" class="table-header">メーカー</th>
          <th scope="col" class="table-header"></th>
          <th scope="col" class="table-header"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
          <tr class="table-row">
              <td class="table-data">{{ $product->id }}</td>
              <td class="table-data">
                <img width="50px" src="{{ asset('storage/image/' . $product->image_path) }}" />
              </td>
              <td class="table-data">{{ $product->product_name }}</td>
              <td class="table-data">{{ $product->price }}</td>
              <td class="table-data">{{ $product->stock }}</td>
              <td class="table-data">{{ $product->company->company_name }}</td>
              <td class="table-data">
                <button onclick="window.location.href='{{ route('show', ['id' => $product->id]) }}'">詳細</button>
              </td>
              <td class="table-data">
                <form method="post" action="{{ route('delete',['id' => $product->id]) }}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick='return confirm("削除しますか？");'>削除</button>
                </form>
              </td>
          </tr>
        @endforeach
        
      </tbody>
    </table>
      {{ $products->links() }}
  </div>
</x-app-layout>