@layout(default)
<h3>Welcome</h3>

@if(App\Session::exists("error"))
<div class="alert alert-danger" role="alert">
	{{App\Session::get("error")}}
</div>
@endif
@auth
<table class="table">
	<thead>
	<tr>
		<th scope="col">#</th>
		<th scope="col" style="width:25%;">Title</th>
		<th scope="col">Description</th>
		<th scope="col">Author</th>
	</tr>
	</thead>
	<tbody>

	@foreach(App\Models\User::find(1)->posts() as $post)
	<tr>
		<th scope="row">{{$post->id}}</th>
		<td>{{$post->title}}</td>
		<td><em>{{$post->body}}</em></td>
		<td>{{$post->author()->name}}</td>
	</tr>
	@endforeach

	</tbody>
</table>
<table class="table">
	<thead>
	<tr>
		<th scope="col">#</th>
		<th scope="col">Name</th>
		<th scope="col">Email</th>
	</tr>
	</thead>
	<tbody>

	@foreach(App\Models\User::all() as $user)
	<tr>
		<th scope="row">{{$user->id}}</th>
		<td>{{$user->name}}</td>
		<td><em>{{$user->email}}</em></td>
	</tr>
	@endforeach

	</tbody>
</table>
@endauth