<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $user;
    public $role;
    public function __construct(User $user, Role $role)
    {
        $this->role = $role;
        $this->user = $user;
    }
    public function index()
    {
        $users = DB::table('users')
            ->join('images', 'images.imageable_id', '=', 'users.id')
            ->select('users.*', 'images.url as image_path')
              ->paginate(5);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->role->all()->groupBy('group');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required|min:3',
            'phone'=>'required',
            'image' => 'required|image',
            'gender'=>'required',
            'address'=>'required',
            'role_ids'=>'required',
        ],
           [
               'name.required'=>'Tên không được để trống',
                'email.required'=>'Email không được để trống',
                'email.unique'=>'Email đã tồn tại',
                'password.required'=>'Mật khẩu không được để trống',
                'password.min'=>'Mật khẩu phải lớn hơn 3 ký tự',
                'phone.required'=>'Số điện thoại không được để trống',
                'image.required'=>'Ảnh không được để trống',
               'gender.required'=>'Giới tính không được để trống',
                'address.required'=>'Địa chỉ không được để trống',
                'role_ids.required'=>'Vai trò không được để trống',
           ]
        );
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['image'] = $this->user->saveImage($request);
        $user = $this->user->create($data);
        $user->images()->create(['url' => $data['image']]);
        $user->roles()->attach($data['role_ids']);
        return redirect()->route('users.index')->with('success', 'Thêm mới thành công') ;
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
        $roles = $this->role->all()->groupBy('group');
        $user_img = $this->user->findOrFail($id)->images()->first();

        $user = $this->user->findOrFail($id)->load('roles');
        return view('admin.users.edit', compact('user', 'roles', 'user_img'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$id,
            'password'=>'required|min:3',
            'phone'=>'required',
            'address'=>'required',
            'role_ids'=>'required',
        ],
            [
                'name.required'=>'Tên không được để trống',
                'email.required'=>'Email không được để trống',
                'email.unique'=>'Email đã tồn tại',
                'password.required'=>'Mật khẩu không được để trống',
                'password.min'=>'Mật khẩu phải lớn hơn 3 ký tự',
                'phone.required'=>'Số điện thoại không được để trống',
                'address.required'=>'Địa chỉ không được để trống',
                'role_ids.required'=>'Vai trò không được để trống',
        ]);
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['image'] = $this->user->saveImage($request);
        $user = $this->user->findOrFail($id);
        $user->update($data);
        if($data['image'] != null){
            $user->images()->update(['url' => $data['image']]);
        }
        $user->roles()->sync($data['role_ids']);
        return redirect()->route('users.index')->with('success', 'Cập nhật thành công') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->user->findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa thành công') ;
    }
}
