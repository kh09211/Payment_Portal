<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use \App\Transaction;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user) {
        // A before function in a policy is run before any other policies. if returns true, then the user (an admin) is allowed all methods on the policy
        if ($user->email == config('app.ADMIN_EMAIL')) {

            return true;
        }
    }

    public function viewAny(User $user)
    {
        // No return needed since the before function handles this now
        // return $user->email == config('app.ADMIN_EMAIL');
    }

    public function view(User $user, Transaction $transaction)
    {
        // allow only the logged in user or the admin to view a transaction
        // rewritten to show that the before function handles the admin determination before this is ran
        // return ($user->email == config('app.ADMIN_EMAIL') || $user->id == $transaction->user_id);
        return ($user->id == $transaction->user_id);
    }
}
