<style>
	/*div.row{
		margin-right: 4vh;
		background: url('<?php// echo base_url(); ?>assets/img/votesmart.jpg'); 
		background-size: cover; 
		background-repeat: no-repeat; 
		background-attachment: fixed;
	}*/
	div.col-sm-6{
	/*	padding-top: 5vh;*/
		padding-bottom: 5vh;
	}
	div.well {
		border: 2px solid #ffe4b5;
		border-radius: 0%;
		background-color: #fff8dc;
	}
	label#candidate, h3 {
		font-weight: bold;
		
		font-family: arial;
		color: #2f4f4f
	}
	.btn-vote{
		border-radius: 0%;
	}
</style>
<div class="row">
	<div id="voted"><?php //echo validation_errors(); ?></div>
	<div class="col-sm-offset-2 col-sm-6">
	<?php echo form_open('vote/ballot', array("id" => "voteform")); ?>
		<?php
			$num = 0;
		 foreach ($seats as $seat):
		 $num++; 
		 	?>
		<h3><?php echo $seat['name']; ?></h3>

		<div id="err" class="well seats">
		
				
		<?php foreach ($candidates as $candidate): ?>
		<?php if ($seat['name'] == $candidate['seat']): ?>
		<div class="radio">
	      <label id="candidate"><input type="radio" name="seat-<?= $num; ?>" id="seat-<?= $num; ?>" value="<?php echo $candidate['uname'] ?>" ><?php echo $candidate['first_name'].' '.$candidate['last_name'].' '.$candidate['other_name']; ?></label>
		
	    </div>
		<?php endif; ?>
		<?php endforeach; ?>

  		</div>
		<?php endforeach; ?>
	<div id="voted"></div>
		<button type="submit" class="btn btn-lg btn-success btn-vote">Vote <span class="glyphicon glyphicon-check"></span></button>
  	</form>
	</div>
	
	<div class="col-sm-4">
		
	</div>
</div>
<script>
	$(document).ready(function () {
		$("#voteform").submit(function(e) {
        e.preventDefault();

        var me = $(this);
        //var formData = new FormData($(this)[0]);

        //perform ajax
        $.ajax({
          	url: me.attr('action'),
          	dataType: 'json',
         	type: 'post',
         	async: false,
			data: me.serialize(),
			dataType: 'json',
          success: function(response) {
           if (response.status == true) {
              console.log(response);

              var html = '';

              html += '<div class="well bg-info"><h3>Thanks for voting.</h3>'+
						'<h4>Your details are no longer on our records, so you cannot vote again<br>'+
						'Results will be published at (get time from database here)</h4>'+
                      '<a class="btn btn-primary" href="<?php echo base_url(); ?>">Exit</a></div>';
            
          $('div.col-sm-6').html(html);
          $('div#mySidenav, ul.navbar-right').html('');

            }else{
              $.each(response.messages, function(key, value) {
                var element = $('#' + key);
                element.closest('div#err')
                .removeClass('has-error')
                .addClass(value.length > 0 ? 'has-error' : 'has-success')
                .find('.text-danger')
                .remove();
                element.before(value);
              });
            }
          }
        });
      });
	});
</script>