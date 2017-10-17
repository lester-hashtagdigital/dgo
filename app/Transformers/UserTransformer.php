<?php
/**
 * Created by PhpStorm.
 * User: raymund
 * Date: 10/17/17
 * Time: 10:48 PM
 */
namespace App\Transformers;

use App\User;

class UserTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'username' => $user->username,
            'avatar' => $user->avatar(),
        ];
    }
}