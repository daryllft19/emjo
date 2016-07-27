

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add Package</h1>
			<form role='form' action='<?php echo site_url('index/form')?>' method='POST'>

          	<div class="form-group">
			  <label for="container">Address:</label>
			  <select class="form-control" name='container' id="container">
			       	<?php foreach ($container as $container_item): ?>
                    <?php 
						echo "<option ";
						if (!$container_item['is_serviceable']){
	                       	echo "disabled";
	                    }
						echo "value=".$container_item['id'];
						echo ">".$container_item['keywords']."</option";
                      
                      echo "</tr>";
                    ?>
              <?php endforeach; ?>
			  </select>
			</div>
			<div class="form-group">
			  <label for="length">Length:</label>
			  <input type="number" step="any" min=0 class="form-control" name='length' id="length" value='<?php echo $length; ?>'>
			  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('length'); ?></span>
			</div>

			<div class="form-group">
			  <label for="width">Width:</label>
			  <input type="number" step="any" min=0 class="form-control" name='width' id="width" value='<?php echo $width; ?>'>
			  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('width'); ?></span>
			</div>

			<div class="form-group">
			  <label for="height">Height:</label>
			  <input type="number" step="any" min=0 class="form-control" name='height' id="height" value='<?php echo $height; ?>'>
			  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('height'); ?></span>
			</div>

			<div class="form-group">
			  <label for="weight">Weight:</label>
			  <input type="number" step="any" min=0 class="form-control" name='weight' id="weight" value='<?php echo $weight; ?>'>
			  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('weight'); ?></span>
			</div>

			<div class="checkbox">
			  <label><input type="checkbox" name='fragile' value="true">Package is fragile.</label>
			</div>

			<button type="submit" name="submit" class="btn btn-default">Submit</button>
			<?php echo form_close();?>
        </div>

