@extends('base::layouts.master')

@section('content')
    {!! $dataTable or '' !!}
@endsection

@push('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="{{ asset('vendor/core/js/datatables/datatable.js') }}"></script>
<script src="{{ asset('vendor/core/js/datatables/datatable.ajax.js') }}"></script>
@endpush
@push('js')
<script>
    $(window).on('load', function () {
        new Xcms.DataTableAjax($('table.datatables'), {
            dataTableParams: {
                ajax: {
                    url: 'http://webed.dev/admincp/users',
                    method: 'POST'
                },
                columns: [{"data":"id","name":"id","searchable":false,"orderable":false},{"data":"avatar","name":"avatar","searchable":false,"orderable":false},{"data":"username","name":"username"},{"data":"email","name":"email"},{"data":"status","name":"status"},{"data":"created_at","name":"created_at","searchable":false},{"data":"roles","name":"roles","searchable":false,"orderable":false},{"data":"actions","name":"actions","searchable":false,"orderable":false}]
            }
        });
    });
</script>
@endpush