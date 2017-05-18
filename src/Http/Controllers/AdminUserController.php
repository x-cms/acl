<?php

namespace Xcms\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Xcms\Acl\Models\AdminRole;
use Xcms\Acl\Models\AdminUser;
use Xcms\Base\Http\Controllers\SystemController;

class AdminUserController extends SystemController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function (Request $request, $next) {

            menu()->setActiveItem('users');

            $this->breadcrumbs
                ->addLink('权限管理')
                ->addLink('管理员', route('admin.users.index'));

            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            return AdminUser::all()->toJson();
        }

        $this->setPageTitle('管理员列表');

        return view('acl::users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('新增管理员');
        $roles = AdminRole::all();

        return view('acl::users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = new AdminUser();
        $admin->username = $request->username;
        $admin->password = bcrypt($request->password);
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->save();

        $result = $admin->assignRole($request->roles);
        if ($result) {
            return redirect()->route('admin.users.index')->with('success_msg', '添加管理员成功');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = AdminUser::find($id);
        $roles = AdminRole::all();
        $user->roles = $user->roles()->allRelatedIds()->toArray();

        return view('acl::users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $admin = AdminUser::find($id);
        $admin->username = $request->username;
        $admin->password = bcrypt($request->password);
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->save();

        $result = $admin->assignRole($request->roles);

        if ($result) {
            return redirect()->route('admin.users.index')->with('success_msg', '添加管理员成功');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        $user = AdminUser::find($id);
        $user->revokeAllRoles;
        $user->destroy($id);
        return ['code' => 200, 'message' => '删除标签成功'];
    }

    public function updateStatus($id, $status)
    {
        //
    }

}
