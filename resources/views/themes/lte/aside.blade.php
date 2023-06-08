<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="{{ asset('assets/lte/dist/img/perfil02.png') }}" class="img-circle" alt="Avatar Man">
			</div>
			<div class="pull-left info">
				<p class="text-session">{{ Auth::user()->name }}</p>
				<a href="javascript: void(0);"><i class="fa fa-circle text-success"></i> Activo</a>
			</div>
		</div>
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MENU DE GESTION</li>
			<li class="treeview">
				<a href="javascript: void(0);">
					<i class="fa fa-cubes"></i><span>Catálogo</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ route('catalogs.product.index') }}"><i class="fa fa-circle-o"></i> Productos</a></li>
					<li><a href="{{ route('catalogs.feature-value.index') }}"><i class="fa fa-circle-o"></i> Especificaciones</a></li>
					<li><a href="{{ route('catalogs.feature.index') }}"><i class="fa fa-circle-o"></i> Características</a></li>
					<li><a href="{{ route('catalogs.value.index') }}"><i class="fa fa-circle-o"></i> Valores</a></li>
					<li><a href="{{ route('catalogs.category.index') }}"><i class="fa fa-circle-o"></i> Categorías</a></li>
					<li><a href="{{ route('catalogs.subcategory.index') }}"><i class="fa fa-circle-o"></i> Sub Categorías</a></li>
					<li><a href="{{ route('catalogs.mark.index') }}"><i class="fa fa-circle-o"></i> Marcas</a></li>
					<li><a href="{{ route('catalogs.unit.index') }}"><i class="fa fa-circle-o"></i> Unidades de Medida</a></li>
					<li><a href="{{ route('catalogs.currency.index') }}"><i class="fa fa-circle-o"></i> Moneda</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="javascript: void(0);">
					<i class="fa fa-paint-brush"></i><span>Diseño</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ route('catalogs.arts.index') }}"><i class="fa fa-circle-o"></i> Artes</a></li>
					<li><a href="{{ route('catalogs.arts-type.index') }}"><i class="fa fa-circle-o"></i> Tipo de Imagen</a></li>
					<li><a href="{{ route('catalogs.section.index') }}"><i class="fa fa-circle-o"></i> Tipo de Banner</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="javascript: void(0);">
					<i class="fa fa-cloud"></i><span>Canales Web</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					 <li><a href="{{ route('channels.store_okc') }}"><i class="fa fa-circle-o"></i> Web OKC</a></li>
					 <!-- <li><a href="{{ route('channels.list_okc') }}"><i class="fa fa-circle-o"></i> Lista de Productos</a></li> -->
					 <li><a href="{{ route('catalogs.temp.index') }}"><i class="fa fa-circle-o"></i> Productos Temporales</a></li>
					 <!-- <li><a href="index.html"><i class="fa fa-circle-o"></i> MarketPlace</a></li> -->
				</ul>
			</li>
			<li class="treeview">
				<a href="javascript: void(0);">
					<i class="fa fa-laptop"></i><span>Integraciones</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ route('intcomex.lista') }}"><i class="fa fa-circle-o"></i> Productos Intcomex</a></li>
					<li><a href="{{ route('intcomex.pending') }}"><i class="fa fa-circle-o"></i> Productos Pendientes</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="javascript: void(0);">
					<i class="fa fa-briefcase"></i><span>Configuración</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{ route('catalogs.wholesaler.index') }}"><i class="fa fa-circle-o"></i> Mayoristas</a></li>
					<li><a href="{{ route('configurations.section-web.index') }}"><i class="fa fa-circle-o"></i> Secciones Web</a></li>
					<li><a href="{{ route('configurations.segment.index') }}"><i class="fa fa-circle-o"></i> Segmentos</a></li>
					<li><a href="{{ route('configurations.tag.index') }}"><i class="fa fa-circle-o"></i> Etiquetas</a></li>
					<li><a href="{{ route('configurations.store-shop.index') }}"><i class="fa fa-circle-o"></i> Tiendas Online</a></li>
					<li><a href="{{ route('configurations.type-change.index') }}"><i class="fa fa-circle-o"></i> Tipo de Cambio</a></li>
					<li><a href="{{ route('configurations.user.index') }}"><i class="fa fa-circle-o"></i> Usuarios</a></li>
				</ul>
			</li>
		</ul>
	</section>
</aside>