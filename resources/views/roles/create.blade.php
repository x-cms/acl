@extends('base::layouts.master')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">基本信息</h3>
        </div>
        <form class="form-horizontal form-bordered" method="post" action="{{ route('admin.roles.store') }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">角色名称</label>
                    <div class="col-md-6">
                        <input type="text"
                               name="name"
                               class="form-control"
                               autocomplete="off"
                        >
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">别名</label>
                    <div class="col-md-6">
                        <input type="text"
                               name="slug"
                               class="form-control"
                               autocomplete="off"
                        >
                    </div>
                </div>
                <div class="form-group last">
                    <label class="col-md-2 control-label">权限设置</label>
                    <div class="col-md-10">
                        @foreach($permissions as $permission)
                            <div class="row role p-t-20 p-b-20">
                                <div class="col-lg-2 col-md-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"> {{ array_get($permission, 'name') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9">
                                    @foreach(array_get($permission, 'child') as $child)
                                        <div class="checkbox col-lg-2 col-md-3 col-sm-4">
                                            <label>
                                                <input type="checkbox"> {{ array_get($child, 'name') }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <a class="btn btn-primary" href="{{ route('admin.roles.index') }}">返回列表</a>
                    <button type="submit" class="btn btn-primary">确认提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection