@extends('admin.main_page')
@section('content')
<div class="content-btn-div">
	<a href="{{url('Admin/add-volunteer')}}"><button class="content-add-btn">Add Volunteer</button>
	</a>
</div>
<table class="table" id="volunteer_table">
	
	<thead >
		
		<tr >
			<th>ID</th>
			<th>Image</th>
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Blood Group</th>
			<th>NID</th>
			<th>Additional Info</th>
			<th>Created at</th>
			<th>Updated at</th>
			<td>Action</td>
		</tr>
	</thead>
	<tbody>
	</tbody>
</table>

<div class="form-section" style="display: none;" id="data-update-sector">
	<form class="form-area" enctype="multipart/form-data" id="volunteer_update_form">
		@csrf
		<input type="hidden" name="volunteer_id" id="volunteer_id">
		<div class="input-double">
			<div class="form-div first-input">
				<label><b>Name</b></label>
				<input name="name" id="name" type="text" placeholder="Enter Name" >
				
			</div>
			<div class="form-div second-input">
				<label><b>Email</b></label>
				<input name="email" id="email" type="email" placeholder="Enter Email" name="Email" >
				
			</div>
		</div>
		<div class="input-double">
			<div class="form-div first-input">
				<label><b>Phone</b></label>
				<input name="phone" id="phone" type="text" placeholder="Enter Phone Number">
				
			</div>
			<div class=" second-input">
				<label><b>Blood</b></label>
				<input name="blood_group" id="blood_group" type="text" placeholder="Enter Blood Group" >
				
			</div>
		</div>
		<div class="input-double">
			<div class="form-div first-input">
				<label><b>Address</b></label>
				<input name="address" id="address" type="text" placeholder="Enter Address" name="phone">
				
			</div>
			<div class=" second-input">
				<label><b>NID</b></label>
				<input name="nid_number" id="nid_number" type="text" placeholder="Enter NID" >
				
			</div>
		</div>
		
		<div class="form-div ">
			<label><b>Info</b></label>
			<input name="message" id="message" type="text" placeholder="Information" >
			
		</div>
		<div class="form-div">
			<label><b>Photo</b></label>
			<input name="photo" type="file" placeholder="Enter NID" >
			
		</div>
		<div class="form-group">
			
			<button id="volunteer_submit_button" type="submit" class="form-btn"> Update Volunteer </button>
			</div> <!-- form-group// -->
			
		</form>
		
	</div>
@endsection
@section('script')
<script>
$(document).ready(function () {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
});
$('#volunteer_table').DataTable({
processing: true,
serverSide: true,
ajax: '{!! route('all_volunteer.list') !!}',
columns: [
{ data: 'volunteer_id', name: 'volunteer.volunteer_id' },
{data: 'photo', name: 'volunteer.photo',
render: function( data, type, full, meta ) {
return "<img src=\"/frontend_upload_asset/user/volunteer/" + data + "\" height=\"40\" alt='No Image'/>";
}
},
{ data: 'name', name: 'name' },
{ data: 'email', name: 'email' },
{ data: 'phone', name: 'phone' },
{ data: 'blood_group', name: 'blood_group' },
{ data: 'nid_number', name: 'nid_number' },
{ data: 'message', name: 'message' },
{ data: 'created_at', name: 'created_at' },
{ data: 'updated_at', name: 'updated_at' },
{ data: 'action', name: 'action' },
],
order: [
[0, 'desc']
],
initComplete: function () {
this.api().columns().every(function () {
var column = this;
var input = document.createElement("input");
$(input).appendTo($(column.footer()).empty())
.on('change', function () {
column.search($(this).val(), false, false, true).draw();
});
});
}
});
// start delete volunteer_table------------------------
$(document).on('click', '.delete', function () {
dataId = $(this).attr('id');
// alert(dataId);
Swal.fire({
title: 'Are you sure?',
text: "You won't be able to revert this!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.isConfirmed) {

$.ajax({
url: "delete_volunteer_api/" + dataId, //ajax execution to this url
type: 'delete',
data:{
_token:'{{ csrf_token() }}'
},
beforeSend: function () {
},
success: function (data) {
setTimeout(function () { 
var oTable = $('#volunteer_table').dataTable();
oTable.fnDraw(false); //reset datatable
});
}
});
Swal.fire(


'Deleted!',
'Your file has been deleted.',
'success'
)
}
})

});

// end delete Contact us --------------------------------
// start contact us edit button update model
$('body').on('click', '.edit-post', function () {
var data_id = $(this).data('id');
// alert(data_id);
$.get('/Admin/single-volunteer-table-information/' + data_id, function (data) {
	// alert('working fine');
	toggleTable();
$('#Update_category_model_heading').html("Update Sub Category"); //this is title
$('#update-user-btn').val("edit-post");

$('#volunteer_id').val(data.volunteer_id);
$('#name').val(data.name);
$('#email').val(data.email);
$('#phone').val(data.phone);
$('#message').val(data.message);
$('#blood_group').val(data.blood_group);
$('#address').val(data.address);
$('#nid_number').val(data.nid_number);
})
});
// end subcategory edit button update model
// start update contact us  form
if ($("#volunteer_update_form").length > 0) {
$("#volunteer_update_form").validate({
submitHandler: function (form) {
var actionType = $('#volunteer_submit_button').val();
$('#volunteer_submit_button').html('Sending..');
var form = $('#volunteer_update_form')[0];
var formData = new FormData(form);
event.preventDefault();
$.ajax({
url: "{{ route('volunteer.update') }}",
type: "POST", // http method
processData: false,
contentType: false,
data: formData,
success: function (data) { //if it succeed
$('#volunteer_update_form').trigger("reset"); //form reset
var oTable = $('#volunteer_table').dataTable(); //initialization datatable
oTable.fnDraw(false); //reset datatable
toggleTable();
iziToast.success({ //show iziToast with notification data successfully saved in the lower right position
title: 'Volunteer Successfully Updated',
message: '{{ Session('
success ')}}',
position: 'bottomRight'
});
$('#volunteer_submit_button').html('Update Volunteer')
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
// volunteer photo update
// table show hide
function toggleTable() {
  var x = document.getElementById("volunteer_table");
   var form_model=document.getElementById('data-update-sector');
  if (x.style.display === "none") {
    x.style.display = "block";
    form_model.style.display="block";
    form_model.style.display="none";
  } else { 
    x.style.display = "none";
    form_model.style.display="block";

  }
}

</script>
@endsection