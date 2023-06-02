<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $products = Product::all();
        $companies = Company::all();

        return view('index', compact('products', 'companies'));
    }
    
    public function search(Request $request) {
        $keyword = $request->input('keyword');
        $companyId = $request->input('company');

        $query = Product::query();

        if ($keyword!=null) {
            $query->where('product_name', 'like', '%' .$keyword. '%');
        }

        if ($companyId!=null) {
            $query->where('company_id', $companyId);
        }

        $products = $query->get();
        $companies = Company::all();

        return view('index', compact('products', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        $companies = Company::all();
        return view('create')
        ->with('companies', $companies);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            'product_name' => 'required|max:20',
            'price' => 'required|min:0',
            'stock' => 'required|min:0',
            'image' => 'image'
        ]);

        if (request('image_path')) {
            $original = request()->file('image_path')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $file = request()->file('image_path')->move('storage/image', $name);
            $product->image_path=$name;
        }
        
        $product = new Product;
        $product->company_id = $request->input('company_id');
        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');
        
        $product->save();

        return redirect()->route('index')->with('success', '商品を登録しました。');
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show (Product $product) {
        $companies = Company::all();
        return view('show',compact('product'))
            ->with('companies',$companies);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit (Product $product) {
        $companies = Company::all();
        return view('edit',compact('product'))
            ->with('companies',$companies);

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update (Request $request, Product $product) {
        $request->validate ([
            'product_name' => 'required | max:20',
            'price' => 'required | min:0',
            'stock' => 'required | min:0',
            'comment' => 'required',
            'company_id' => 'required',   
        ]);
        $product->company_id = $request->input ('company_id');
        $product->product_name = $request->input ('product_name');
        $product->price = $request->input ('price');
        $product->stock = $request->input ('stock');
        $product->comment = $request->input ('comment');
        if (request('image_path')) {
            Storage::disk('public')->delete('$product->image_path');
            $original = request()->file('image_path')->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $product->image_path = request()->file('image_path')->move('storage/image', $name);
            $product->image_path=$name;
        }
        $product->save();
        return redirect()->route('index')->with('success', '商品詳細を変更しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('index')->with('success', $product->product_name.'を削除しました。');
    }
}
