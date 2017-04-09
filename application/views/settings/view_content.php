
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Settings</h1>
          		<div class='col-sm-4'>
          			<div class='row'>
	          			<h3 class='page-header'>Multiplier</h3>
	          			<div class="form-group">
						  <label for="height">Height Constraint Multiplier:</label>
						  <input type="number" class="form-control" name='height' id="height" step=0.01 value=<?php echo $settings['height_multiplier']?> min=0 autocomplete='off' >
						</div>

	          			<div class="form-group">
						  <label for="height">Weight Constraint Multiplier:</label>
						  <input type="number" class="form-control" name='weight' id="weight" step=0.01 value=<?php echo $settings['weight_multiplier']?> min=0 autocomplete='off' >
						</div>
						  <a href='#' onclick='save();' class='btn btn-danger' id='btn-save' role='button'>Save Multiplier</a>  
					</div>

					<br/>
					<br/>

          			<div class='row'>
	          			<h3 class='page-header'>Password</h3>
						<div class="form-group">
						  <label for="password1">New Password:</label>
						  <input type="password" class="form-control" name='password1' id="password1" autocomplete='off'>
						  <label for="password2">Confirm Password:</label>
						  <input type="password" class="form-control" name='password2' id="password2" autocomplete='off'>
						</div>
						  <a href='#' onclick='change();' class='btn btn-danger' id='btn-password' role='button'>Change Password</a>
					</div>

				</div>
        </div>
      </div>
    </div>

<div id="dialog-save" title="Save">
</div>

<script type="text/javascript">
	
	function save()
	{
		weight = $('#weight').val();
		height = $('#height').val();
		params = {
			'weight_multiplier' : weight,
			'height_multiplier' : height
		}
		$('#dialog-save').html('Do you want to save multipliers?')
		$('#dialog-save').dialog({
                  modal: true,
                  buttons: {
                  	Save:function(){
                  		$('button').prop('disabled', true);
						$('#dialog-save').html('Saving multiplier...')
                  		$.post('/setting/save',{'params':params}, function(data){
                  			// console.log(data);
                  			if(data.success == 1)
								$('#dialog-save').html('Multiplier saved!')
							else
								$('#dialog-save').html('Ooops errr!')

							setTimeout(function(){
	                    		$('#dialog-save').dialog('close');
                  				$('button').prop('disabled', false);
	                    	},2000);
                  		})
                  	},
                  Cancel:function(){
                  		$('#dialog-save').dialog('close');
                  } 
                  }
              })
	}

	function change()
	{
		var password1 = $('#password1').val();
		var password2 = $('#password2').val();

		if(password1 != password2 || password1 == ''){
			$('#dialog-save').html('Invalid password!');
			$('#dialog-save').dialog({
				modal: true,
				buttons:{
					Close: function(){
						$('#password1').val('');
						$('#password2').val('');
						$('#dialog-save').dialog('close');
					}
					}
				})
			return;
		}

		input = '<h4>Input password</h4>';
		input += '<input id="old" name="old" type="password">';
		$('#dialog-save').html(input);
		$('#dialog-save').dialog({
                  modal: true,
                  buttons: {
	                  	Change:function(){
	                  		$('button').prop('disabled', true);
							
							var old = $('#old').val();
							params = {
								'old': old,
								'new':password2
							}
							$('#dialog-save').html('Changing password...')
	                  		$.post('/authhandler/change',{'params':params}, function(data){
	                  			if(data.success == 1)
									$('#dialog-save').html('New password saved!')
								else
									$('#dialog-save').html('Ooops errr!')

								setTimeout(function(){
									$('#password1').val('');
									$('#password2').val('');
		                    		$('#dialog-save').dialog('close');
	                  				$('button').prop('disabled', false);
		                    	},2000);
	                  		})
	                  	},
		                Cancel:function(){
		                 	$('#dialog-save').dialog('close');
		                } 
                  }
              })
	}

</script>