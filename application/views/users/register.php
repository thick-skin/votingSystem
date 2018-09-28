
<div class="row">
	<div class="col-sm-12">

<ul class="nav nav-tabs nav-tabs-justified" style="background-color: lightgrey; font-weight: bolder;">
    <li><a data-toggle="tab" href="#regv">Register as Voter</a></li>
    <li><a data-toggle="tab" href="#regc">Register as Candidate</a></li>
</ul>
	<div class="well tab-content" style="margin-top: 5vh; box-shadow: 2px 2px 2px grey;">
 <div id="regv" class="tab-pane fade in">
      <h3>Register as Voter</h3><br><br>
      <div id="the-message"></div>
	<?php echo form_open('users/regVoter', array("id" => "form-user")); ?>
	
		<div id="err" class="form-group"><input class="form-control" type="text" name="level" maxlength="3" size="3" id="level" placeholder="Level (Only the numbers i.e 200)"></div>
		<div class="form-group row">
  			<div id="err" class="col-xs-4">
    			<input class="form-control" type="text" name="fname" id="fname" placeholder="Firstname">
    			
  			</div>
  			<div id="err" class="col-xs-4">
    		    <input class="form-control" type="text" name="lname" id="lname" placeholder="Lastname">
    		    
  			</div>
  			<div id="err" class="col-xs-4">
    			 <input class="form-control" type="text" name="oname" id="oname" placeholder="Othernames">
    			 
  			</div>
		</div>
		<div class="form-group row">
  			<div id="err" class="col-xs-6">
    			<input class="form-control" type="text" name="faculty" id="faculty" placeholder="Faculty">
    			
  			</div>
  			<div id="err" class="col-xs-6">
    		    <input class="form-control" type="text" name="dept" id="dept" placeholder="Department">
    		    
  			</div>
  			</div>
		<div id="err" class="form-group"><input class="form-control" type="text" name="regno" id="regno" maxlength="10" size="10" placeholder="Registration No."></div>
		<div id="err" class="form-group">
			 <small class="help-block">Select the input below to generate your vote key which is your pass to vote. Click the eye on the right to show the figure.(NB: It is for your eyes only)</small>
			<div class="input-group">
			<input class="form-control" type="text" name="key" id="key" maxlength="0" size="0" placeholder="Vote Key">
			<span class="input-group-addon"><i class="glyphicon glyphicon-eye-open"></i></span>
		</div>		
		</div>
		<button type="submit" class="btn btn-info">RegisterVoter</button>
	
	<?php echo form_close(); ?>
    </div>
     <div id="regc" class="tab-pane fade">
       <div id="the-message"></div>
      <h3>Register as Candidate</h3>
      
	<?php echo form_open_multipart('users/regCand', array("id" => "form-use")); ?>
		<div id="err" class="form-group">
			<label>Image upload</label>
			<input type="file" name="userfile" id="userfile" size="20">
      
		</div>
		<div id="err" class="form-group"><input class="form-control" type="text" name="year" id="year" maxlength="3" size="3" placeholder="Current level (Only the numbers i.e 200. Must be within 100-300)">
     </div>
		<div class="form-group row">
  			<div id="err" class="col-xs-4">
    			<input class="form-control" type="text" name="first" id="first" placeholder="Firstname">
          
  			</div>
  			<div id="err" class="col-xs-4">
    		    <input class="form-control" type="text" name="last" id="last" placeholder="Lastname">
            
  			</div>
  			<div id="err" class="col-xs-4">
    			 <input class="form-control" type="text" name="other" id="other" placeholder="Othernames">
           
  			</div>
		</div>
		<div class="form-group row">
  			<div id="err" class="col-xs-6">
    			<input class="form-control" type="text" name="fac" id="fac" placeholder="Faculty">
          
  			</div>
  			<div id="err" class="col-xs-6">
    		    <input class="form-control" type="text" name="dep" id="dep" placeholder="Department">
            
  			</div>
  			</div>
		<div class="form-group row">
  			<div id="err" class="col-xs-6">
    			<input class="form-control" type="text" name="reg" id="reg" maxlength="10" size="10" placeholder="Registration No.">
          
  			</div>
  			<div id="err" class="col-xs-6">
    		    <input class="form-control" type="text" name="gpa" id="gpa" placeholder="G.P.A.">
            
  			</div>
  			</div>
		<div id="err" class="form-group">
			 <input class="form-control" type="text" name="uname" id="uname" placeholder="Username">
       	
		</div>
		<div id="err" class="form-group">
			 <input class="form-control" type="password" name="pwd" id="pwd" placeholder="Password">
       	
		</div>
    <div id="err" class="form-group">
    <label>Post</label>
    <select name="seat" id="seat" class="form-control">
        <option value="Select seat">Select-post</option>
      <?php foreach ($seats as $seat):?>
        <option value="<?php echo $seat['name'] ?>"><?php echo $seat['name'] ?></option>
      <?php endforeach; ?>
    </select>
  </div>
		<button type="submit" class="btn btn-info">Register</button>
	
	<?php echo form_close(); ?>
    </div>
    <span style="font-size: 30px; padding: 5px 5vh; color: #6495ed;" class="glyphicon glyphicon-eject"></span>
</div>
</div>
</div>

<script>
    $(document).ready(function() {
      
      $("#key").on('click select', function() {
        $.ajax({
          type: 'ajax',
          url: '<?php echo base_url(); ?>users/generateKey',
          async: false,
          dataType: 'json',
          success: function(key) {
            
            $('#key').val(key);
            //showHideToggle();
          },
          error: function() {
            alert('Could not generate key!');
          }
        });
      });

      $("#form-user, #form-use").submit(function(e) {
        e.preventDefault();

        var me = $(this);
        var formData = new FormData($(this)[0]);

        //perform ajax
        $.ajax({
          url: me.attr('action'),
          dataType: 'json',
          type: 'post',
          data : formData,
          contentType : false,
          processData : false,
          success: function(response) {
            if (response.status == true) {
              console.log(response);
              // success message and remove class
      //I had problems here because i didn't add div to the #err and #the-message previously
              $('div#the-message').append('<p class="alert alert-success">'+'Registered'+'</p>');
              $('div#err').removeClass('has-error')
                       .removeClass('has-success');
              $('.text-danger').remove();

              // reset the form
              me[0].reset();

              // close the message after seconds
              $('.alert-success').delay(500).show(10, function() {
              $(this).delay(3000).hide(10, function() {
              $(this).remove();
              });
            });
            }else{
              $.each(response.messages, function(key, value) {
                var element = $('#' + key);
                element.closest('div#err')
                .removeClass('has-error')
                .addClass(value.length > 0 ? 'has-error' : 'has-success')
                .find('.text-danger')
                .remove();
                element.after(value);
              });
            }
          }
        });
      });
    });
  </script>