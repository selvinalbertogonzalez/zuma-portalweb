<?php

namespace App\Policies;

use App\User;
use App\ZumaUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ZumaUserPolicy {
    use HandlesAuthorization;

    public function update(User $user, ZumaUser $zumaUser) {
        return false; //$user->type == 'editor';
    }

    public function view(User $user, ZumaUser $zumaUser) {
        return true; //$user->type == 'editor';
    }

    public function viewAny(User $User) {
        return true;
    }
}
