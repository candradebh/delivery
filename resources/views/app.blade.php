<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delivery</title>

	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<link href="http://getbootstrap.com/examples/dashboard/dashboard.css" rel="stylesheet">
	<link href="http://getbootstrap.com/examples/jumbotron/jumbotron.css" rel="stylesheet">
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">Delivery</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">HOME</a></li>
					<li><a href="{{ url('/auth/register') }}">CADASTRAR</a></li>
					<li><a href="{{ url('contact') }}">CONTATO</a></li>
				</ul>
					@if(auth()->guest())
						@if(!Request::is('auth/login'))
							<form class="navbar-form navbar-right" method="POST" role="form" action="{{ url('/auth/login') }}">
								{!! csrf_field() !!}
								<div class="form-group">
									<input type="text" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}">
								</div>
								<div class="form-group">
									<input type="password" placeholder="Senha" class="form-control" name="password">
								</div>
								<button type="submit" class="btn btn-success">Entrar</button>
							</form>
						@endif

					@else

					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ auth()->user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li ><a href="{{ url('customer/order') }}">Meus Pedidos</a></li>
								<li><a href="{{ url('/auth/logout') }}">Sair</a></li>
							</ul>
						</li>
					</ul>
					@endif
			</div>
		</div>
</nav>


			@if(!auth()->guest())
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-3 col-md-2 sidebar">
							@if(Auth::user()->role=="admin")
							<ul class="nav nav-sidebar">
								<li class="active"><a href="{{ url('home') }}">Inicio<span class="sr-only">(current)</span></a></li>
								<li ><a href="{{ url('admin/categories') }}">Categorias</a></li>
								<li ><a href="{{ url('admin/clients') }}">Clientes</a></li>
								<li ><a href="{{ url('admin/cupoms') }}">Cupons</a></li>
								<li ><a href="{{ url('admin/orders') }}">Pedidos</a></li>
								<li ><a href="{{ url('admin/products') }}">Produtos</a></li>
							</ul>
							@endif
							@if(Auth::user()->role=="Client")
								<ul class="nav nav-sidebar">
									<li class="active"><a href="{{ url('home') }}">Inicio<span class="sr-only">(current)</span></a></li>
									<li ><a href="{{ url('customer/order') }}">Meus Pedidos</a></li>
								</ul>
							@endif
						</div>
						<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
							@yield('content')

						</div>
					</div>
				</div>

				@else

					<div class="container">
						@yield('content')

						<hr class="featurette-divider">

						<footer>
							<p>&copy; NetBin 2015</p>
						</footer>
					</div> <!-- /container -->


				@endif




	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
	<script src="http://getbootstrap.com/assets/js/vendor/holder.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>




				@yield('post-script')

</body>
</html>
