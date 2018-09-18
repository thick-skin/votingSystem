<style>
#campaignFeed blockquote{
	background-color: #fffafa;
	margin-left: 5vh;
	font-size: 16px;
}
	.col-sm-4, h3.well{
		position: sticky; 
		top: 70px;
	}
	#ads, blockquote{
		box-shadow: 2px 2px 2px grey;
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
	Details about election start and ending dates will appear here. <br><br>
	Any other useful info here. <br><br>
	Candidates reminded to register. <br><br>
	Voters reminded to register.
</div>	
</div>
<div class="col-sm-6">
	<h3 class="well" style="width: 100%; background-color: #fff8dc; opacity: 0.7; display: inline-flex; font-family: Book Antiqua; color: rgb(220,100,100);">Campaign Feed <p class="loader"></p></h3>
<div class="showdata">

</div>		
</div>
</div>

<script>
	$(document).ready(function () {
		

      
	});
</script>