<?php

namespace App\Http\Controllers\Globals;

use App\Models\Globals\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(){
          $this->middleware('auth');
      }
    
    public function index(Request $request){
        $data['menu'] = 'Products';
        $query = Product::where('user_id', Auth::user()->id)->where('company_id',$this->Company())->select();
        $search='';
        if(isset($request['search']) && !empty($request['search'])){
            $query->where(function ($q) use($request){
                    $q->orwhere('title','like','%'.$request['search'].'%');
                    $q->orwhere('price',$request['search']);
                    $q->orwhere('hsn_code','like','%'.$request['search'].'%');
                    $q->orwhere('sku','like','%'.$request['search'].'%');
            });
            $search = $request['search'];
        }
        $data['search'] = $search;
        $data['products'] =$query->Paginate($this->pagination);
        return view('globals.products.index',$data);
    }

    public function create(){
        $data['menu'] = 'Products';
        return view('globals.products.create',$data);
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'hsn_code' => 'required',
            'sku' => 'required',
            'price' => 'required',
            'sale_price' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $input['company_id'] = $this->Company();
        Product::create($input);
         \Session::flash('message', 'Product has been created successfully!');
        return redirect('products');
    }

    public function show($id){
        //
    }

    public function edit($id){
        $data['menu'] = 'Products';
        $data['products'] = Product::where('id',$id)->first();
        return view('globals.products.create',$data);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'title' => 'required',
            'hsn_code' => 'required',
            'sku' => 'required',
            'price' => 'required',
            'sale_price' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);
        
        $input = $request->all();
        $product = Product::where('id',$id)->first();
        $product->update($input);
         \Session::flash('message', 'Product has been updated successfully!');
        return redirect('products');
    }

    public function destroy($id){
        $product = Product::where('id',$id)->first();
        $product->delete();
        \Session::flash('error-message', 'Product has been deleted successfully!');
        return redirect('products');
    }
}
