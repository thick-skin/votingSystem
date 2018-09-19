<?php foreach ($candidates as $candidate): ?>
	
<div class="row">
	<div class="col-sm-4">
		<img class="img-thumbnail" style="height:80%; width: 80%;" src="<?php echo site_url(); ?>assets/img/candidates/<?php echo $candidate['image']; ?>">
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

<?php endforeach; ?>