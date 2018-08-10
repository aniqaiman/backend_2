<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Http\Request;
use Redirect;
use Session;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createGroup(Request $request)
    {
        if ($request->ajax()) {
            return response(Group::create($request->all()));
        }
    }

    public function getGroup()
    {
        $groups = Group::all();
        $users = User::all();
        return view('group.group', compact('groups', 'users'));
    }

    public function editGroup($group_id, Request $request)
    {
        $groups = Group::where('group_id', $request->group_id)->first();
        return view('group.editGroup', compact('groups'));
    }

    public function updateGroup(Request $request)
    {
        if ($request->ajax()) {
            $groups = Group::where('group_id', $request->group_id)->first();
            $groups->group_name = $request->group_name;
            $groups->save();
            return response($groups);
        }
    }

    public function deleteGroup($group_id, Request $request)
    {
        $groups = Group::find($group_id);
        $groups->delete();
        Session::flash('message', 'Successfully deleted!');
        return Redirect::to('group');
    }
}
