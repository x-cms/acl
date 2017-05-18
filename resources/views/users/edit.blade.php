@extends('base::layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/select2/select2.min.css') }}">
@endpush

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
                <div class="form-group">
                    <label class="col-md-2 control-label">邮箱</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">手机号</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                    </div>
                </div>
                <div class="form-group last">
                    <label class="col-md-2 control-label">角色组</label>
                    <div class="col-md-6">
                        <select name="roles[]" class="form-control select2" multiple="multiple" data-placeholder="请选择">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->roles->id == $role->id ? 'checked' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
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

@push('scripts')
<script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
<script src="//cdn.bootcss.com/select2/4.0.3/js/i18n/zh-CN.js"></script>
@endpush
@push('js')
<script>
    $('select').select2({
        language: "zh-CN"
    });
</script>
@endpush