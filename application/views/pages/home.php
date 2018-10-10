<style>
 .campaignFeed{
		box-shadow: 0 5px 0 #2f4f4f;
		background-color: white; 
		border-radius: 0%;
	}
.campaignFeed p#campaign{
	padding: 15px 15px;
	border-radius: 50px;
	background-color: #fffafa;
	margin-left: 1vh;
	/*width: 70%;*/
}
.campaignFeed a{
	text-decoration: none;
	color:#4CAF50;
}

.campaignFeed a:hover{
	color:white;
	background-color:#4CAF50;
}

button#say:hover{
	background-color: grey !important;
}
	.col-sm-4, h3.well{
		position: sticky; 
		top: 70px;
	}
	#ads, p#campaign{
		box-shadow: 2px 0 2px 0 grey;
	}
	@media screen and (max-height: 560px) {
		.col-sm-4{position: initial;}
	}
	.loader {
  border: 2px solid #f3f3f3;
  border-radius: 50%;
  border-top: 2px solid #3498db;
  width: 20px;
  height: 20px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<div class="row">
<div class="col-sm-4">
<div id="ads" class="well" style="width: 95%; height: 89vh;">
		<input type="hidden" name="candidate" id="candidate" value="<?= $title; ?>">
	<?php if ($candidateSet == true): ?>
		<?php foreach ($candidate1 as $candidate): ?>
			
		<div id="profile-picture"><img class="img-thumbnail" style="height:40vh; width: 50vh;" src="<?php echo site_url(); ?>assets/img/candidates/<?php echo $candidate['image']; ?>"></div>
		<div id="profile-details" style="background-color: white; border-bottom: 5px solid grey; padding: 5px;"><h4 style="font-weight: bold; background-color: lightgrey; padding: 7px 7px;">@ <?php echo $candidate['uname'] ?><br><small><?php echo $candidate['first_name'] ?> <?php echo $candidate['last_name'] ?> <?php echo $candidate['other_name'] ?></small></h4>
		<p><?php echo $candidate['dep'] ?> department. <br>
		 <?php echo $candidate['year'] ?> level <br>
		Running for: <?php echo $candidate['seat'] ?>
		<?php if ($this->session->userdata('log_in')) : ?>
		<button onclick="alert('Disqualified')" class="btn btn-danger pull-right">Disqualify</button>
		<?php endif; ?>
	</div>
		<?php endforeach; ?>
		<?php else: ?>
	The Admin reserves the right to take down any campaign that does not adhere to the rules.<br><br>
	Candidates may be disqualified without warning if implicating info is found against him or her.<br><br>
	Details about election start and ending dates will appear here. <br><br>
	Any other useful info here. <br><br>
	Candidates reminded to register. <br><br>
	Voters reminded to register.
	<?php endif; ?>
</div>	
</div>
<div class="col-sm-6">
	<h3 class="well" style="width: 100%; background-color: white; opacity: 0.7; font-family: Book Antiqua; color: rgb(220,100,100);"><?php if ($candidateSet == true) {
		echo $title."'s ";
	} ?>Campaign Feed<i class="fa fa-spinner fa-spin pull-right" style="font-size:24px"></i></h3>
<div class="showdata">

</div>
<div id="load-more" style="display: inline-flex;"><p>Loading campaign...<p class="loader"></p></p></div>
</div>
</div><br><br>

<script>
	$(document).ready(function () {
		
/*$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
       alert("bottom!");
   }
});*/
      
	});
</script>