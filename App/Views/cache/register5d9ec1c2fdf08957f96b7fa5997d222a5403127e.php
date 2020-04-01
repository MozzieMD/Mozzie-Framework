<!doctype html>
<html lang="en"><head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
	<meta name="generator" content="Jekyll v3.8.6">
	<title>Blog Template · Bootstrap</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">



	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>
	<!-- Custom styles for this template -->
	<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">

</head>
<body>
<div class="container">
	<header class="blog-header py-3">
		<div class="row flex-nowrap justify-content-between align-items-center">
			<div class="col-4 pt-1">
				<a class="text-dark mr-2" href="<?php echo App\Router::url("home"); ?>">Home</a>
			</div>
			<div class="col-4 d-flex justify-content-end align-items-center">
				<a class="text-muted" href="#" aria-label="Search">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false"><title>Search</title><circle cx="10.5" cy="10.5" r="7.5"></circle><path d="M21 21l-5.2-5.2"></path></svg>
				</a>
				<?php if(App\Auth::check()): ?>
				<form method="post" action="<?php echo App\Router::url("logout"); ?>">
					<input type="hidden" name="token" value="<?php echo App\Session::get("token"); ?>">
					<button type="submit" class="btn btn-sm btn-outline-secondary">Logout</button>
				</form>

				<?php else: ?>
				<div class="btn-group" role="group">
					<a class="btn btn-sm btn-outline-secondary" href="<?php echo App\Router::url("login"); ?>">Login</a>
					<a class="btn btn-sm btn-outline-secondary" href="<?php echo App\Router::url("register"); ?>">Sign Up</a>
				</div>

				<?php endif; ?>
			</div>
		</div>
	</header>

	<div class="nav-scroller py-1 mb-2">
		<nav class="nav d-flex justify-content-between">
			<a class="p-2 text-muted" href="#">#welcome</a>
			<a class="p-2 text-muted" href="#">#home</a>
			<a class="p-2 text-muted" href="#">#news</a>
			<a class="p-2 text-muted" href="#">#staiacasa</a>
			<a class="p-2 text-muted" href="#">#corona</a>
			<a class="p-2 text-muted" href="#">#virus</a>
		</nav>
	</div>

	<div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
		<div class="col-md-6 px-0">
			<h2 class="font-italic">Welcome to Mozzie Framework</h2>

		</div>
	</div>


</div>

<main role="main" class="container">
	
<div class="col-8 mx-auto text-center">
	<form class="form-signin" method="post" action="<?php echo App\Router::url("doRegister"); ?>">
		<h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
		<label for="inputName" class="sr-only">Name</label>
		<input type="text" id="inputName" class="form-control" placeholder="Name" name="name" required="" autofocus="">
		<?php if(isset(App\Session::get("errors")["name"])): ?>
		<small class="form-text text-danger text-left">
            <?php echo App\Session::get("errors")["name"]; ?>
		</small>
		<?php endif; ?>
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required="" autofocus="">
		<?php if(isset(App\Session::get("errors")["email"])): ?>
		<small class="form-text text-danger text-left">
            <?php echo App\Session::get("errors")["email"]; ?>
		</small>
		<?php endif; ?>
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required="">
		<?php if(isset(App\Session::get("errors")["password"])): ?>
		<small class="form-text text-danger text-left">
            <?php echo App\Session::get("errors")["password"]; ?>
		</small>
		<?php endif; ?>

		<input type="hidden" name="token" value="<?php echo App\Session::get("token"); ?>">
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
		<p class="mt-5 mb-3 text-muted">© 2020</p>
	</form>
</div>

<style>
	.form-signin {
		width: 100%;
		padding: 15px;
		margin: 0 auto;
	}
	.form-signin .checkbox {
		font-weight: 400;
	}
	.form-signin .form-control {
		position: relative;
		box-sizing: border-box;
		height: auto;
		padding: 10px;
		font-size: 16px;
	}
	.form-signin .form-control:focus {
		z-index: 2;
	}
	.form-signin input[type="email"] {
		margin-bottom: -1px;
		border-bottom-right-radius: 0;
		border-bottom-left-radius: 0;
	}
	.form-signin input[type="password"] {
		margin-bottom: 10px;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
	}
</style>


</main><!-- /.container -->


</body></html>