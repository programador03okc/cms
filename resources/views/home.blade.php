@extends('themes/lte/layout')

@section('title')
    DASHBOARD
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    </ol>
@endsection

@section('content')
    <div class="row">
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/util.js') }}"></script>
    <script>
        @if (Session::has('key'))
            var tpm = '<?=Session::get("key")?>';
            var msg = '<?=Session::get("message")?>';
            notify(tpm, msg);
        @endif
    </script>
@endsection