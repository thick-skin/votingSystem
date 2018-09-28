	<style>
		.col-sm-3{
				position: sticky; 
				top: 70px;
	}
	@media screen and (max-height: 560px) {
		.col-sm-3{position: initial;}
	}
	a li#visit:hover {
    background-color: lightgrey;
}
	</style>
<button id="scrolltop" class="btn btn-info" type="button" style="width: 40px; height: 40px; text-align: center; border-radius: 20px; position: fixed; right: 10vh; bottom: 15vh; z-index: 20 !important;" title="To top"><span class="glyphicon glyphicon-chevron-up"></span></button>
<div class="row">
	<div class="col-sm-3">
		<ul class="list-group">
			<a href="#"><li id="all" class="list-group-item">All</li></a>
			<?php foreach ($seats as $seat): ?>
			<a href="#<?php echo $seat['name']; ?>"><li id="visit" class="list-group-item"><?php echo $seat['name']; ?></li></a>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="col-sm-9">
		<?php foreach ($seats as $seat): ?>
		<div style="padding-top: 40px;" id="<?php echo $seat['name']; ?>">
		<h3 class="alert alert-info"><?php echo $seat['name']; ?></h3>

<?php foreach ($candidates as $candidate): ?>
	<?php if ($seat['name'] == $candidate['seat']): ?>
	<div class="row">
	<div class="col-sm-4">
		<a href="#" data-toggle="modal" data-target="#image-<?php echo $candidate['uname']; ?>"><img class="img-thumbnail" style="height:30vh; width: 30vh;" src="<?php echo site_url(); ?>assets/img/candidates/<?php echo $candidate['image']; ?>"></a>
	</div>
	<div class="modal fade" id="image-<?php echo $candidate['uname']; ?>" role="dialog">
  <div id="modd" class="modal-dialog">
    <div class="modal-content" style="background: transparent;">
        <button style="font-size: 30px;" type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span></button>
        <img style="height:100%; width:100%;" src="<?php echo site_url(); ?>assets/img/candidates/<?php echo $candidate['image']; ?>">
    </div>                
  </div>              
</div>
	<div class="col-sm-6 well" style="color: #556b2f; background-color: white; font-weight: bold;">
		<h4 style="font-weight: bold; background-color: lightgrey; padding: 7px 7px;">@ <?php echo $candidate['uname'] ?><br><small><?php echo $candidate['first_name'] ?> <?php echo $candidate['last_name'] ?> <?php echo $candidate['other_name'] ?></small></h4>
		<p style="padding: 20px;"><?php echo $candidate['dep'] ?> department. <br>
		 <?php echo $candidate['year'] ?> level <br>
		Running for: <?php echo $candidate['seat'] ?>
		<?php if ($this->session->userdata('log_in')) : ?>
		<button onclick="alert('Disqualified')" class="btn btn-danger pull-right">Disqualify</button>
	<?php endif; ?>
	</p>
	</div>
	</div><hr>
<?php endif; ?>
<?php endforeach; ?>
	</div>
	<?php endforeach; ?>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('li#all, button#scrolltop').click(function () {
			$('li#visit').css("background-color", "");
			jQuery('html,body').animate({scrollTop:0},0);
		});
		$('li#visit').click(function () {
			$('li#visit').css("background-color", "");
			$(this).css("background-color", "lightblue");
		});
	});
</script>
