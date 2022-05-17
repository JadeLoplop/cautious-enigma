<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class UserRepository extends BaseRepository
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function store(array $attributes)
    {
        return $this->transaction(function () use ($attributes){
            $attributes['password'] = Hash::make($attributes['password']);
            $user = parent::store($attributes);
            return $user;
        });
    }

    public function updateProductImage(User $user, $image)
    {
        $this->transaction(function() use ($user, $image) {
            $base_url = URL::to('/');
            $image_path = $image->store('uploads/users', 'public');
            $user->photo = $base_url ."/storage/". $image_path;
            $user->save();
            return $user;
        });
    }

}
