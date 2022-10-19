<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Http;
use Carbon;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $arr = [
            'start' => $request->start .' 00:00:00',
            'end' => $request->end .' 23:59:59'
         ];
        if(request()->ajax()){
            if($request->start != "" and $request->start != "" and $request->phone == "") {
               
                $products=Product::with('comments')->whereBetween('created_at', [$arr['start'],$arr['end']])->paginate(20);
                 return view('backend.product.table', compact('products'));

            }elseif($request->start == "" and $request->start == "" and $request->phone != "") { 
                $products=Product::with('comments')->where('phone','LIKE','%'. $request->phone."%")->paginate(20);
                return view('backend.product.table', compact('products'));
            }elseif($request->start != "" and $request->start != "" and $request->phone != "") { 
                $products=Product::with('comments')
                ->whereBetween('created_at', [$arr['start'],$arr['end']])
                ->where('phone','LIKE','%'. $request->phone."%")
                ->paginate(20);
                return view('backend.product.table', compact('products'));
            }else{
                $products=Product::with('comments')->orderBy('id','desc')->paginate(20);
                return view('backend.product.table', compact('products'));
            } 
        }
        $products=Product::with('comments')->orderBy('id','desc')->paginate(20);
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.product.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)

    {
        $this->validate($request,
        [
            'name'=>'string|required|max:255',
            'phone'=>'required|max:255',
            'select1'=>'string|required|max:255',
            'link'=>'string|required|max:255',
            
            'current_group_id'=>'numeric|required',
            'source'=>'required|string|max:200',
            'campaign'=>'required|string|max:200',
            'str_source_group'=>'required|string|max:200',
            'str_secondary_source'=>'required|string|max:200',
        ]);
        $data = $request->all();
        $mytime = Carbon\Carbon::now('Asia/Ho_Chi_Minh');
        $transaction_id = date_format($mytime,"YmdHis");
        $reference_id = rand(1000, 9999).str_pad($request->phone, 3, STR_PAD_LEFT);
        $data['reference_id'] = $reference_id;
        $data['transaction_id'] = "F88_" . $transaction_id;
        $status = Product::create($data);
        $insertedId = $status->id;
        $product=Product::findOrFail($insertedId);
        if($product){
            $url = 'https://pol.f88.vn/pol/api/affilate/add_new/array';
            $data_post = [
                "name" => $product->name,
                "phone" => $product->phone,
                "select1" => $product->select1,
                "link" => $product->link,
                "TransactionID" => $product->transaction_id,
                "ReferenceType" => $product->reference_type,
                "ReferenceID" => $product->reference_id,
                "CurrentGroupID" => $product->current_group_id,
                "Source" => $product->source,
                "Campaign" => $product->campaign,
                "str_source_group" => $product->str_source_group,
                "str_secondary_source" => $product->str_secondary_source,
                "isDigital" => $product->isdigital,
            ];
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->post($url , ["data" => [$data_post]]);
        }
        if($status){
            request()->session()->flash('success','Thêm mới thành công');
        }
        else{
            request()->session()->flash('error','Có lỗi xảy ra vui lòng thử lại');
        }
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getExcelView(){
        return view('backend.product.excel');
    }
    public function import(Request $request) 
    {
        $import = \Excel::import(new ProductsImport, $request->file('productfile'));
        return redirect()->back()->with('success', 'Success!!!');
    }
    public function export() 
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

}
