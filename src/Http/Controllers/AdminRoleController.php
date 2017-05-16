<?php

namespace Xcms\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Xcms\Acl\Models\AdminPermission;
use Xcms\Acl\Models\AdminRole;
use Xcms\Base\Http\Controllers\SystemController;

class AdminRoleController extends SystemController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function (Request $request, $next) {

            menu()->setActiveItem('roles');

            $this->breadcrumbs
                ->addLink('权限管理')
                ->addLink('角色列表', route('admin.roles.index'));

            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|string
     */
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            return AdminRole::all()->toJson();
        }
        $this->setPageTitle('角色列表');
        return view('acl::roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->setPageTitle('创建角色');
        $this->breadcrumbs->addLink('创建角色');
        $permissions = AdminPermission::renderAsArray();

        return view('acl::roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = AdminRole::create($request->all());
        if($request){
            return redirect()->route('admin.roles.index')->with('success_msg', '添加角色成功');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->setPageTitle('编辑角色');
        $this->breadcrumbs->addLink('编辑角色');
        $role = AdminRole::find($id);
        return view('acl::roles.edit', compact('role'));
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
        $role = AdminRole::find($id);
        $result = $role->update($request->all());

        if($result){
            return redirect()->route('admin.roles.index')->with('success_msg', '更新角色成功');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AdminRole::destroy($id);
        return ['code' => 200, 'message' => '删除标签成功'];
    }
}
