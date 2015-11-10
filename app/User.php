<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract, HasRoleAndPermissionContract
{
    use Authenticatable, CanResetPassword, HasRoleAndPermission;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function applications(){
        return $this->belongsToMany('App\Application')->withTimestamps();
    }

    /**
     * function to get the users role by app
     * @param int $app_id
     * @param string $operator
     * @return
     */
    public function getRolesByApp($app_id, $operator = '='){
        return $this
                ->roles()
                ->join('application_role', 'roles.id', $operator, 'application_role.role_id')
                ->where('application_role.application_id', '=', $app_id)->get();
    }


    /**function to check if 2 users are the same
     * @param User $user
     * @return bool
     */
    public function isEqual(User $user){
        return $this->id === $user->id;
    }




}
