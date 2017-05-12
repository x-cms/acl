<?php

namespace Xcms\Acl\Http\Controllers;

use Illuminate\Http\Request;
use Xcms\Acl\Http\DataTables\AdminDataTable;
use Xcms\Base\Http\Controllers\SystemController;

class UserController extends SystemController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminDataTable $adminDataTable)
    {
        $this->setPageTitle('管理员列表');
        $this->breadcrumbs->addLink('管理员');
        menu()->setActiveItem('users');
        $dataTable = $adminDataTable->run();
        $script = $adminDataTable->script();

        return view('acl::users.index', compact('dataTable', 'script'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatus($id, $status)
    {
        //
    }

    public function ajax(AdminDataTable $adminDataTable){
        return $adminDataTable->ajax();
    }
}
