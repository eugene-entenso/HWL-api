<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Validator;

/**
 * Class User
 * @package App
 *
 * @property array $errors
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $errors = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $rules = [
        'name' => 'required|max:32',
        'email' => 'required|unique:user|max:64',
        'password' => 'required|max:255',
    ];

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data)
    {
        $validator = Validator::make($data, $this->rules);
        if ($validator->fails())
        {
            $this->errors = $validator->errors()->toArray();
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

}
