@extends('base::layouts.master')

@section('content')
    <div class="box box-info">
        {!! $dataTable or '' !!}
    </div>
@endsection

@push('scripts')

<script src="{{ asset('vendor/core/plugins/jquery.blockui.min.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('vendor/core/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"></script>
<script src="{{ asset('vendor/core/js/datatables/datatable.js') }}"></script>
<script src="{{ asset('vendor/core/js/datatables/datatable.ajax.js') }}"></script>
@endpush
@push('js')
{!! $script !!}
@endpush