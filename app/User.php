<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Tymon\JWTAuth\Contracts\JWTSubject;
    use Spatie\Permission\Traits\HasRoles;
    class User extends Authenticatable implements JWTSubject
    {
        use Notifiable, HasRoles;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'name', 'email', 'password','status','cccd','phone'
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];
      
        public function cccds()
        {
            return $this->hasMany('App\Models\CCCD' ,'user_id', 'id');
        }

        public function latestCccds()
        {
            return $this->hasOne('App\Models\CCCD' ,'user_id', 'id')->latest();
        }
        public function getAllApprovedUser(){
            return Self::orderBy('id','DESC')
                ->where('id_verify',config('status_verify.APPROVE'))
                ->with('latestCccds')
                ->paginate(6);
        }
        public function getAllProcessingdUser(){
            return Self::orderBy('id','DESC')
                ->where('id_verify',config('status_verify.PROCESSING'))
                ->with('latestCccds')
                ->paginate(6);
        }
        public function getAllRejectedUser(){
            return Self::orderBy('id','DESC')
                ->where('id_verify',config('status_verify.REJECT'))
                ->with('latestCccds')
                ->paginate(6);
        }
        public static function findUser($idUser){
            $user = User::findOrFail($idUser)->pluck('id');
            return $user;
        }
        public static function checkStatusUser($idUser){
            $status = User::findOrFail($idUser)->pluck('id_verify')->first();
            return $status === config('status_verify.APPROVE') ? false : true;
        }
        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
    }
