<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



class ProductController extends Controller
{

    // 商品一覧画面
    public function index() {
        $product = new Product();
        $company = new Company();
        $products = $product->getAllDataWithCompany();
        $companies = $company->index();
        return view('index', ['products' => $products,'companies' => $companies]);        
    }
    
    // 検索機能
    public function search(Request $request) {
        $searchQuery = $request->input('keyword');
        $searchQuery2 = $request->input('company');
        DB::beginTransaction();

        try {
            $product = new Product();
            $company = new Company();
            $companies = $company->index();
            $products = $product->getSearchData($searchQuery, $searchQuery2);
            DB::commit();
        }catch (\Exception $e){
            DB::rollback();
            return back();
        }
        return view('index', ['products' => $products,'companies' => $companies]);  
    }

    // 新規登録画面の表示
    public function create() {
        $model = new Company();
        $companies = $model->index();
        return view('create', ['companies' => $companies]);
    }

    // 新規登録
    public function store(ProductRequest $request) {
        $data = $request->all();
        $image_path = $request->file('image_path');
        DB::beginTransaction();

        try {
            $model = new Product();
            $model->store($data, $image_path);
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            return back();
        }
        return redirect()->route('index')->with('success', '商品を登録しました。');
    }

    // 詳細画面の表示
    public function show ($id) {
        $model = new Product();
        $model2 = new Company();
        $product = $model->find($id);
        $companies = $model2->index();
            
        return view('show',['product' => $product, 'companies' => $companies]);
    }

    // 編集画面の表示
    public function edit ($id) {
        $model = new Product();
        $model2 = new Company();
        $product = $model->find($id);
        $companies = $model2->index();

        return view('edit',['product' => $product, 'companies' => $companies]);
        
    }

    // 更新
    public function update(ProductRequest $request, $id) {
        $data = $request->all();
        $image_path = $request->file('image_path');
        DB::beginTransaction();

        try {
            $model = new Product();
            $product = $model->find($id);
            $product->updateData($data, $image_path);
            // $oldImage = $model->delImage($id);
            // $model->delImage($id);
            // $edit = $product->find($product->id);
            // if ($request->hasFile('image_path')){
                
                // $original = $image_path->getClientOriginalName();
                // $name = date('Ymd_His').'_'.$original;
                // $image_path->move('storage/image', $name);
                // $this->image_path = $name;
            //     $path = $request->file('image_path')->store('public/image');
            //     $product->image_path = basename($path);
            // }
            $product->save();
            DB::commit();
        } catch (\Exception $e){
            dd($e->getMessage()); 
            // DB::rollback();
            // return back();
        }
        return redirect()->route('index')->with('success', '商品詳細を更新しました。');
    }

    // 削除
    public function destroy($id) {
        DB::beginTransaction();

        try {
            $model = new Product();
            $product = $model->find($id);
            $product->delete();
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            return back();
        }
        return redirect()->route('index')->with('success', '削除しました。');
    }
}
