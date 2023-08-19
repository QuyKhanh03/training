<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permisson;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::query()->orderBy('id','desc')->paginate(3);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permisson::all()->groupBy('group');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name'],
            'display_name' => 'required',
            'group' => 'required',
        ],
        [
            'name.required' => 'Tên vai trò không được để trống',
            'display_name.required' => 'Tên hiển thị không được để trống',
            'name.unique' => 'Tên vai trò đã tồn tại',
            'group.required' => 'Nhóm quyền không được để trống',
        ]);
        $dataCreate = $request->all();
        $role = Role::create($dataCreate);

        foreach ($request->permission_ids as $permission) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $role->id,
                'permission_id' => $permission,
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Thêm mới vai trò thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permisson::all()->groupBy('group');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'unique:roles,name,'.$id],
            'display_name' => 'required',
            'group' => 'required',
        ],
        [
            'name.required' => 'Tên vai trò không được để trống',
            'display_name.required' => 'Tên hiển thị không được để trống',
            'name.unique' => 'Tên vai trò đã tồn tại',
            'group.required' => 'Nhóm quyền không được để trống',
        ]);
        $dataUpdate = $request->all();
        $role = Role::findOrFail($id);
        $role->update($dataUpdate);
        foreach ($request->permission_ids as $permission) {
            DB::table('role_has_permissions')->insert([
                'role_id' => $role->id,
                'permission_id' => $permission,
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Cập nhật vai trò thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Xóa vai trò thành công');
    }
}
