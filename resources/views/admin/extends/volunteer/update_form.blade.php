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