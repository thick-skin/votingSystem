<div style="display: inline-flex;">
  <h4 class="text-success text-uppercase" id="year"></h4>
</div>
<!-- <span class="glyphicon glyphicon-print pull-right"></span><br> -->
  <?php if ($votes && $candidates && $seats): ?>
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
  <script>
    var value = $('select#eYear').val();
    $('h4#year').text('Currently showing results for the year '+value);

    $('table tr:nth-child(1) td:nth-child(3)').html('<span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span>');
  </script>