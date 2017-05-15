<?php

namespace Xcms\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Xcms\Acl\Models\AdminPermission;
use Xcms\Base\Http\Controllers\SystemController;

class AdminPermissionController extends SystemController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function (Request $request, $next) {

            menu()->setActiveItem('permissions');

            $this->breadcrumbs
                ->addLink('权限管理')
                ->addLink('权限列表', route('permissions.index'));

            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setPageTitle('权限列表');
        return view('acl::permissions.index');
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
        return view('acl::permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = AdminPermission::create($request->all());
        if($request){
            return redirect()->route('permissions.index')->with('success_msg', '添加权限成功');
        }
    }

    /**
     * Display the specified resource.
     *
     * @return string
     */
    public function ajax()
    {
        return AdminPermission::all()->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = AdminPermission::find($id);
        return view('acl::permissions.edit', compact('permission'));
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
        $permission = AdminPermission::find($id);
        $result = $permission->update($request->all());

        if($result){
            return redirect()->route('permissions.index')->with('success_msg', '更新权限成功');
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
        AdminPermission::destroy($id);
        return ['code' => 200, 'message' => '删除权限成功'];
    }
}
