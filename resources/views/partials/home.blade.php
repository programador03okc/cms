@extends('themes/lte/layout')

@section('title')
    DASHBOARD
@endsection

@section('breadcrumb')
<h1 class="m-0 text-dark">Dashboard</h1>
<ol class="breadcrumb">
    <li><a href="javascript: void(0);"><i class="fa fa-dashboard"></i> CMS OK COMPUTER</a></li>
    <li class="active">Inicio</li>
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