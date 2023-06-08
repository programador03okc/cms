@extends('themes/lte/layout_login')

@section('content')
    <div class="login-logo">
        <a href="http://suite.okcomputer.com.pe/">
            <b>CMS OKC</b>
        </a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">INICIAR SESION</p>
        <form class="form-login" method="post" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                <input class="form-control"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Ingrese su correo"
                    autofocus>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                <input class="form-control"
                    type="password"
                    name="password"
                    placeholder="Ingrese su clave">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
            </div>
            <br>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
            </div>
        </form>
        <p class="footer-login">
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        </p>
    </div>
@endsection

@section('scripts')
    <script>
        $(function () {
            $('.check-login').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
@endsection