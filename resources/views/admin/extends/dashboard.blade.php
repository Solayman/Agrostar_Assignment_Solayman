@extends('admin.main_page')
@section('content')
<div class="box-shadow first-input">
	<span class="box-shadow-title">Today is: <span style="color:blue;">{{\Carbon\Carbon::now()->format('d-m-Y')}}</span></span>
</div>
<div class="box-shadow second-input">
	<span class="box-shadow-title">Total Volunteer: <span style="color:blue;">{{$todal_volunteer}}</span style="color:blue;"></span>
</div>
@endsection