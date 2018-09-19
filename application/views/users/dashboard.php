<style>
  /* Popover */
  .popover {
      border: 2px dotted red;
      width: 70%;
  }
  /* Popover Body */
  .popover-content {
      padding-left: 30px;
  }
  /* Popover Arrow */
  .arrow {
      border-left-color: red !important;
  }
  </style>
  <div class="jumbotron">
    <form>
      <div class="form-group">
      <textarea class="form-control" placeholder="ANNOUNCEMENTS"></textarea>
      </div>
      <button class="btn btn-lg btn-block btn-info">ANNOUNCE</button>
    </form>
  </div>
<div class="col-sm-4 myDeleteClass">
	<h3>POSTS</h3>
  <i class="alert-warning">NB: If there is no candidate under any post, delete the post before election day, else the voters won't be able to cast there votes.</i>
	<div id="the-message"></div>
<?php echo form_open('users/dashB', array("id" => "form-user")); ?>
<div class="form-group">
	<input type="text" class="form-control" name="name" id="name" placeholder="Post name">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form><br>

<table id="showdata" class="table table-responsive">
	
</table>

</div>
<div class="col-sm-4">
  Results here
	<!--<?php// foreach ($candidates as $candidate): ?>
		<div style="font-size: 15px; display: flex;" class="well">
			<button type="submit" name="removeCandidate" class="btn btn-xs btn-danger" style="height: 25px; margin-right: 10px;"><span class="glyphicon glyphicon-remove"></span></button>
			<img style="height: 50%; width: 50%;" class="img-circle" src="<?php// echo site_url(); ?>assets/img/candidates/<?php// echo $candidate['image']; ?>"> 
			<div style="margin-left: 10px;"><p>@<?php// echo $candidate['uname']; ?></p> <p>for <?php// echo $candidate['seat'] ?></p>
			</div>
		</div>
	<?php// endforeach; ?>-->
</div>
<script>
    $(document).ready(function() {
    	
    	showSeat();
    	function popOver() {

    	$('#showdata').on('myFunc', '.deleteSeat', function(event) {
    		var name = $(this).attr('data');
    	delFinal();
    	$(this).popover({
    		trigger: 'focus',
    		delay: 500,
    		title: 'If you delete '+name+' seat all candidates running for the post will be disqualified. Delete?', 
    		content: "<form id='yes' method='POST' action='<?php echo base_url(); ?>users/deleteSeat' style='display: inline-flex;'><input type='hidden'  name='seatname' value='"+name+"'><button type='submit' class='btn btn-sm btn-danger'>Yes</button> </form> <button class='btn btn-sm btn-default no'>No</button>", 
    		html: true, 
    		placement: "left"
    	});
    	function delFinal() {
    //I had problem here because i didn't call a div class that contained the popover and button
    //I called .myDeleteClass below so that the popover button will load in the popover inside this class. Maybe $('table#showdata') will work.
    	$('.myDeleteClass').unbind().on('submit', '#yes', function(e) {
    		e.preventDefault();
			var me = $(this);
    		
    		$.ajax({
    		  	url: me.attr('action'),
          		type: 'post',
          		data: me.serialize(),
          		dataType: 'json',
          		success: function(response) {
          			if (response.success == true) {
    				$('#the-message').append('<p class="alert alert-success">'+'Seat deleted!'+'</p>');
    				 // close the message after seconds
              $('.alert-success').delay(500).show(10, function() {
              $(this).delay(2000).hide(10, function() {
              $(this).remove();
              });
            });
    			}
    			showSeat();
    			},
    			error: function() {
    				alert('Could not delete seat from database!');
    			}
    		});
    	});
    }
    	
    });
    	$('.deleteSeat').trigger('myFunc');

    	}
    	
    	function showSeat() {
    		$.ajax({
    			type: 'ajax',
    			url: '<?php echo base_url(); ?>users/getSeat',
    			async: false,
    			dataType: 'json',
    			success: function(data) {
    				var html = '';
    				var i;
    				for (i = 0; i < data.length; i++) {
    					html += '<tr style="font-weight: bold;">'+
    								'<td style="padding: 5px 5px;">'+data[i].name+'</td>'+
    								'<td style="padding: 5px 5px;">'+
    								'<a href="javascript:;" class="btn btn-sm btn-danger deleteSeat" data="'+data[i].name+'"><span class="glyphicon glyphicon-trash"></span></a>'+
    								'</td>'+
    							'</tr>';
    				}
    				$('#showdata').html(html);
    				popOver();
    			},
    			error: function() {
    				alert('Could not get database data!');
    			}
    		});
    	}

      $("#form-user").submit(function(e) {
        e.preventDefault();

        var me = $(this);

        //perform ajax
        $.ajax({
          url: me.attr('action'),
          type: 'post',
          data: me.serialize(),
          dataType: 'json',
          success: function(response) {
            if (response.success == true) {
            	showSeat();
              // success message and remove class
              $('#the-message').append('<p class="alert alert-success">'+'Seat added!'+'</p>');
              $('.form-group').removeClass('has-error')
                       .removeClass('has-success');
              $('.text-danger').remove();

              // reset the form
              me[0].reset();

              // close the message after seconds
              $('.alert-success').delay(500).show(10, function() {
              $(this).delay(2000).hide(10, function() {
              $(this).remove();
              });
            });
            }else{
              $.each(response.messages, function(key, value) {
                var element = $('#' + key);
                element.closest('div.form-group')
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