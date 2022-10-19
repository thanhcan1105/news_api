<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CCCD;
use App\User;
use Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Intervention\Image\ImageManagerStatic as Image;
class CCCDController extends Controller
{
    private $cccd;
    public function __construct(CCCD $cccd)
    {
        $this->cccd = $cccd;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), 
            [ 
                'front_image_url' => 'required',
                'back_image_url' => 'required',
                'user_id' => 'required',    
            ]);  
            if ($validator->fails()) {  
                return response()->json(['error'=>$validator->errors()], 401); 
            }   
            if ($request->hasfile('front_image_url','back_image_url')) {
                $now                 = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');    
                //Front image
                $front_image_url     = $request->file('front_image_url');
                $F_ext               = $front_image_url->getClientOriginalExtension();
                $front_image_Name    =  date_format($now,"YmdHis"). '_' . 'front_CCCD_user' . '_' . $request->user_id . '.' . $F_ext;
                $F_image             = Image::make($front_image_url->getRealPath());
                $F_image_url         = 'images/cccds' . '/' . $front_image_Name;
                //Back image
                $back_image_url      = $request->file('back_image_url');
                $B_ext               = $back_image_url->getClientOriginalExtension();
                $back_image_Name     =  date_format($now,"YmdHis"). '_' . 'back_CCCD_user' . '_' . $request->user_id . '.' . $B_ext;
                $B_image             = Image::make($back_image_url->getRealPath());
                $B_image_url         = 'images/cccds' . '/' . $back_image_Name;
    
                \Storage::disk('s3')->put('images/cccds' . '/' . $front_image_Name,$F_image->encode(), 'public');
                \Storage::disk('s3')->put('images/cccds' . '/' . $back_image_Name,$B_image->encode(), 'public');

                $data = $request->only('user_id');
                $data['front_image_url'] = $F_image_url;
                $data['back_image_url']  = $B_image_url;
                $this->cccd->create($data);
                 // check if user approved then ignore
                $idUser = $request->only('user_id');
                if (User::checkStatusUser($idUser)){
                    // send processing request
                    $status = $this->cccd->processingUser($idUser);
                }
                return response()->json([
                    'code' => 200,
                    "name" => "Response OK",
                    "type" => "RESPONSE_OK",
                    "message" =>"success"
                ], Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                "name" => "Somethings went wrong! try agian.",
                "type" => "RESPONSE_FAILS",
                "message" =>"fails"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
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
        try {
            $image = $this->cccd->findOrFail($id);
            Storage::disk('s3')->delete($image->front_image_url);
            Storage::disk('s3')->delete($image->back_image_url);
            $image->delete();
            return response()->json([
                'code' => 200,
                "name" => "Response OK",
                "type" => "RESPONSE_OK",
                "message" =>"success"
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                "name" => "Somethings went wrong! try agian.",
                "type" => "RESPONSE_FAILS",
                "message" =>"fails"
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
