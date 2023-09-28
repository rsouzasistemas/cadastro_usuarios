<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use mysql_xdevapi\Collection;

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
        'password' => 'hashed',
    ];

    public function userPhones() : HasMany
    {
        return $this->hasMany(UserPhone::class, 'user_id', 'id');
    }

    public function listUsers()
    {
        $fields = [
            'id',
            'name',
            'email'
        ];

        $listUsers = User::select($fields)->paginate();
        return $listUsers;
    }

    public function createUser ($data) : array
    {
        $routeReturn = 'users.index';
        $alert = 'alert-success';
        $msg = 'Registro criado com sucesso!';

        DB::beginTransaction();

        $dataUser = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ];

        if (!$newUser = self::create($dataUser)) {
            $routeReturn = 'users.create';
            $alert = 'alert-danger';
            $msg = 'Não foi possível criar o novo usuário!';
            DB::rollBack();
        }

        foreach ($data['phones'] as $keyPhone => $phone) {
            $userPhones = [
                'user_id' => $newUser->id,
                'phone_number' => $phone['phone']
            ];

            if (!UserPhone::create($userPhones)) {
                $routeReturn = 'users.create';
                $alert = 'alert-danger';
                $msg = 'Um telefone do novo usuário não pôde ser gravado!';
                DB::rollBack();
            }
        }

        DB::commit();
        return ['routeReturn' => $routeReturn, 'alert' => $alert, 'msg' => $msg];
    }

    public function updateUser($data, $user) : array
    {
        $routeReturn = 'users.index';
        $alert = 'alert-success';
        $msg = 'Registro atualizado com sucesso!';

        DB::beginTransaction();

        $dataUser = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ];

        if (!$user->update($dataUser)) {
            $routeReturn = 'users.edit';
            $alert = 'alert-danger';
            $msg = 'Não foi possível atualizar o usuário!';
            DB::rollBack();
        }

        if (!UserPhone::where('user_id', $user->id)->delete()) {
            $routeReturn = 'users.edit';
            $alert = 'alert-danger';
            $msg = 'Um telefone do novo usuário não pôde ser gravado!';
            DB::rollBack();
        }

        foreach ($data['phones'] as $keyPhone => $phone) {
            $userPhones = [
                'user_id' => $user->id,
                'phone_number' => $phone['phone']
            ];

            if (!UserPhone::create($userPhones)) {
                $routeReturn = 'users.create';
                $alert = 'alert-danger';
                $msg = 'Um telefone do novo usuário não pôde ser gravado!';
                DB::rollBack();
            }
        }

        DB::commit();
        return ['routeReturn' => $routeReturn, 'alert' => $alert, 'msg' => $msg];
    }
}
