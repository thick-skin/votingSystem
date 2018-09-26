<style>
  tbody td:nth-child(1):hover{
    cursor: pointer;
    background-color: lightgrey;
  }
  h4.alert{
    background-color: #fafad2;
    font-family: Verdana;
  }
  span.glyphicon-star{
    color: #daa520;
  }
</style>
<div class="well">
  <span class="glyphicon glyphicon-print pull-right"></span><br>
  <?php if ($votes): ?>
  <?php foreach ($seats as $seat): ?>
  <h5 class="text-uppercase alert alert-info"><span class="text-primary glyphicon glyphicon-tag"></span><strong><?php echo $seat['name']; ?></strong></h5>  
    <table id="tabss-<?php echo $seat['name']; ?>" class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th>Candidate</th>
        <th>Votes</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($votes as $vote): ?>
<?php if ($seat['name'] == $vote['seat']): ?>
  <?php foreach ($candidates as $candidate): ?>
    <?php if ($candidate['uname'] == $vote['candidate']): ?>
      <tr class="text-warning text-capitalize">
        <td><a href="#"><?php echo $vote['candidate']; ?><p>(<?php echo $candidate['first_name']." ".$candidate['last_name']." ".$candidate['other_name']; ?>)</p></a></td>
        <td><?php echo $vote['total']; ?></td>
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
              
    $('table tr:nth-child(1) td:nth-child(3)').html('<span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span>');

  });
</script>