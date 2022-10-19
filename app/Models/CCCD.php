<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use DB;
use Illuminate\Support\Facades\Storage;
class CCCD extends Model
{
    protected $fillable=['user_id','front_image_url','back_image_url'];

    public $table = "cccds";

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function getAllWithUserInfo(){
        return CCCD::orderBy('id','DESC')->with('user_info')->paginate(6);
    }

    public function deleteOtherRequestsFromThisUser($idUser,$idCCCD){
        $findRecord = Self::where('user_id', $idUser)->get();
        foreach ($findRecord as $image) {
            Storage::disk('s3')->delete($image->front_image_url);
            Storage::disk('s3')->delete($image->back_image_url);
        }
        return $findRecord->whereNotIn('id',$idCCCD)->each->delete();
    }
    public function user_info(){
        return $this->hasOne('App\User','id','user_id');
    }
    // (0) Unverify, (1) Approved, (2) Processing, (3) Rejected 

    public function approveUser($idUser){
        $user = User::findUser($idUser);
        return User::where('id',$user)->update(['id_verify' => config('status_verify.APPROVE')]);
    }
    public function processingUser($idUser){
        $user = User::findUser($idUser);
        return User::where('id',$user)->update(['id_verify' => config('status_verify.PROCESSING')]);
    }
    public function rejectUser($idUser,$idCCCD){
        $user       = User::findUser($idUser);
        $findRecord = Self::where('id',$idCCCD);
            Storage::disk('s3')->delete($findRecord->front_image_url);
            Storage::disk('s3')->delete($findRecord->back_image_url);
        $findRecord->delete();
        return User::where('id',$user)->update(['id_verify' => config('status_verify.REJECT')]);
    }
}
