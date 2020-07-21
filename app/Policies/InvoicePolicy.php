<?php

namespace App\Policies;

use App\Invoice;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */

    public function before(User $user) {
        // This function runs first before the other policies. This allows the app to confirm that the signed in user is the Admin and then gives access to all methods in the Policy
        if ($user->email == env('ADMIN_EMAIL')) {

            return true;
        }
    }


    public function viewAny(User $user)
    {
        // Function not needed now that before function above is run first
        // return $user->email == env('ADMIN_EMAIL');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return mixed
     */
    public function view(?User $user, Invoice $invoice)
    {
        //Note optional type hint ? for user allows guest to pass the policy test
        //anybody can view their invoice without signing in
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // Function not needed now that before function above is run first
        // return $user->email == env('ADMIN_EMAIL');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return mixed
     */
    public function update(User $user, Invoice $invoice)
    {
        // Function not needed now that before function above is run first
        // return $user->email == env('ADMIN_EMAIL');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return mixed
     */
    public function delete(User $user, Invoice $invoice)
    {
        // Function not needed now that before function above is run first
        // return $user->email == env('ADMIN_EMAIL');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return mixed
     */
    public function restore(User $user, Invoice $invoice)
    {
        // Function not needed now that before function above is run first
        // return $user->email == env('ADMIN_EMAIL');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Invoice  $invoice
     * @return mixed
     */
    public function forceDelete(User $user, Invoice $invoice)
    {
        // Function not needed now that before function above is run first
        // return $user->email == env('ADMIN_EMAIL');
    }
}
