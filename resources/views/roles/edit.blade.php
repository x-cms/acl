@extends('base::layouts.master')

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">基本信息</h3>
        </div>
        <form class="form-horizontal form-bordered" method="post"
              action="{{ route('admin.roles.update', ['id' => $role->id]) }}">
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label class="col-md-2 control-label">角色名称</label>
                    <div class="col-md-6">
                        <input type="text"
                               name="name"
                               class="form-control"
                               autocomplete="off"
                               value="{{ $role->name }}"
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
                               value="{{ $role->slug }}"
                        >
                    </div>
                </div>
                <div class="form-group last">
                    <label class="col-md-2 control-label">权限设置</label>
                    <div class="col-md-10">
                        <div class="row role p-b-20">
                            <div class="col-lg-2 col-md-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" data-all>
                                        选择全部
                                    </label>
                                </div>
                            </div>
                        </div>
                        @foreach($permissions as $permission)
                            <div class="row role p-t-20 p-b-20">
                                <div class="col-lg-2 col-md-3">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ array_get($permission, 'id') }}"
                                                   data-group
                                                    {{ in_array(array_get($permission, 'id'), $role->permissions) ? 'checked' : '' }}
                                            > {{ array_get($permission, 'name') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-9">
                                    @foreach(array_get($permission, 'child') as $child)
                                        <div class="checkbox">
                                            <label class="col-lg-2 col-md-3 col-sm-4">
                                                <input type="checkbox"
                                                       name="permissions[]"
                                                       value="{{ array_get($child, 'id') }}"
                                                       data-group-id="{{ array_get($permission, 'id') }}"
                                                       data-parent
                                                        {{ in_array(array_get($child, 'id'), $role->permissions) ? 'checked' : '' }}
                                                > {{ array_get($child, 'name') }}
                                            </label>
                                            @foreach(array_get($child, 'child') as $item)
                                                <label class="col-lg-2 col-md-3 col-sm-4">
                                                    <input type="checkbox"
                                                           name="permissions[]"
                                                           value="{{ array_get($item, 'id') }}"
                                                           data-parent-id="{{ array_get($child, 'id') }}"
                                                           data-group-id="{{ array_get($permission, 'id') }}"
                                                           data-sub
                                                            {{ in_array(array_get($item, 'id'), $role->permissions) ? 'checked' : '' }}
                                                    > {{ array_get($item, 'name') }}
                                                </label>
                                            @endforeach
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

@push('js')
<script>
    $("input[data-all]").on("change", function (e) {
        var $this = $(this),
            isCheck = $this.is(':checked'),
            list = $(":checkbox")
        ;
        if (isCheck) {
            list.prop("checked", true);
        } else {
            list.prop("checked", false);
        }
    });

    $("input[data-group]").on("change", function () {
        var $this = $(this),
            groupId = $this.val(),
            isCheck = $this.is(':checked'),
            list = $("input[data-group-id='" + groupId + "']");
        if (isCheck) {
            list.prop("checked", true);
        } else {
            list.prop("checked", false);
        }
    });

    $("input[data-parent]").on("change", function () {
        var $this = $(this),
            parentId = $this.val(),
            isCheck = $this.is(':checked'),
            list = $("input[data-parent-id='" + parentId + "']");
        if (isCheck) {
            list.prop("checked", true);
        } else {
            list.prop("checked", false);
        }
    });

    $("input[data-sub]").on("change", function () {
        var $this = $(this),
            parentId = $this.attr("data-parent-id"),
            isCheck = $this.is(':checked');
        list = $("input[value='" + parentId + "']")
        if (isCheck) {
            list.prop("checked", true);
        } else {
            list.prop("checked", false);
        }
    });
</script>
@endpush