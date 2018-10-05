		</div>
	</body>
	<script>
	$(document).ready(function() {

      $('#flashdata').delay(500).show(10, function() {
              $(this).delay(2000).hide(10, function() {
              $(this).remove();
              });
            });

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
      var camp_id;
            var html = '';
        $.ajax({
          type: 'ajax',
          url: '<?php echo base_url(); ?>pages/showCampaign',
          async: false,
          dataType: 'json',
          success: function(data) {
            if (data.length > 0) {
            var i, campaign, user_seat, username;
    				for (i = 0; i < data.length; i++) {
    					jQuery.nl2br = function(varTest){
					    return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
};
    					 campaign = $.nl2br(data[i].campaign);
    					 user_seat = data[i].user_seat;
               camp_id = data[i].id;
               username = data[i].username;

    					html += '<div id="campaignFeed-'+camp_id+'" class="well campaignFeed">'+
    								'<h4>@ <b>'+username+'</b> <small style="float: right;">'+data[i].created_date+'</small><br>'+
    								'<small>Running for: <a href="<?php echo base_url(); ?>users/candidates#'+user_seat+'">'+user_seat+
    								'</a></small>'+
    								'</h4>'+
    								'<p style="color: #556b2f;">'+
    								'<i>'+campaign+'</i></p>'+
                    '<button type="button" id="say" class="btn btn-default btn-block" data-toggle="collapse" data-target="#comment-'+camp_id+'" style="border-radius: 20px; background-color: white; border: 1px solid grey; text-decoration:none;">'+
                    'Say something.. <i class="glyphicon glyphicon-comment"></i>'+
                    '</button><br>'+
                    '<div id="comment-'+camp_id+'" class="collapse">'+
                    '<form id="commentSection" data="'+camp_id+'" action="<?php echo base_url(); ?>pages/addComment" method="POST">'+
                    '<input type="hidden" name="campaignid" value="'+camp_id+'"/>'+
                    '<div id="comErr" class="form-group"><input style="border-radius: 20px;" type="text" class="form-control" name="commentName-'+camp_id+'" id="commentName-'+camp_id+'" placeholder=" Name" autofocus></div>'+
                    '<div id="comErr" class="form-group"><textarea style="border-radius: 50px;" type="text" class="form-control" name="commentBody-'+camp_id+'" id="commentBody-'+camp_id+'" placeholder="  Comment"></textarea></div>'+
                    '<button type="submit" name="changepwd" class="btn btn-default" style="border-radius: 50px;">OK</button>'+
                    '</form><br>'+
                    '</div><div id="commentMessage-'+camp_id+'"></div>'+
                    '<div id="comments">';
                    showComments();
            html += '</div>'+
                    '</div>';
            }
          $('.showdata').html(html);
          //showComments();
        }else{
          html = '<p class="text-center">Nothing to show here.</p>';
          $('.showdata').html(html);
        }
          },
          error: function() {
            alert('Could not get database data!');
          }
        });

                    function showComments() {
                      
                    $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '<?php echo base_url(); ?>pages/showComments',
                        data: {camp_id: camp_id},
                        async: false,
                        dataType: 'json',
                        success: function(data) {
                          //var comm = '';
                                if (data.length > 0) {
                                var i;
                                for (i = 0; i < data.length; i++) {
                                  jQuery.nl2br = function(varTest){
                                  return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
                    };            var comment = $.nl2br(data[i].comment_body);
                      
                                  html += '<p id="campaign">'+
                                          '<b>'+data[i].name+' <sub>'+data[i].comment_time+'</sub></b><br>'+
                                          '<small>'+comment+'</small>'+
                                          '</p>';
                                }
                               }else{
                              html += '<p class="text-center">Be the first to comment.</p>';
                            }

                          //$('div#comments').html(comm);
                          },
                              error: function() {
                                alert('Could not get comments!');
                              }
                      });
                    }
         $("form#commentSection").submit(function(e) {
        e.preventDefault();

        var me = $(this);
        camp_id = $(this).attr('data');

        //perform ajax
        $.ajax({
          url: me.attr('action'),
          type: 'post',
          data: me.serialize(),
          dataType: 'json',
          success: function(response) {
            if (response.success == true) {
              $('div#comment-'+camp_id).collapse('hide');
              // success message and remove class
              $('div#commentMessage-'+camp_id).append('<p class="alert alert-success">'+'Comment acknowledged!'+'</p>');
              $('div#comErr').removeClass('has-error')
                       .removeClass('has-success');
              $('.text-danger').remove();

              // reset the form
              me[0].reset();

              // close the message after seconds
              $('.alert-success').delay(1000).show(10, function() {
              $(this).delay(5000).hide(10, function() {
              $(this).remove();
              });
            });
              $.ajax({
                        type: 'ajax',
                        method: 'get',
                        url: '<?php echo base_url(); ?>pages/showComments',
                        data: {camp_id: camp_id},
                        async: false,
                        dataType: 'json',
                        success: function(data) {
                          var comm = '';
                                if (data.length > 0) {
                                var i;
                                for (i = 0; i < data.length; i++) {
                                  jQuery.nl2br = function(varTest){
                                  return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
                    };            var comment = $.nl2br(data[i].comment_body);
                      
                                  comm += '<p id="campaign">'+
                                          '<b>'+data[i].name+' <sub>'+data[i].comment_time+'</sub></b><br>'+
                                          '<small>'+comment+'</small>'+
                                          '</p>';
                                }
                               }else{
                              comm += '<p class="text-center">Be the first to comment.</p>';
                            }

                          $('div#campaignFeed-'+camp_id).find('div#comments').html(comm);
                          },
                              error: function() {
                                alert('Could not get comments!');
                              }
                      });
            }else{
              $.each(response.messages, function(key, value) {
                var element = $('#' + key);
                element.closest('div#comErr')
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
      }
      
$("#voter-login").submit(function(e) {
        e.preventDefault();

        var me = $(this);

        //perform ajax
        $.ajax({
          url: me.attr('action'),
          type: 'post',
          data: me.serialize(),
          dataType: 'json',
          success: function(response, data) {
            if (response.success == true) {
              var html = '';

              html += '<div class="well bg-info"><h3>Welcome!<br>'+
                      'Please note that you are now logged in.</h3>'+
                      '<strong>Read This:</strong>'+
                      '<p>Be sure of the candidates you choose before submitting.<br>'+
                      'You will not be able to log in and vote again once you click the vote button.<br>'+
                      'Click the <b>Continue</b> button to continue or <br>'+
                      'Click the <b>Cancel</b> button to cancel and log out.</p>'+
                      '<a class="btn btn-sm btn-success" href="<?php echo base_url(); ?>vote/index">Continue</a> '+
                      '<a class="btn btn-sm btn-danger" href="<?php echo base_url(); ?>users/logoutVoter">Cancel</a></div>';
            
          $('div.modal-body').html(html);
          $('div#top, a.navbar-brand, a#home, a#about, a#admin, button.dropdown-toggle').remove();
           
            }else if(response.error === true) {
              console.log(response);
                   // error message and remove class
              $('#votermessage').append('<p class="alert alert-danger">'+'Incorrect RegNo/VoteKey!'+'</p>');
              $('div#vote-err').removeClass('has-error')
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
                element.closest('div#vote-err')
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
</html>