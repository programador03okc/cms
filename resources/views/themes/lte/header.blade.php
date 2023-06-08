<header class="main-header">
	<a href="{{ route('home') }}" class="logo">
		<span class="logo-mini">OKC</span>
		<span class="logo-lg">CMS</span>
	</a>
	<nav class="navbar navbar-static-top">
		<a href="javascript: void();" class="sidebar-toggle" data-toggle="push-menu" role="button"><span class="sr-only">Toggle navigation</span></a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<li class="dropdown notifications-menu">
					<a href="javascript: void();" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i><span class="label label-warning" id="notify-count">0</span>
					</a>
					<ul class="dropdown-menu" id="notify-html" style="width:auto;"></ul>
				</li>
				<li class="dropdown user user-menu">
					<a href="javascript: void();" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs">Usuario: {{ Auth::user()->name }}</span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header">
							<p>{{ Auth::user()->name }}</p>
							<medium>{{ Auth::user()->user }}</medium><br>
							<medium>{{ Auth::user()->email }}</medium><br>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="javascript: void(0);" onclick="resetPass();" class="btn btn-default btn-flat">Cambiar clave</a>
							</div>
							<div class="pull-right">
								<a href="{{ route('logout') }}" class="btn btn-default btn-flat">Cerrar sesion</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>