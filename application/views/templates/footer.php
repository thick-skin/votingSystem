		</div>
	</body>
	<script>
	$(document).ready(function() {
	$("#small").fadeIn(2000);
	$("h1").hover(function() {
		$("#small").fadeToggle();
	});

	$('div.dropup button').on('click', function (event) {
    $(this).parent().toggleClass('open');
});
	$('body').on('click', function (e) {
    if (!$('div.dropup').is(e.target) 
        && $('div.dropup').has(e.target).length === 0 
        && $('.open').has(e.target).length === 0
    ) {
        $('div.dropup').removeClass('open');
    }
});

	showCampaign();

	$("#campaign-user").submit(function(e) {
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
            	showCampaign();
              // success message and remove class
              $('#showmessage').append('<p class="alert alert-success">'+'Campaign updated!'+'</p>');
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
            }else if(response.error === true) {
            	     // error message and remove class
          //If you encounter any problem here write div before the #showmessage and you may change .form-group to an id and write div before it 
              $('#showmessage').append('<p class="alert alert-danger">'+'Incorrect username/password!'+'</p>');
              $('.form-group').removeClass('has-error')
                       .removeClass('has-success');
              $('.text-danger').remove();

              // reset the form
              //me[0].reset();

              // close the message after seconds
              $('.alert-danger').delay(500).show(10, function() {
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
		function showCampaign() {
    		$.ajax({
    			type: 'ajax',
    			url: '<?php echo base_url(); ?>pages/showCampaign',
    			async: false,
    			dataType: 'json',
    			success: function(data) {
    				var html = '';
    				var i;
    				for (i = 0; i < data.length; i++) {
    					jQuery.nl2br = function(varTest){
					    return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
};
    					var campaign = $.nl2br(data[i].campaign);
    					
    					html += '<div id="campaignFeed" class="well" style="background-color: #fffacd; border-radius: 0%;">'+
    								'<h4>@ <b>'+data[i].username+'</b> <sub style="float: right;">'+data[i].created_date+'</sub><br>'+
    								'<small>Running for: '+data[i].user_seat+
    								'</small>'+
    								'</h4>'+
    								'<p style="color: #556b2f;">'+
    								'<i>'+campaign+'</i></p>'+
                    '<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#comment-'+data[i].id+'" style="border-radius: 0; background-color: #fffacd; text-decoration:none;">'+
                    'Say something.. <i class="glyphicon glyphicon-comment"></i>'+
                    '</button><br>'+
                    '<div id="comment-'+data[i].id+'" class="collapse">'+
                    '<form action="" method="POST">'+
                    '<input type="hidden" name="campaignid" value="'+data[i].id+'"/>'+
                    '<div class="form-group"><input style="background: transparent;" type="text" class="form-control" name="" placeholder="Name" autofocus></div>'+
                    '<div class="form-group"><textarea style="background: transparent;" type="text" class="form-control" name="" placeholder="Comment"></textarea></div>'+
                    '<button type="submit" name="changepwd" class="btn btn-sm btn-default">OK</button>'+
                    '</form><br>'+
                    '</div>'+
                    '<blockquote>'+
                    '<i>Casper <sub>10:14pm</sub></i>'+
                    '<small>For 50 years, WWF works in 100 countries and is supported by 1.2 million members in the United States and close to 5 million globally.</small>'+
                    '</blockquote>'+
                    '</div>';
    				}
  				$('.showdata').html(html);

    			},
    			error: function() {
    				alert('Could not get database data!');
    			}
    		});
    	}

	});
</script>
</html>