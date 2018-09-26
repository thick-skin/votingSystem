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
  tbody tr:hover{
    cursor: pointer;
    background-color: lightgrey;
  }
  h4.alert{
    background-color: #fafad2;
    font-family: Verdana;
  }
  </style>
<div class="col-sm-4 myDeleteClass">
  <h4 class="alert text-center">CREATE SEAT</h4>
  <i class="text-danger"><small>NB: If there is no candidate under any post, delete the post before election day, else the voters won't be able to cast there votes.</small></i>
  <div id="the-message"></div>
<?php echo form_open('users/dashB', array("id" => "form-user")); ?>
<div class="form-group">
  <input type="text" class="form-control" name="name" id="name" placeholder="Post name">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form><br>
<?php if ($seats): ?>
<table id="showdata" class="table table-responsive">
  
</table>
  <?php else: ?>
      <h4>You have not added any seat yet.</h4>
  <?php endif; ?>

</div>
<div class="col-sm-4">
  <h4 class="alert text-center">ELECTION RESULTS</h4>
<div class="well">
  <?php if ($votes): ?>
  <?php foreach ($seats as $seat): ?>
  <h5 class="text-uppercase bg-info"><span class="text-primary glyphicon glyphicon-tag"></span><strong><?php echo $seat['name']; ?></strong></h5>  
    <table class="table table-condensed">
    <thead>
      <tr>
        <th>Candidate</th>
        <th>Votes</th>
      </tr>
    </thead>
    <?php foreach ($votes as $vote): ?>
<?php if ($seat['name'] == $vote['seat']): ?>
    <tbody>
      <tr class="text-warning text-capitalize">
        <td><?php echo $vote['candidate']; ?></td>
        <td><?php echo $vote['total']; ?></td>
      </tr>
    </tbody>
<?php endif; ?>
    <?php endforeach; ?>
  </table>
  <?php endforeach; ?>
  <?php else: ?>
      <h4>No Results Yet.</h4>
  <?php endif; ?>
  <br>
  <div id="the-result"></div>
  <a href="#" data-toggle="modal" data-target="#electionResult" class="btn btn-block btn-default">RELEASE RESULTS</a><br>
  <a href="<?php echo base_url(); ?>vote/hideResults" class="btn btn-block btn-primary">HIDE RESULTS</a>
  <div class="modal fade" id="electionResult" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 0;">
      <div class="modal-header">
        <h3>Are you sure you want to release results?</h3>
      </div>
      <div class="modal-body">
        <h4>Note that this action cannot be undone.</h4>
      </div>
      <div class="modal-footer">
      <a href="<?php echo base_url(); ?>vote/releaseResult" id="release" class="btn btn-success">Release</a>
      <a href="#" class="btn btn-danger" data-dismiss="modal">Cancel</a>
      </div>
    </div>                
  </div>              
</div>
</div>
</div>
  <div class="col-sm-4 well">
    <form>
      <div class="form-group">
      <textarea class="form-control" placeholder="ANNOUNCEMENTS"></textarea>
      </div>
      <button class="btn btn-block btn-info">ANNOUNCE</button>
    </form>
  </div>
<script>
    $(document).ready(function() {
      
      showSeat();

      $('div a#release').click(function(e) {
        e.preventDefault();
        $.ajax({
          type: 'ajax',
          url: $('div a#release').attr('href'),
          async: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == true) {
              $('#electionResult').modal('hide');
              $('.alert-success').remove();
            $('#the-result').append('<p class="alert alert-success">'+'Results released!'+'</p>');
          }
          },
          error: function() {
            alert('Could not release results!');
          }
        });
      });

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
    								'<td style="padding: 5px 5px;"><a href="<?php echo base_url(); ?>users/candidates#'+data[i].name+'">'+data[i].name+'</a></td>'+
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