<?php

namespace App\Policies;
use App\Models\Model;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class ModelPolicy
{ 
	use HandlesAuthorization;

    public function view(User $user, EloquentModel $model)
    {
        return true;
    }
}
