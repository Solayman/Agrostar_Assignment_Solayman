@extends('admin.main_page')
@section('content')
<div class="form-section">
	<form class="form-area" enctype="multipart/form-data" id="store_volunteer">
		@csrf
		<div class="input-double">
			<div class="form-div first-input">
				<label><b>Name</b></label>
				<input name="name" type="text" placeholder="Enter Name" >
				
			</div>
			<div class="form-div second-input">
				<label><b>Email</b></label>
				<input name="email" type="email" placeholder="Enter Email" name="Email" >
				
			</div>
		</div>
		<div class="input-double">
			<div class="form-div first-input">
				<label><b>Phone</b></label>
				<input name="phone" type="text" placeholder="Enter Phone Number">
				
			</div>
			<div class=" second-input">
				<label><b>Blood</b></label>
				<input name="blood_group"  type="text" placeholder="Enter Blood Group" >
				
			</div>
		</div>
		<div class="input-double">
			<div class="form-div first-input">
				<label><b>Address</b></label>
				<input name="address" type="text" placeholder="Enter Address" name="phone">
				
			</div>
			<div class=" second-input">
				<label><b>NID</b></label>
				<input name="nid_number" type="text" placeholder="Enter NID" >
				
			</div>
		</div>
		
		<div class="form-div ">
			<label><b>Info</b></label>
			<input name="message" type="text" placeholder="Information" >
			
		</div>
		<div class="form-div">
			<label><b>Photo</b></label>
			<input name="photo" type="file" placeholder="Enter NID" >
			
		</div>
		<div class="form-group">
			
			<button id="store_volunteer_submit_button" type="submit" class="form-btn"> Store Volunteer </button>
			</div> <!-- form-group// -->
			
		</form>
		
	</div>
	@endsection
	@section('script')
	<script type="text/javascript">
		
		if ($("#store_volunteer").length > 0) {
	$("#store_volunteer").validate({
	submitHandler: function (form) {
	var actionType = $('#store_volunteer_submit_button').val();
	$('#store_volunteer_submit_button').html('Sending..');
	var form = $('#store_volunteer')[0];
	var formData = new FormData(form);
	event.preventDefault();
	$.ajax({
	url: "{{ route('volunteer.store') }}",
	type: "POST", // http method
	processData: false,
	contentType: false,
	data: formData,
	success: function (data) { //if it succeed
	$('#store_volunteer').trigger("reset"); //form reset
	$('#store_volunteer_submit_button').html('Store Volunteer');
	iziToast.success({ //show iziToast with notification data successfully saved in the lower right position
	title: 'Volunteer Successfully Added',
	message: '{{ Session('
	success ')}}',
	position: 'bottomRight'
	});
	},
	error: function (data) { //if an error shows an error on the console
	console.log('Error:', data);
	iziToast.error({
	title:'Validation failed'
	});
	}
	});
	}
	})
	}
	</script>
	@endsection