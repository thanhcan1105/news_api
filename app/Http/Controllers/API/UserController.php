<?php

namespace App\Http\Controllers\API;

use JWTAuth;
use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Controllers\Controller;
use Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Arr;
use Hash;
use NextApps\VerificationCode\VerificationCode;
use Carbon\Carbon;

class UserController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function index()
    {
        $users = User::all();

        return response()->json($users, 200);
    }

    /**
     * @var bool
     */
    public $loginAfterSignUp = true;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public $token = true;
    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'string|required|max:30',
                'email' => 'string|required',
                'phone' => 'required|max:15',
                'cccd' => 'required|max:15',
                'password' => 'required',
                'status' => 'in:active,inactive',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $status = User::create($data);
            if ($this->token) {
                return $this->login($request);
            }
            return response()->json([
                'success' => true,
                'data' => $user
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Somethings went wrong! please try agian.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Email address/password do not match.',
            ], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ]);
    }
    public function logout(Request $request)
    {
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Somethings went wrong! please try agian.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getUser(Request $request)
    {
        $user = auth()->user();
        return response()->json(['user' => $user]);
    }
    public function sendOTPForgetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'string|required'
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        // try {
        $email =  $request->email;
        VerificationCode::send($email);
        return response()->json([
            'success' => true,
            'message' => 'Sent a verification code to this user.'
        ], Response::HTTP_OK);
        // } catch (\Throwable $th) {
        // return response()->json([
        //     'success' => false,
        //     'message' => 'Somethings went wrong! please try agian.'
        // ], Response::HTTP_INTERNAL_SERVER_ERROR);
        // }
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => 'numeric|min:6',
                'email' => 'string|required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $code       = $request->code;
        $email      = $request->email;
        $status     = VerificationCode::verify($code, $email);
        if ($status) {
            return response()->json([
                'success' => true,
                'message' => 'Code correct!'
            ], Response::HTTP_OK);
        } else {
            // return $this->responseError($status, Response::HTTP_FORBIDDEN);
            return response()->json(['success' => false, 'msg' => 'Code wrong!'], Response::HTTP_FORBIDDEN);
        }
    }

    public function verifyOTPForgetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'string|required',
                'new_password' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            $code       = $request->code;
            $email      = $request->email;
            $password   = Hash::make($request->new_password);
            $status     = VerificationCode::verify($code, $email);
            if (true) {
                $this->user->where('email', $email)
                    ->update([
                        'password' => $password,
                    ]);
                return response()->json([
                    'success' => true,
                    'message' => 'The new password has been updated successfully'
                ], Response::HTTP_OK);
            } else {
                // return $this->responseError($status, Response::HTTP_FORBIDDEN);
                return response()->json(['msg' => 'Code wrong!'], Response::HTTP_FORBIDDEN);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Somethings went wrong! please try agian.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCollab(Request $request)
    {
        $collab = User::where('user_collab', auth()->user()->id)->get();
        return response()->json(['collab' => $collab]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function updateUser(Request $request, $id)
    // {
    //     $validator = Validator::make($request->all(), 
    //     [ 
    //         'name'=>'string|required|max:30',
    //         'email'=>'string|required',
    //         'phone'=>'required|max:15',
    //         'cccd'=>'required|max:15',
    //         'password'=>'required',
    //         'status'=>'in:active,inactive',

    //     ]);
    //     if ($validator->fails()) {  
    //         return response()->json(['error'=>$validator->errors()], 401); 
    //     }  
    //     $data = $request->all();
    //     if(!empty($input['password'])) { 
    //         $data['password'] = Hash::make($data['password']);
    //     }else {
    //         $data = Arr::except($data, array('password'));    
    //     }
    //     $user = User::findOrFail($id);   
    //     $status = $user->update($data);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'User update successfully',
    //         'data' => $user
    //     ], Response::HTTP_OK);
    // }
    // public function deleteUser(Request $request, $id)
    // {
    //     $res = User::where('id',$id)->delete();
    //     if($res){
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'User delete successfully'
    //         ], Response::HTTP_OK);
    //     }else{
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Somethings went wrong! please try agian.'
    //             ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     } 
    // }

}
