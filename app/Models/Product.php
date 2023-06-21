<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{    
    use HasFactory;
    protected $table = 'products' ;
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'image_path',
    ];

    public function company(){
        return $this->belongsTo(Company::class);
    }
    public function getAllDataWithCompany() {
        $products = $this->with('company')->paginate(5);
        return $products;
    }
    
    public function index() {
        $products = DB::table('products')->get();
        return $products;
    }

    public function getSearchData($searchQuery, $searchQuery2) {
        $products = Product::query();
        if (!empty($searchQuery)) {
            $products->where('product_name', 'like', '%' . $searchQuery . '%');
        }
        if (!empty($searchQuery2)) {
            $products->where('company_id',$searchQuery2);
        }
        return $products->get();
    }

    public function store($data, $image_path) {
        $this->product_name = $data['product_name'];
        $this->price = $data['price'];
        $this->comment = $data['comment'];
        $this->stock = $data['stock'];
        $this->company_id = $data['company_id'];

        if ($image_path) {
            $original = $image_path->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $image_path->move('storage/image', $name);
            $this->image_path=$name;
        }

        $this->save();
    }

    public function updateData($data, $image_path) {
        $this->product_name = $data['product_name'];
        $this->price = $data['price'];
        $this->comment = $data['comment'];
        $this->stock = $data['stock'];
        $this->company_id = $data['company_id'];

        if ($image_path) {
            $original = $image_path->getClientOriginalName();
            $name = date('Ymd_His').'_'.$original;
            $image_path->move('storage/image', $name);
            $this->image_path=$name;
        }
        $this->save();
    }

    public function delImage($delId)
{
    $delId = intval($delId);
    $delPath = '/public/image/' . $delId->image_path;
    
    if (Storage::exists($delPath)) {
        Storage::delete($delPath);
    }
}

    

}