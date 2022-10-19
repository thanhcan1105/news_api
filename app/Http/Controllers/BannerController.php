<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use Intervention\Image\ImageManagerStatic as Image;
class BannerController extends Controller
{
    private $banners;
    public function __construct(Banner $banners)
    {
        $this->banners = $banners;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = $this->banners->getAllBanner();
        return view('backend.banner.index', compact ('banners'));
        // return Storage::disk('s3')->url('test.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'image'=>'required',
        ]);
        if ($request->hasfile('image')) {
            $now        = \Carbon\Carbon::now('Asia/Ho_Chi_Minh');    
            $photo      = $request->file('image');
            $ext        = $photo->getClientOriginalExtension();
            $fileName   =  date_format($now,"YmdHis") . '.' . $ext;
            $image      = Image::make($photo->getRealPath());
            $image_url  = 'images/banners' . '/' . $fileName;
            \Storage::disk('s3')->put('images/banners' . '/' . $fileName,$image->encode(), 'public');
            $request->merge([
                'image_url' => $image_url,
            ]);
            $status = $this->banners->create($request->only('company_id', 'image_url','status'));
        }
        if($status){
            toast('New banner added','success');
        }
        else{
            alert()->error('Oops...', 'Something went wrong!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('backend.banner.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = $this->banners->findOrFail($id);
        $path   = $banner->image_url;
        $status = $banner->delete();
        Storage::disk('s3')->delete($path);
        if($status){
            toast('Delete successfully','success');
        }
        else{
            alert()->error('Oops...', 'Something went wrong!');
        }
        return redirect()->route('banners.index');
    }
}
