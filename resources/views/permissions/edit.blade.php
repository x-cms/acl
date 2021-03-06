@extends('base::layouts.master')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">基本信息</h3>
        </div>
        <form class="form-horizontal form-bordered" method="post" action="{{ route('admin.permissions.update', ['id' => $permission->id]) }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">权限名称</label>
                    <div class="col-md-6">
                        <input type="text"
                               name="name"
                               class="form-control"
                               autocomplete="off"
                               value="{{ $permission->name }}"
                        >
                    </div>
                </div>
                <div class="form-group last">
                    <label class="col-md-2 control-label">别名</label>
                    <div class="col-md-6">
                        <input type="text"
                               name="slug"
                               class="form-control"
                               autocomplete="off"
                               value="{{ $permission->slug }}"
                        >
                    </div>
                </div>
                <div class="form-group last">
                    <label class="col-md-2 control-label">上级权限</label>
                    <div class="col-md-6">
                        {!! $permissions !!}
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <a class="btn btn-primary" href="{{ route('admin.permissions.index') }}">返回列表</a>
                    <button type="submit" class="btn btn-primary">确认提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection