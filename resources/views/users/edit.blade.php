@extends('base::layouts.master')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">基本信息</h3>
        </div>
        <form class="form-horizontal form-bordered" method="post" action="{{ route('admin.users.update', ['id' => $user->id]) }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">用户名</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="username" autocomplete="off" value="{{ $user->username }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">密码</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password" autocomplete="off" value="{{ $user->password }}">
                    </div>
                </div>
                <div class="form-group last">
                    <label class="col-md-2 control-label">邮箱</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-group last">
                    <label class="col-md-2 control-label">手机号</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <a class="btn btn-primary" href="{{ route('admin.users.index') }}">返回列表</a>
                    <button type="submit" class="btn btn-primary">确认提交</button>
                </div>
            </div>
        </form>
    </div>
@endsection