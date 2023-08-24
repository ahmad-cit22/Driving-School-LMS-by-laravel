<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller {
    public function assign_role(Request $request) {
        $user = User::where('id', $request->user_id)->with('roles')->first();
        if (auth()->user()->roles->first()->id == 1 || ($user->id != auth()->user()->id && auth()->user()->roles->first()->id < $user->roles->first()->id && $request->role_id != 1)) {
            if ($request->role_id != 2) {
                $user->update([
                    'branch_id' => null
                ]);
            }
            $user->syncRoles($request->role_id);
            session()->flash('success', 'Role assigned successfully!');
        } else {
            session()->flash('error', 'Access denied!');
        }
    }
}
