<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CCCD;
use App\User;
class CCCDController extends Controller
{
    private $cccd;
    private $user;
    public function __construct(CCCD $cccd,User $user)
    {
        $this->cccd = $cccd;
        $this->user = $user;
    }
    public function index()
    {
        $users = $this->user->getAllProcessingdUser();
        // return $users;
        return view('backend.cccd.index', compact('users'));
    }
    public function approveUser(Request $request)
    {
        try {
            $idUserApprove = $request->only('idUserApprove');
            $idCCCDApprove = $request->only('idCCCDApprove');
            $status = $this->cccd->approveUser($idUserApprove);
            if($status){
                 toast('This user has been approved','success');
                 $this->cccd->deleteOtherRequestsFromThisUser($idUserApprove,$idCCCDApprove);
             }
            return redirect()->back();
        } catch (\Throwable $th) {
            return $this->index();
        }
       
    }
    
    public function deleteAllRequestsRejected(){

    }
    public function rejectUser(Request $request)
    {
        $idUser = $request->only('idUserReject');
        $idCCCD = $request->only('idCCCDApprove');
        $status = $this->cccd->rejectUser($idUser,$idCCCD);
        if($status){
            toast('This user has been rejected','success');
        }
        return redirect()->back();
    }
}
