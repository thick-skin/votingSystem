    </div>
  <?php if($title == "About"): ?>
<div style="position: fixed; bottom:0; width: 100%;">
	<div style="background-color: lightgrey; padding: 2vh 3vh;">
		<form>
			<div class="form-group" style="display: inline-flex; width: 70%;">
			<input class="form-control" type="text" name="" placeholder="Write your complaints here..." style="border-radius: 20px; height: 7vh; margin-right: 5px;">
			<button type="button" class="btn btn-info" style="border-radius:30px; width:7vh; height: 7vh;"><i class="glyphicon glyphicon-chevron-right glyphicon-align-center"></i></button>
			</div>
		</form>
	</div>
</div>
  <?php endif; ?>
  </body>
  <script>
   $(document).ready(function() {
    var candidate = $('input#candidate').attr('value');
    var offset = 0;
    var html = '';
    var limit;
    limit = 2;

 function countChar(val) {
        var len = val.value.length;
        if (len >= 300) {
          val.value = val.value.substring(0, 300);
        } else {
          $('i#campCount').text(300 - len);
        }
      };
  $('textarea#campaign').keyup(function () {
    countChar(this);
  });
/////////////////REMOVE FLASH DATA AFTER SECONDS///////////////////
    $('#flashdata').delay(500).show(10, function() {
      $(this).delay(2000).hide(10, function() {
        $(this).remove();
      });
    });
//////////////END REMOVE////////////////////////////

/////////////WEBSITE LOGO ANIMATION/////////////////
    $("#small").fadeIn(2000);
    $("h1#logo").mouseenter(function() {
      $("i#small").animate({
        left: 100
      });
    });
    $("h1#logo").mouseleave(function() {
      $("i#small").animate({
        left: 0
      });
    });
//////////LOGO ANIMATION ENDS/////////////////

/////////SHOW/HIDE POST CAMPAIGN INTERFACE BUTTON//////////////////
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
/////////CAMPAIGN BUTTON END////////////////////

    showCampaign();
function showAllComments(camp_id) {
  
$('button#showAllComments-'+camp_id+'').click(function () {
  $('div#showAllComments-'+camp_id+'').html('<p>Loading...</p>');
  limit = 10000;
  showComments(camp_id);
  $('div#showAllComments-'+camp_id+'').html('<button type="button" id="showLessComments-'+camp_id+'" class="btn btn-link">Show less comments.</button>');
  limit = 2;
showLessComments(camp_id);
});
}

function showLessComments(camp_id) {

$('button#showLessComments-'+camp_id+'').click(function () {
  $('div#showAllComments-'+camp_id+'').html('<p>Loading...</p>');
  limit = 2;
  showComments(camp_id);
  $('div#showAllComments-'+camp_id+'').html('<button type="button" id="showAllComments-'+camp_id+'" class="btn btn-link">Show all comments.</button>');
showAllComments(camp_id);
});
}

/////////////////SUBMIT CAMPAIGN///////////////////////////////////
  $("#campaign-user").submit(function(e) {
    e.preventDefault();

    var me = $(this);
    var campaignNameValue = $('input#user').val();
    candidate = $('input#candidate').attr('value');
    campaignNameValue = campaignNameValue.toLowerCase().replace(/\b[a-z]/g, function(letter) {
    return letter.toUpperCase();
    });
    //alert(campaignNameValue);


    function scrollUPP() {
      if (candidate == 'Home') {
            showFirstCampaign();
            jQuery('html,body').animate({scrollTop:0},0);
          }else if (candidate == campaignNameValue) {
            showFirstCampaign();
            jQuery('html,body').animate({scrollTop:0},0);
          }
    }

      //perform ajax
      $.ajax({
        url: me.attr('action'),
        type: 'post',
        data: me.serialize(),
        dataType: 'json',
        success: function(response) {
          if (response.success == true) {
            // success message and remove class
            $('#showmessage').append('<p class="alert alert-success">'+'Campaign updated!'+'</p>');
            $('.form-group').removeClass('has-error')
            .removeClass('has-success');
            $('.text-danger').remove();

            // reset the form
            me[0].reset();

            scrollUPP();
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
////////////////////////SUBMIT CAMPAIGN ENDS HERE/////////////////////////

/////////////////////////SHOW FIRST CAMPAIGN//////////////////////////////
function showFirstCampaign() {
  var camp_id;
  var htm = '';
  $.ajax({
        type: 'ajax',
        method: 'get',
        data: {candidate: candidate},
        url: '<?php echo base_url(); ?>pages/showFirstCampaign',
        async: false,
        dataType: 'json',
        success: function(data) {
            var i, campaign, user_seat, username;
            for (i = 0; i < data.length; i++) {
             jQuery.nl2br = function(varTest){
               return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
             };
             campaign = $.nl2br(data[i].campaign);
             user_seat = data[i].user_seat;
             camp_id = data[i].id;
             username = data[i].username;

             htm += '<div id="campaignFeed-'+camp_id+'" class="well campaignFeed">'+
             '<h4>@ <b><a href="<?php echo base_url(); ?>pages/candidatePersonal/'+username+'">'+username+'</a></b> <small style="float: right;">'+data[i].created_date+'</small><br>'+
             '<small>Running for: <a href="<?php echo base_url(); ?>users/candidates#'+user_seat+'">'+user_seat+
             '</a></small>'+
             '</h4>'+
             '<p style="color: #556b2f;">'+
             '<i>'+campaign+'</i></p>'+
             '<button type="button" id="say" class="btn btn-default btn-block" data-toggle="collapse" data-target="#comment-'+camp_id+'" style="border-radius: 20px; border: 1px solid grey; text-decoration:none;">'+
             'Say something.. <i class="glyphicon glyphicon-comment"></i>'+
             '</button><br>'+
             '<div id="comment-'+camp_id+'" class="collapse">'+
             '<form id="commentSection-'+camp_id+'" data="'+camp_id+'" action="<?php echo base_url(); ?>pages/addComment" method="POST">'+
             '<input type="hidden" name="campaignid" value="'+camp_id+'"/>'+
             '<div id="comErr" class="form-group"><input style="border-radius: 20px;" type="text" class="form-control" name="commentName-'+camp_id+'" id="commentName-'+camp_id+'" placeholder=" Name" autofocus></div>'+
             '<div id="comErr" class="form-group"><textarea style="border-radius: 50px;" type="text" class="form-control" name="commentBody-'+camp_id+'" id="commentBody-'+camp_id+'" placeholder="  Comment"></textarea></div>'+
             '<button type="submit" class="btn btn-default" style="border-radius: 50px;">OK</button>'+
             '</form><br>'+
             '</div><div id="commentMessage-'+camp_id+'"></div>'+
             '<div id="comments-'+camp_id+'">'+
             '</div>'+
             '<div id="showAllComments-'+camp_id+'">'+
             '<button type="button" id="showAllComments-'+camp_id+'" data="-'+camp_id+'" class="btn btn-link">Show all comments.</button>'+
             '</div>'+
             '</div>';
           }
        $('.showdata').prepend(htm);
        for (i = 0; i < data.length; i++) {
          camp_id = data[i].id;
          showComments(camp_id);
          submitComment(camp_id);
          showAllComments(camp_id);
          offset = offset + 1;
        }
        },
        error: function () {
          alert('Cannot fetch first campaign');
        }
  });
}
//////////////////////////FIRST CAMP END///////////////////////////////////

//////////////////////SHOW CAMPAIGN FUNCTION/////////////////////////////////
    function showCampaign() {
      var camp_id;
      html = '';
      offset = 0;
      $.ajax({
        type: 'ajax',
        method: 'get',
        data: {candidate: candidate},
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
             '<h4>@ <b><a href="<?php echo base_url(); ?>pages/candidatePersonal/'+username+'">'+username+'</a></b> <small style="float: right;">'+data[i].created_date+'</small><br>'+
             '<small>Running for: <a href="<?php echo base_url(); ?>users/candidates#'+user_seat+'">'+user_seat+
             '</a></small>'+
             '</h4>'+
             '<p style="color: #556b2f;">'+
             '<i>'+campaign+'</i></p>'+
             '<button type="button" id="say" class="btn btn-default btn-block" data-toggle="collapse" data-target="#comment-'+camp_id+'" style="border-radius: 20px; border: 1px solid grey; text-decoration:none;">'+
             'Say something.. <i class="glyphicon glyphicon-comment"></i>'+
             '</button><br>'+
             '<div id="comment-'+camp_id+'" class="collapse">'+
             '<form id="commentSection-'+camp_id+'" data="'+camp_id+'" action="<?php echo base_url(); ?>pages/addComment" method="POST">'+
             '<input type="hidden" name="campaignid" value="'+camp_id+'"/>'+
             '<div id="comErr" class="form-group"><input style="border-radius: 20px;" type="text" class="form-control" name="commentName-'+camp_id+'" id="commentName-'+camp_id+'" placeholder=" Name" autofocus></div>'+
             '<div id="comErr" class="form-group"><textarea style="border-radius: 50px;" type="text" class="form-control" name="commentBody-'+camp_id+'" id="commentBody-'+camp_id+'" placeholder="  Comment"></textarea></div>'+
             '<button type="submit" class="btn btn-default" style="border-radius: 50px;">OK</button>'+
             '</form><br>'+
             '</div><div id="commentMessage-'+camp_id+'"></div>'+
             '<div id="comments-'+camp_id+'">'+
             '</div>'+
             '<div id="showAllComments-'+camp_id+'">'+
             '<button type="button" id="showAllComments-'+camp_id+'" data="-'+camp_id+'" class="btn btn-link">Show all comments.</button>'+
             '</div>'+
             '</div>';
           }
        $('div.showdata').html(html);
        $('div#load-more').html('<button type="button" class="btn btn-sm btn-primary load-more">Scroll down to load more...</button>');
        for (i = 0; i < data.length; i++) {
          camp_id = data[i].id;
          showComments(camp_id);
          submitComment(camp_id);
          showAllComments(camp_id);
        }
        }else{
        $('div#load-more').html('<p class="text-center">Nothing to show here.</p>');
        }
      },
      error: function() {
        alert('Could not get database data!');
      }
    });           
    }
//////////////////////SHOW CAMPAIGN FUNCTION ENDS/////////////////////////////////////

/////////MORE CAMPAIGN//////////////////////
$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
  var camp_id;
  offset = offset + 2;
  var html = '';
  $('div#load-more').html('<p>Loading campaign...<p class="loader"></p></p>');
  $.ajax({
        type: 'ajax',
        method: 'get',
        url: '<?php echo base_url(); ?>pages/showMoreCampaign',
        data: {offset: offset, candidate: candidate},
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
             '<h4>@ <b><a href="<?php echo base_url(); ?>pages/candidatePersonal/'+username+'">'+username+'</a></b> <small style="float: right;">'+data[i].created_date+'</small><br>'+
             '<small>Running for: <a href="<?php echo base_url(); ?>users/candidates#'+user_seat+'">'+user_seat+
             '</a></small>'+
             '</h4>'+
             '<p style="color: #556b2f;">'+
             '<i>'+campaign+'</i></p>'+
             '<button type="button" id="say" class="btn btn-default btn-block" data-toggle="collapse" data-target="#comment-'+camp_id+'" style="border-radius: 20px; border: 1px solid grey; text-decoration:none;">'+
             'Say something.. <i class="glyphicon glyphicon-comment"></i>'+
             '</button><br>'+
             '<div id="comment-'+camp_id+'" class="collapse">'+
             '<form id="commentSection-'+camp_id+'" data="'+camp_id+'" action="<?php echo base_url(); ?>pages/addComment" method="POST">'+
             '<input type="hidden" name="campaignid" value="'+camp_id+'"/>'+
             '<div id="comErr" class="form-group"><input style="border-radius: 20px;" type="text" class="form-control" name="commentName-'+camp_id+'" id="commentName-'+camp_id+'" placeholder=" Name" autofocus></div>'+
             '<div id="comErr" class="form-group"><textarea style="border-radius: 50px;" type="text" class="form-control" name="commentBody-'+camp_id+'" id="commentBody-'+camp_id+'" placeholder="  Comment"></textarea></div>'+
             '<button type="submit" class="btn btn-default" style="border-radius: 50px;">OK</button>'+
             '</form><br>'+
             '</div><div id="commentMessage-'+camp_id+'"></div>'+
             '<div id="comments-'+camp_id+'">'+
             '</div>'+
             '<div id="showAllComments-'+camp_id+'">'+
             '<button type="button" id="showAllComments-'+camp_id+'" class="btn btn-link">Show all comments.</button>'+
             '</div>'+
             '</div>';
           }
        $('.showdata').append(html);
        $('div#load-more').html('<button type="button" class="btn btn-sm btn-primary load-more">Scroll down to load more...</button>');
        for (i = 0; i < data.length; i++) {
          camp_id = data[i].id;
          showComments(camp_id);
          submitComment(camp_id);
          showAllComments(camp_id);
        }
        }else{
        //  html = '<p class="text-center">Nothing to show here.</p>';
        $('div#load-more').html('<button type="button" class="btn btn-sm btn-primary load-more">Nothing more to load.</button>');
        }
        //html = '';
        },
        error: function () {
          alert('Cannot fetch remaining campaign');
        }
  });
}
});
/////////MORE CAMPAIGN ENDS//////////////////////

////////////////////////SHOW COMMENTS FUNCTION//////////////////////////////////////
  function showComments(camp_id) {
   // limit = limit;
      $.ajax({
        type: 'ajax',
        method: 'get',
        url: '<?php echo base_url(); ?>pages/showComments',
        data: {camp_id: camp_id, limit: limit},
        async: false,
        dataType: 'json',
        success: function(data) {
         var html = '';
         if (data.length > 0) {
          var i;
          for (i = 0; i < data.length; i++) {
            jQuery.nl2br = function(varTest){
              return varTest.replace(/(\r\n|\n\r|\r|\n)/g, "<br>");
            };            var comment = $.nl2br(data[i].comment_body);

            html += '<p id="campaign">'+
            '<small><b>'+data[i].name+' <i>'+data[i].comment_time+'</i></b></small><br>'+
            comment+
            '</p>';
          }
                                //$('div#comments').html(html);
                              }else{
                                html += '<p class="text-center">Be the first to comment.</p>';
                              }

                              $('div#comments-'+camp_id).html(html);
                            },
                            error: function() {
                              alert('Could not get comments!');
                            }
                          });
    }
////////////////////////SHOW COMMENTS FUNCTION ENDS////////////////////////////////

//////////////////////COMMENT SUBMIT STARTS HERE//////////////////////
function submitComment(camp_id) {
    $("form#commentSection-"+camp_id).submit(function(camp_id) {
      camp_id.preventDefault();

      var me = $(this);
      var camp_id = $(this).attr('data');

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
              showComments(camp_id);
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
///////////////////////////COMMENT SUBMIT ENDS HERE////////////////////////////////

//////////////////////////////VOTER LOGIN START HERE////////////////////////////////////////
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
/////////////////////VOTER LOGIN ENDS HERE////////////////////////////

});
</script>
</html>