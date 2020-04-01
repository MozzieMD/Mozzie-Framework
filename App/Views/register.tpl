@layout(default)
<div class="col-8 mx-auto text-center">
	<form class="form-signin" method="post" action="{{App\Router::url("doRegister")}}">
		<h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
		<label for="inputName" class="sr-only">Name</label>
		<input type="text" id="inputName" class="form-control" placeholder="Name" name="name" required="" autofocus="">
		@if(isset(App\Session::get("errors")["name"]))
		<small class="form-text text-danger text-left">
            {{App\Session::get("errors")["name"]}}
		</small>
		@endif
		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required="" autofocus="">
		@if(isset(App\Session::get("errors")["email"]))
		<small class="form-text text-danger text-left">
            {{App\Session::get("errors")["email"]}}
		</small>
		@endif
		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" required="">
		@if(isset(App\Session::get("errors")["password"]))
		<small class="form-text text-danger text-left">
            {{App\Session::get("errors")["password"]}}
		</small>
		@endif

		@input-token
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
