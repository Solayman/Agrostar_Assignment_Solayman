@extends('admin.main_page')
@section('content')
<div class="form-section">
	@if ($message = Session::get('message'))
	<h3 style="color:red;font-weight: bold;">{{ Session::get('message') }}</h3>
	@endif
	<form class="form-area"  method="post" action="{{url('Admin/update-user-info')}}">
		@csrf
		<div class="form-div ">
			<label><b>Name</b></label>
			<input value="{{$select_user->name}}" type="text"
			placeholder="Enter Information"
			name="name" required>
		</div>
		<div class="form-div ">
			<label><b>Email</b></label>
			<input value="{{$select_user->email}}" disabled="" type="email"
			placeholder="Enter Information"
			name="email" required>
		</div>
		<div class="form-div ">
			<label><b>Phone</b></label>
			<input name="phone" value="{{$select_user->phone}}"  type="text"
			placeholder="Enter Phone Number"
			name="phone" required>
		</div>
		<div class="form-group">
			<button type="submit" class="form-btn"> Update Profile </button>
			</div> <!-- form-group// -->
		</form>
	</div>
	@endsection