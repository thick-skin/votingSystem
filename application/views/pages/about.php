<?php for ($i=0; $i < 10; $i++): ?> 
	
<h3>php Version <?php echo phpversion(); ?><br>
Codeigniter Version <?php echo CI_VERSION; ?> <br>
iVote Version 1.0 <br>
<?php 
$date = '2018-06-19 10:39:19'; 
echo date(' l M, Y \<\b\r\> h:i:s a', strtotime($date));
 ?>
 </h3>

<?php endfor; ?>
 <script>
 $(document).ready(function() {
 	$("html, body").animate({ scrollTop: 50000 });
 });
</script>