<?php

namespace Xcms\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Xcms\Acl\Models\Admin;
use Xcms\Base\Http\Controllers\SystemController;

class UserController extends SystemController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        $this->setPageTitle('管理员列表');
        $this->breadcrumbs->addLink('管理员');
        menu()->setActiveItem('users');

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
        menu()->setActiveItem('users');

        return view('acl::users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = new Admin();
        $result = $admin->create($request->all());
        if ($result) {
            return redirect()->route('users.index')->with('success_msg', '添加管理员成功');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        Admin::destroy($id);
        return ['code' => 200, 'message' => '删除标签成功'];
    }

    public function updateStatus($id, $status)
    {
        //
    }

    public function ajax(){
        return Admin::all()->toJson();
    }
}
