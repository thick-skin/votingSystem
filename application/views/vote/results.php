<style>
  tbody td:nth-child(2) a#voteNumber:hover{
    border-radius: 0;
    font-weight: bolder;
    font-size: 20px;
    background-color: darkgrey;
  }
  h4.alert{
    background-color: #fafad2;
    font-family: Verdana;
  }
  span.glyphicon-star{
    color: #daa520;
  }
</style>
<div class="row">
<div class="form-group col-sm-2" id="eYear" style="display: inline-flex;">
    <label>Election Year</label>
    <select name="eYear" id="eYear" class="form-control" data-native-menu="false">
     
      <?php $year = date("Y"); for ($i=$year; $i > 2017; $i--): ?>  
      <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
      <?php endfor; ?>
      <option value="2017">2017</option>
        
    </select>
  </div>
</div>
<div class="well col-sm-offset-1 col-sm-10 res" style="text-align: center; background-color: white; border-radius: 0; box-shadow: 0 0 5px 2px grey;">
<div style="display: inline-flex;">
  <h4 class="text-success text-uppercase" id="year">Currently showing results for the year <?php echo date("Y"); ?></h4>
</div>
  <!-- <span class="glyphicon glyphicon-print pull-right"></span><br> -->
  <?php if ($votes): ?>
  <?php foreach ($seats as $seat): ?>
  <h5 class="text-uppercase alert alert-info"><span class="text-primary glyphicon glyphicon-tag"></span><strong><?php echo $seat['name']; ?></strong></h5>  
    <table id="resultTable" class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Candidate</th>
        <th>Votes (Click to see details)</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($votes as $vote): ?>
<?php if ($seat['name'] == $vote['seat']): ?>
  <?php foreach ($candidates as $candidate): ?>
    <?php if ($candidate['uname'] == $vote['candidate']): ?>
      <tr class="text-warning text-capitalize">
        <td><?php echo $vote['candidate']; ?><p>(<?php echo $candidate['first_name']." ".$candidate['last_name']." ".$candidate['other_name']; ?>)</p></td>
        <td><a href="<?php echo base_url(); ?>vote/voteDetails" id="voteNumber" text="<?php echo $vote['total']; ?>" data2="<?php echo $candidate['image']; ?>" data="<?php echo $vote['candidate']; ?>" class="btn btn-block"><?php echo $vote['total']; ?></a>
<div class="modal fade" id="voteDetails" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 0; background-color: darkslategrey;">
        <a href="#" class="btn btn-lg close" data-dismiss="modal">&times;</a>
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <h4></h4>
      </div>
    </div>                
  </div>              
</div>
        </td>
        <td id="winner"></td>
      </tr>
    <?php endif; ?>
  <?php endforeach; ?>
<?php endif; ?>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endforeach; ?>
  <?php else: ?>
      <h4>No Results Yet.</h4>
  <?php endif; ?>
</div>
<script>
  $(document).ready(function () {

    $('select#eYear').change(function () {
      var value = $(this).val();
      //alert(value);
      $("div.res").html('<i class="fa fa-spinner fa-spin" style="color:silver; font-size:50px;"></i>');
      $('div.res').load('<?php echo base_url(); ?>vote/yearResult/'+value+'', {
        value: value
      });
      //window.history.pushState("string", "Title", "yearResult/"+value);
      
/////////////////////REVIEW THIS/////////////////////////////////////////////////////////
//       var href = $('a.somelink').attr('href'); //jQuery not necessary
// history.pushState({},href,href); //change URL without reload
// //put this in your ajax page change callback or something
    });
              
    $('table tr:nth-child(1) td:nth-child(3)').html('<span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span>');

    $('div.res').on('click', '#voteNumber', function (ev) {
      ev.preventDefault();
      var act = $(this).attr('href');
      var candidate = $(this).attr('data');
      var image = $(this).attr('data2');
      var numVotes = $(this).attr('text');

            var head = '';
            head += '<div class="row">'+
                    '<div class="col-sm-6">'+
                    '<img style="height:100%; width:100%;" src="<?php echo site_url(); ?>assets/img/candidates/'+image+'">'+
                    '</div>'+
                    '<div class="col-sm-6">'+
                    '<div class="well" style="font-weight:bolder; border:none; border-radius:0;"><h4>'+candidate+'</h4>'+
                    '<p>Total votes: '+numVotes+'</p></div>'+
                    '</div>'+
                    '</div>';
      $("#voteDetails").modal('show');
      $("#voteDetails").find('.modal-header').html(head);
      $("#voteDetails").find('.modal-body').html('<i class="fa fa-circle-o-notch fa-spin" style="color:silver; font-size:50px;"></i>');      
      $.ajax({
        type: 'ajax',
        method: 'get',
        url: '<?php echo base_url(); ?>vote/voteDetails',
        data: {candidate: candidate},
        async: false,
        dataType: 'json',
        success: function(data){
          var html =  '<table id="deptVotes" class="table table-bordered table-responsive">'+
                      '<tr>'+
                      '<th>Department</th>'+
                      '<th>No. of votes</th>'+
                      '</tr>';
            var i;
            for (i = 0; i < data.length; i++) {
          html += '<tr>'+
                  '<td>'+data[i].dept+'</td>'+
                  '<td>'+data[i].total+'</td>'+
                  '</tr>';
            }
            html += '</table>';

      $("#voteDetails").find('.modal-body').html(html);
        },
        error: function () {
          alert('Could not get details');
        }
      });

    });

  });
</script>