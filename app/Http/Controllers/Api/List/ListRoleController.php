<?php

namespace App\Http\Controllers\Api\List;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class ListRoleController extends Controller
{
    public function listRole(){

        $role=Role::all();

        return response()->json(['roles'=>$role],200);
    }
}
