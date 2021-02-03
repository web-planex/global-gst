<?php

namespace App\Http\Controllers\Globals;

use App\Models\Globals\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{
    public function __construct(){
          $this->middleware(['auth','verified']);
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
        $data['custom_column'] = [
            'Title',
            'HSN Code',
            'SKU',
            'Purchase Price',
            'Sale Price'
        ];
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

    public function export_product(){
        $fields_key_array = array('title', 'description', 'hsn_code', 'sku', 'unit', 'price', 'sale_price');
        $fields_value_array = array('Title', 'Description', 'HSN/SAC_Code', 'SKU', 'Unit', 'Price', 'Sale_Price');
        $columns = $fields_value_array;
        $main_array = Product::with('User','Company')->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->get();
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $callback = function() use ($main_array, $columns, $fields_key_array)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach($main_array as $subarray) {
                $data   =  array_merge(array_flip($fields_key_array), array_filter(array(
                    'title' => $subarray['title'],
                    'description' => $subarray['description'],
                    'hsn_code' => $subarray['hsn_code'],
                    'sku' => $subarray['sku'],
                    'unit' => $subarray['unit'],
                    'price' => $subarray['price'],
                    'sale_price' => $subarray['sale_price'],
                ),
                function ($key) use ($fields_key_array) {
                    return in_array($key, $fields_key_array);
                }, ARRAY_FILTER_USE_KEY));
                fputcsv($file, $data);
            }
            fclose($file);
        };
        return Response::stream($callback, 200, $headers);
    }

    public function import_product(Request $request){
        $arrResult  = array();
        $file = $request->file('import_csv');
        if (($handle = fopen($file, "r")) !== FALSE) {
            $count = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $count++;
                if($count!=1){
                    $arrResult[] = $data;
                }
            }
            fclose($handle);
        }

        for ($i=0; $i<count($arrResult); $i++){
            $old_product = Product::where('title',$arrResult[$i][0])->where('user_id',Auth::user()->id)->where('company_id',$this->Company())->first();
            if(empty($old_product)){
                if(!empty($arrResult[$i][0])){
                    $input['user_id'] = Auth::user()->id;
                    $input['company_id'] = $this->Company();
                    $input['title'] = $arrResult[$i][0];
                    $input['description'] = $arrResult[$i][1];
                    $input['hsn_code'] = $arrResult[$i][2];
                    $input['sku'] = $arrResult[$i][3];
                    $input['unit'] = $arrResult[$i][4];
                    $input['price'] = $arrResult[$i][5];
                    $input['sale_price'] = $arrResult[$i][6];
                    Product::create($input);
                }
            }
        }
        return ;
    }
}