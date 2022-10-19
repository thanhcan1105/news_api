<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReturnPartner;
use App\Models\Product;
use App\Models\Comment;
use Validator;
use Symfony\Component\HttpFoundation\Response;
class F88APIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), 
            [ 
            'ReferenceId' => 'required|max:191',
            'F88Note' => 'required|max:191',
            'StatusF88' => 'required|max:191',  
            'loanMoneyOrg' => 'required|max:191',  
            'LastComment' => 'required|max:191',  
            
            ]);  
            if ($validator->fails()) {  
                return response()->json(['error'=>$validator->errors()], 401); 
            }   
            $data = new ReturnPartner();
            $data->referenceid = $request->ReferenceId;
            $data->f88note = $request->F88Note;
            $data->statusf88 = $request->StatusF88;
            $data->loanmoneyorg = $request->loanMoneyOrg;
            $data->lastcomment = $request->LastComment;
            $data->save();
            Product::where('transaction_id', $request->ReferenceId)
            ->update([
                'f88_note'=>$request->F88Note,
                'status_f88'=>$request->StatusF88,
                'loan_money_org'=>$request->loanMoneyOrg,
                ]);
            $id_product =  Product::where('transaction_id', $request->ReferenceId)->first()->id;
            $comments = new Comment();
            $comments->product_id = $id_product;
            $comments->comment =  $request->LastComment;
            $comments->save();
            return response()->json([
                'code' => 200,
                "name" => "ResponseOK",
                "type" => "RESPONSE_OK",
                "message" =>"success"
            ], Response::HTTP_OK);
           }catch (RequestException $ex) {
                abort(400, 'Vui lòng thử lại');
            }
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
}
