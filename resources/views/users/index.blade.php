@extends('base::layouts.master')

@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/core/plugins/grid/dlshouwen.grid.css') }}"/>
@endpush

@section('content')

    <div class="box box-info">
        <div class="box-header with-border">
            <div class="pull-left">
                <a class="btn btn-block btn-success" href="{{ route('admin.users.create') }}">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;新增
                </a>
            </div>
            <div class="pull-right">
                <form class="search-dtGrid-form" action="">
                    <div class="form-group">
                        <input type="text" id="keyword" name="keyword" class="form-control"
                               placeholder="" autocomplete="off">
                        <a href="javascript:;" class="btn btn-search"><i class="fa fa-search"></i></a>
                    </div>
                </form>
            </div>
        </div>
        <div id="gridContainer" class="box-body no-padding"></div>
        <div id="gridToolBarContainer" class="box-footer grid-toolbar-container"></div>

    </div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/core/js/confirm.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/grid/dlshouwen.grid.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/grid/i18n/zh-cn.js') }}"></script>
@endpush
@push('js')
<script>
    var dtGridColumns = [
        {id: 'id', title: '用户编号', fastQuery: true, fastQueryType: 'eq'},
        {id: 'username', title: '用户名称'},
        {id: 'email', title: 'email'},
        {
            id: 'operation', title: '管理操作', resolution: function (value, record, column, grid, dataNo, columnNo) {
            return "<a href='users/edit/" + record.id + "' class='btn btn-sm btn-warning m-r-5'><i class='fa fa-edit'></i>&nbsp;编辑&nbsp;</a>" +
                "<a href='javascript:;' class='btn btn-sm btn-danger' onclick='operateHandle.del(" + record.id + ")'><i class='fa fa-trash-o'></i>&nbsp;删除&nbsp;</a>";
        }
        }
    ];
    var dtGridOption = {
        lang: 'zh-cn',
        loadAll: true,
        loadURL: '{{ route('admin.users.index') }}',
        exportFileName: '用户列表',
        columns: dtGridColumns,
        tools: 'refresh|fastQuery',
    };
    var operateHandle = function () {
        function _del(id) {
            var tpl = '您确定要删除该菜单吗?'
            $.Confirm({
                url: '/admin/users/' + id,
                method: 'DELETE',
                data: {
                    Id: id
                },
                content: tpl
            });
        }

        return {
            del: _del
        }
    }();
    var grid = $.fn.dtGrid.init(dtGridOption);
    $(function () {
        grid.load();
    });
</script>
@endpush