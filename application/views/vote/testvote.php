<div class="row">
	<?php echo validation_errors(); ?>
	<div class="col-sm-offset-2 col-sm-6">
		<?php echo form_open('vote/ballot'); ?>
			<?php $s = 0; 
			foreach ($seats as $seat): 
				$s++; ?>
		<div id="seatdiv" class="form-group">
		    <select style="font-size: 18px;" name="seat-<?= $s; ?>" id="seat" class="form-control">
		        <option value=""><?php echo $seat['name']; ?></option>
		      	<?php foreach ($candidates as $candidate):?>
		      		<?php if ($seat['name'] == $candidate['seat']): ?>
		        <option value="<?php echo $candidate['id']; ?>"><?php echo $candidate['uname']; ?></option>
		    		<?php endif; ?>
		      	<?php endforeach; ?>
		    </select>
	  	</div>
	  	<?php endforeach; ?>
	  	<button type="submit">Vote</button>
	  </form>
	</div>
</div>