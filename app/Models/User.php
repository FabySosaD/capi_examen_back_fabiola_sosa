<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'fecha_nacimiento',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * Relationship
     */
    public function user_domicilio()
    {
        return $this->hasOne('App\Models\UserDomicilio');
    }

    /**
     * Obtiene registro(s) de USERS de la base de datos mediante su ID.
     */
    public static function obtenerUsers($id = '') {
        $success = false;
        $result = [];
        $error = "";
        try {

            $result = DB::table("users AS u")
                    ->select(DB::raw("u.*, (YEAR(CURDATE())-YEAR(u.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(u.fecha_nacimiento,'%m-%d'), 0 , -1 )) as edad, ud.domicilio, ud.numero_exterior, ud.colonia, ud.cp, ud.ciudad"))
                    ->leftJoin("user_domicilios AS ud", "ud.user_id", "=", "u.id");

            if(!empty($id)) {
                $result = $result->where('u.id', '=', $id);
            }
            //echo $result->toSql().'<BR><BR>';
            $data = $result->get()->toArray();
            $success = true;
        }
        catch(Exeption $e)
        {
            $error = $e->getMessage();
        }

        $response = array();
        $response["success"] = $success;
        $response["message"] = $error;
        $response["data"]    = $success ? $data : [];

        return $response;
    }
}
