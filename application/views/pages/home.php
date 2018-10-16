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

.side-bar{
	height: 89vh;
}
	.side-bar, h3.well{
		position: sticky; 
		top: 60px;
	}
	p#campaign{
		box-shadow: 2px 0 2px 0 grey;
	}

	div.footer{
		background-color: darkgrey;
		color: darkslategrey; 
		margin-top: 2vh; 
		padding: 10px; 
		border-bottom-left-radius: 10px;
		border-bottom-right-radius: 10px;
	}

	@media screen and (max-height: 560px) {
		.side-bar{position: initial; margin-bottom: 20vh;}
		div.right{
		/*	display: none;*/
		}
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
<div class="col-sm-3 side-bar">
<div id="ads" style="width: 100%;">
		<input type="hidden" name="candidate" id="candidate" value="<?= $title; ?>">
	<?php if ($candidateSet == true): ?>
		<?php foreach ($candidate1 as $candidate): ?>
			
		<div id="profile-picture"><img class="img-thumbnail" style="min-height: 40vh; max-height:51vh; width: 100%;" src="<?php echo site_url(); ?>assets/img/candidates/<?php echo $candidate['image']; ?>"></div>
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
	<h4><b>From the Administrator's desk</b></h4>
	<p>The Admin reserves the right to take down any campaign that does not adhere to the rules.</p>
	<p>Candidates may be disqualified without warning if implicating info is found against him or her.</p>
	<p>Details about election start and ending dates will appear here.</p>
	<p>Any other useful info here.</p>
	<p>Candidates reminded to register.</p>
	<p>Voters reminded to register.</p>
	<?php endif; ?>
</div>	
	<div class="footer">
		<p>Language: English<b class="pull-right">iVote <i class="glyphicon glyphicon-copyright-mark"><?php echo date("Y"); ?></i></b>
		<p>Lagos, Nigeria.</p>
	</p>
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
<div class="col-sm-3 right" style="height: 50vh;">
	<?php if ($candidateSet == true): ?>
	<div style="bottom: 5vh; position: fixed; width: 50%">
		<form>
			<div class="form-group" style="display: inline-flex;">
			<input class="form-control" type="text" name="" placeholder="Send Message..." style="border-bottom-left-radius: 20px; border-top-left-radius: 20px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
			<button type="button" class="btn btn-info" style="border-bottom-left-radius: 0; border-top-left-radius: 0; border-top-right-radius: 20px; border-bottom-right-radius: 20px;"><i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</form>
	</div>
<?php endif; ?>
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