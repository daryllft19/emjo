

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add Package</h1>
			<form role='form' id='form-add' method='POST'>
			<!-- <div class='row'> -->
				<div class='col-md-6'>
					<div class='row'>
					<h4>Top Result/s: (Click the result below that matches the correct address)</h4>
						<div id='top-results'>

						</div>
					</div>
		          	<div class="form-group">
					  <label for="select-province">Search Province:</label>
					  <select class="form-control" name='select-province' id="select-province">
					       	<?php 
					       		foreach ($province as $key => $value){			       		
									echo "<option value='".$value."'>".$value."</option>";
					       		}

		                    	?>
					  </select>
					</div>

					<div class="form-group">
					  <label for="select-city">Search City:</label>
					  <select class="form-control" name='select-city' id="select-city" >
							<!-- <option>N/A</option> -->
					  </select>
					</div>

					<div class="form-group">
					  <label for="select-district">Search District:</label>
					  <select class="form-control" name='select-district' id="select-district" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

					<div class="form-group">
					  <label for="select-barangay">Search Barangay:</label>
					  <select class="form-control" name='select-barangay' id="select-barangay" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

					<div class="form-group">
					  <label for="select-area">Search Area:</label>
					  <select class="form-control" name='select-area' id="select-area" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

					<div class="form-group">
					  <label for="select-avenue">Search Avenue:</label>
					  <select class="form-control" name='select-avenue' id="select-avenue" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

					<div class="form-group">
					  <label for="select-street">Search Street:</label>
					  <select class="form-control" name='select-street' id="select-street" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

				</div>
				<div class='col-md-6'>

					<div class="form-group">
					  <label for="length">Address:</label>
					  <input type="hidden" id="address_hidden" name="address_id" value="<?php echo $input_address_id; ?> ">
					  <input type="hidden" name='address' id="address" value="<?php echo $input_address; ?>">

					  <strong><big><span id='span-address'><?php echo (strlen($input_address)>0)?$input_address:'N/A';?></span></big></strong>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('address_id'); ?></span>
					  <a href='#' onclick='clear_address();' class='btn btn-danger' id='btn-clear-address' role='button'>Clear Address</a>
					</div>

					<div class="form-group">
					  <label for="serial">Serial Number:</label>
					  <input type="text" class="form-control" name='serial' id="serial" value='<?php echo $serial; ?>' autofocus autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('serial'); ?></span>
					</div>

					<div class="form-group">
					  <label for="length">Length (cm):</label>
					  <input type="number" step="1" min=0 class="form-control" name='length' id="length" value='<?php echo $length; ?>' autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('length'); ?></span>
					</div>

					<div class="form-group">
					  <label for="width">Width (cm):</label>
					  <input type="number" step="1" min=0 class="form-control" name='width' id="width" value='<?php echo $width; ?>' autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('width'); ?></span>
					</div>

					<div class="form-group">
					  <label for="height">Height (cm):</label>
					  <input type="number" step="1" min=0 class="form-control" name='height' id="height" value='<?php echo $height; ?>' autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('height'); ?></span>
					</div>

					<div class="form-group">
					  <label for="weight">Weight (kg):</label>
					  <input type="number" step="1" min=0 class="form-control" name='weight' id="weight" value='<?php echo $weight; ?>' autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('weight'); ?></span>
					</div>

					<div class="checkbox">
					  <label><input type="checkbox" id='fragile' name='fragile' <?php if($fragile) echo 'checked' ?>>Fragile</label>
					</div>

					<div class="form-group">
					  <label for="height-constraint">Height Constraint(cm):</label>
					  <input type="number" step="1" min=0 class="form-control" name='height-constraint' id="height-constraint" value='<?php echo $height_constraint>0?$height_constraint:0; ?>'  autocomplete='off'>
					</div>

					<div class="form-group">
					  <label for="weight-constraint">Weight Constraint(kg):</label>
					  <input type="number" step="1" min=0 class="form-control" name='weight-constraint' id="weight-constraint" value='<?php echo $weight_constraint>0?$weight_constraint:0; ?>'  autocomplete='off'>
					</div>


				<button type="button" name="submit" class="btn btn-default">Submit</button>
				</div>
			<!-- </div> -->
			
			</form>
        </div>

<div id="dialog-review" title="Review Package">
</div>

        <script type="text/javascript">

    		$('button[name=submit]').on('click',function(e){
    			var submit_btn = $(this);
    			if(	$('#address_hidden').val() <= 0 ||
    				$('#serial').val() == '' ||
    				$('#length').val() <= 0 ||
    				$('#width').val() <= 0 ||
    				$('#height').val() <= 0 ||
    				$('#weight').val() <= 0
    				)
    			{
                    submit_btn.prop('type','submit');
                    submit_btn.trigger('click');
    			}
    				// $('#form-add').submit(function(e){
    				// 	e.preventDefault();
    				// })
    			var review_form = 	'<p><strong>Address</strong>: '+$('#span-address').html()+'</p>'+
    								'<p><strong>Serial No</strong>: '+$('#serial').val()+'</p>'+
    								'<p><strong>Length (cm)</strong>: '+$('#length').val()+'</p>'+
    								'<p><strong>Width (cm)</strong>: '+$('#width').val()+'</p>'+
    								'<p><strong>Height (cm)</strong>: '+$('#height').val()+'</p>'+
    								'<p><strong>Weight (kg)</strong>: '+$('#weight').val()+'</p>';
    			$( "#dialog-review" ).html(review_form);
    			$( "#dialog-review" ).dialog({
                  modal: true,
                  buttons: {
                    'Save and Add another' : function() {
                    	// $('#form-add').submit();
                    	// console.log(this);
                    	// submit_btn.prop('type','submit');
                    	// submit_btn.trigger('click');
                    	var params = {
                    		'address' : $('#address_hidden').val(),
                    		'serial' : $('#serial').val(),
                    		'length' : $('#length').val(),
                    		'width' : $('#width').val(),
                    		'height' : $('#height').val(),
                    		'weight' : $('#weight').val(),
                    		'fragile' :$('#fragile').is(':checked'),
                    		'height_constraint' :$('#height-constraint').val(),
                    		'weight_constraint' :$('#weight-constraint').val()
                    	}
                    	$('button').prop('disabled', true);
                    	$( "#dialog-review" ).html(review_form + '<p>Processing package...</p>');
                    	$.post('/package/add',{'params':params},function(data){
                    		if(data.success >= 1){
                    			$( "#dialog-review" ).html( review_form+'<p style="color:green;"><strong>Successfully added package!</strong></p>');
                    			$('.form-group input').val('').prop('disabled',true);
                    			$('#span-address').html('N/A')
                    			$('select').val('');
                    			$('#select-province').val('Metro Manila');
                    			get_top_address();
                    		}
                    		else{
                    			failed = '';
                    			if(data.success.indexOf('general') >= 0)
                    				failed += 'Package cannot be placed anywhere.<br/>';
                    			if(data.success.indexOf('dimension') >= 0)
                    				failed += 'Package\'s dimension exceeds cluster.<br/>';
                    			if(data.success.indexOf('weight')  >= 0)
                    				failed += 'Package exceeds weight constraint of package below.<br/>';
                    			if(data.success.indexOf('height') >= 0)
                    				failed += 'Package exceeds height constraint of package below.<br/>';

                    			err_msg = 	'<p style="color:red;">'+
                    						'Error processing package!<br/>'+
                    						failed+
                    						'</p>'
                    			$( "#dialog-review" ).html(review_form+err_msg);
                    		}

                    		setTimeout(function(){
	                    		$('#dialog-review').dialog('close');
                    			$('button').prop('disabled', false);
	                    	},2000+1000*(data.success.length || 0));
                    	})
                    },
                    'Add and View package' : function(){
                    	var params = {
                    		'address' : $('#address_hidden').val(),
                    		'serial' : $('#serial').val(),
                    		'length' : $('#length').val(),
                    		'width' : $('#width').val(),
                    		'height' : $('#height').val(),
                    		'weight' : $('#weight').val(),
                    		'fragile' :$('#fragile').is(':checked'),
                    		'height_constraint' :$('#height-constraint').val(),
                    		'weight_constraint' :$('#weight-constraint').val()
                    	}
                    	$('button').prop('disabled', true);
                    	$( "#dialog-review" ).html(review_form + '<p>Processing package...</p>');
                    	$.post('/package/add',{'params':params},function(data){
                    		if(data.success >= 1){
                    			$( "#dialog-review" ).html(review_form + '<p style="color:green;"><strong>Successfully added package! Proceeding to view page!</strong></p>');

		                    	var success_params = {
		                    		'id': params['address'],
		                    		'convert': false
		                    	}

		                    	$.get( "/address/search",{'params':success_params}, function( data ) {
		                    		cluster_id = data.top[0].cluster;

                    				setTimeout(function(){ 
		                    			window.location = '/index/package?cluster='+cluster_id;
		                    		},3000)
		                    	})

                    		}
                    		else
                    		{
								failed = '';
                    			if(data.success.indexOf('general') >= 0)
                    				failed += 'Package cannot be placed anywhere.<br/>';
                    			if(data.success.indexOf('dimension') >= 0)
                    				failed += 'Package\'s dimension exceeds cluster.<br/>';
                    			if(data.success.indexOf('weight')  >= 0)
                    				failed += 'Package exceeds weight constraint of package below.<br/>';
                    			if(data.success.indexOf('height') >= 0)
                    				failed += 'Package exceeds height constraint of package below.<br/>';

                    			err_msg = 	'<p style="color:red;">'+
                    						'Error processing package!<br/>'+
                    						failed+
                    						'</p>'
                    			$( "#dialog-review" ).html(review_form+err_msg);
                    		}


                    		setTimeout(function(){
	                    		$('#dialog-review').dialog('close');
                    			$('button').prop('disabled', false);
	                    	},2000+1000*(data.success.length || 0));
                    	})
                    }
                  }
                });
    		})

        	function change_province()
        	{
        		var province = $('#select-province').find(':selected').val();
        		var sel_city = $('#select-city');
		        $.get( "/address/search",{'params':{'province':province}}, function( data ) {
		             lData = data['top']
		             current = sel_city.val();

		             cities = []
		             for(d of lData)
		             {
		             	if(cities.indexOf(d.city)==-1)
		             		cities.push(d.city); 
		             }

		             elem = '';
		             elem += '<option value="">N/A</option>';
		             for(x of cities.sort())
		             {
		             	elem += '<option value="'+x+'">'+x+"</option>";
		             }
		             sel_city.html(elem);
		             if(current != null && sel_city.find('option[value="'+current+'"]').length>0 )
		             	sel_city.find('option[value="'+current+'"]').prop('selected', true)
		             // $('#select-province').trigger('change');
		             change_city();
		             // change_district();
		             // change_barangay();
		             // change_area();
		             // change_avenue();
		             get_top_address();
		        });
        	}

        	function change_city()
        	{
        		var city = $('#select-city').find(':selected').val();
        		var province = $('#select-province').find(':selected').val();
        		var sel_district = $('#select-district');
		        $.get( "/address/search",{'params':{'province':province,'city':city}}, function( data ) {
		             lData = data['top']
		             current = sel_district.val();

		             districts = []
		             for(d of lData)
		             {
		             	if(districts.indexOf(d.district)==-1 && d.district!='')
		             		districts.push(d.district); 
		             }

		             elem = '';
		             // if(districts.length == 0)
		             // {
		             	elem += '<option value="">N/A</option>';
		             // }
		             for(x of districts.sort())
		             {
		             	elem += '<option value="'+x+'">'+x+'</option>';
		             }
		             sel_district.html(elem);
		             if(current != null && sel_district.find('option[value="'+current+'"]').length>0 )
		             	sel_district.find('option[value="'+current+'"]').prop('selected', true)
		             // $('#select-city').trigger('change');
		             change_district();
		             // change_barangay();
		             // change_area();
		             // change_avenue();
		             get_top_address();
		        });
        	}

        	function change_district()
        	{
        		var province = $('#select-province').find(':selected').val();
        		var city = $('#select-city').find(':selected').val();
        		var district = $('#select-district').find(':selected').val();
        		var sel_barangay = $('#select-barangay');
        		var params = {
        			'province':province,
        			'city':city,
        			'district':district
        		}
		        $.get( "/address/search",{'params':params}, function( data ) {
		             lData = data['top']
		             current = sel_barangay.val();

		             barangays = []
		             for(d of lData)
		             {
		             	if(barangays.indexOf(d.barangay)==-1 && d.barangay!='')
		             		barangays.push(d.barangay); 
		             }

		             elem = '';
		             // if(districts.length == 0)
		             // {
		             	elem += '<option value="">N/A</option>';
		             // }
		             for(x of barangays.sort())
		             {
		             	elem += '<option value="'+x+'">'+x+'</option>';
		             }
		             sel_barangay.html(elem);
		             if(current != null && sel_barangay.find('option[value="'+current+'"]').length>0 )
		             	sel_barangay.find('option[value="'+current+'"]').prop('selected', true)
		             // $('#select-district').trigger('change');
		             change_barangay();
		             // change_area();
		             // change_avenue();
		             get_top_address();
		        });
        	}

        	function change_barangay()
        	{
        		var province = $('#select-province').find(':selected').val();
        		var city = $('#select-city').find(':selected').val();
        		var district = $('#select-district').find(':selected').val();
        		var barangay = $('#select-barangay').find(':selected').val();
        		var sel_area = $('#select-area');
		        $.get( "/address/search",{'params':{'province':province,'city':city, 'district':district,'barangay':barangay}}, function( data ) {
		             lData = data['top']
		             current = sel_area.val();
		             areas = []
		             for(d of lData)
		             {
		             	if(areas.indexOf(d.area)==-1 && d.area!='')
		             		areas.push(d.area); 
		             }

		             elem = '';
		             // if(districts.length == 0)
		             // {
		             	elem += '<option value="">N/A</option>';
		             // }
		             for(x of areas.sort())
		             {
		             	elem += '<option value="'+x+'">'+x+'</option>';
		             }
		             sel_area.html(elem);
		             if(current != null && sel_area.find('option[value="'+current+'"]').length>0 )
		             	sel_area.find('option[value="'+current+'"]').prop('selected', true)
		             // $('#select-barangay').trigger('change');
		             change_area();
		             // change_avenue();
		             get_top_address();
		        });
        	}

        	function change_area()
        	{
        		var province = $('#select-province').find(':selected').val();
        		var city = $('#select-city').find(':selected').val();
        		var district = $('#select-district').find(':selected').val();
        		var barangay = $('#select-barangay').find(':selected').val();
        		var area = $('#select-area').find(':selected').val();
        		var sel_avenue = $('#select-avenue');
		        $.get( "/address/search",{'params':{'province':province,'city':city, 'district':district,'barangay':barangay,'area':area}}, function( data ) {
		             lData = data['top']
		             current = sel_avenue.val();

		             avenues = []
		             for(d of lData)
		             {
		             	if(avenues.indexOf(d.avenue)==-1 && d.avenue!='')
		             		avenues.push(d.avenue); 
		             }

		             elem = '';
		             // if(districts.length == 0)
		             // {
		             	elem += '<option value="">N/A</option>';
		             // }
		             for(x of avenues.sort())
		             {
		             	elem += '<option value="'+x+'">'+x+'</option>';
		             }
		             sel_avenue.html(elem);
		             if(current != null && sel_avenue.find('option[value="'+current+'"]').length>0 )
		             	sel_avenue.find('option[value="'+current+'"]').prop('selected', true)
		             // $('#select-area').trigger('change');
		             change_avenue();
		             get_top_address();
		        });
        	}

        	function change_avenue()
        	{
        		var province = $('#select-province').find(':selected').val();
        		var city = $('#select-city').find(':selected').val();
        		var district = $('#select-district').find(':selected').val();
        		var barangay = $('#select-barangay').find(':selected').val();
        		var area = $('#select-area').find(':selected').val();
        		var avenue = $('#select-avenue').find(':selected').val();
        		var sel_street = $('#select-street');
		        $.get( "/address/search",{'params':{'province':province,'city':city, 'district':district,'barangay':barangay,'area':area,'avenue':avenue}}, function( data ) {
		             lData = data['top']
		             current = sel_street.val();

		             streets = []
		             for(d of lData)
		             {
		             	if(streets.indexOf(d.street)==-1 && d.street!='')
		             		streets.push(d.street); 
		             }

		             elem = '';
		             // if(districts.length == 0)
		             // {
		             	elem += '<option value="">N/A</option>';
		             // }
		             for(x of streets.sort())
		             {
		             	elem += '<option value="'+x+'">'+x+'</option>';
		             }
		             sel_street.html(elem);
		             if(current != null && sel_street.find('option[value="'+current+'"]').length>0 )
		             	sel_street.find('option[value="'+current+'"]').prop('selected', true)
		             get_top_address();
		        });
        	}

        	function get_top_address()
        	{
        		var province = $('#select-province').find(':selected').val();
        		var city = $('#select-city').find(':selected').val();
        		var district = $('#select-district').find(':selected').val();
        		var barangay = $('#select-barangay').find(':selected').val();
        		var area = $('#select-area').find(':selected').val();
        		var avenue = $('#select-avenue').find(':selected').val();
        		var street = $('#select-street').find(':selected').val();
        		var top_results = $('#top-results');
        		var params = {
        			'province':province, 
        			'city':city, 
        			'district': district,
        			'barangay':barangay, 
        			'area':area, 
        			'avenue': avenue, 
        			'street':street
        		};
		        $.get( "/address/search",{'params':params,'limit':3}, function( data ) {
		             elem = '<ul>';
		             lData = data['top']
		             
		             for(d of lData )
		             {
		             	addr = '';
		             	
		             	for(attr of ['area', 'street','avenue','district','barangay','city','province'])
		             	{
		             		addr += d[attr];
		             		if (d[attr].length != 0 && attr!='province')
		             		{
		             			addr += ', ';
		             		}
		             	}
		             	elem += '<li value="'+ d.id +'"><span style="cursor:pointer;text-decoration:underline;">'+addr+'</a></li>';

		             }

		             elem += '</ul>';
		             top_results.html(elem);
		        });
        	}
 			function clear_address(){
 				$('#address_hidden').val('');
 				$('#address').val('');
				$('#span-address').html('N/A');

				$('.form-group input').prop('disabled', true);
 			}

        	$(document).ready(function(){
        		// get_top_address();
        		// change_province();
        		// $.get('/address/search',function(data){
        			// console.log(data);
        		// })
        		if($('#span-address').html() == 'N/A')
					$('.form-group input').prop('disabled', true);
        		
        		$('#serial, #length, #width, #height, #weight').on('change',function(){
        			if($(this).val() != '')
        				$(this).next('.help-block').hide();

        		})
	        	$('#select-province').on('load',change_province()).change(change_province);
	        	$('#select-city').on('load',change_city()).change(change_city);
	        	$('#select-district').on('load',change_district()).change(change_district);
	        	$('#select-barangay').on('load',change_barangay()).change(change_barangay);
	        	$('#select-area').on('load',change_area()).change(change_area);
	        	$('#select-avenue').on('load',change_avenue()).change(change_avenue);
	        	// $('select').on('change', get_top_address);	
				$('#top-results').on('click', 'li', function(){
				    $('#address_hidden').val(this.value);
				    $('#address').val($(this).text());
				    $('#span-address').html($(this).text());
				    $('#serial').focus();
				    $.get('/address/search',{'params':{'id':this.value}},function(data){
				    	d = data.top[0]
				    	keys = Object.keys(d);
				    	delete keys[0];
				    	delete keys[1];
				    	delete keys[9];

				    	keys.forEach(function(i){
				    		$('#select-'+i).val(d[i]);
				    		$('#select-'+i).trigger('change');
				    	})
						$('.form-group input').prop('disabled', false);
						$('#span-address').next('.help-block').html('');
				    })
				});
				$('input').on('focus', function(){
					$(this).select();
				})
				$('#weight').on('keyup',compute_weight_constraint)

				$('#height').on('keyup',compute_height_constraint)
        	});

			function compute_weight_constraint()
			{
				weight_constraint = $('#weight').val()*4;
				if($('input[name=weight-constraint]').prop('disabled') == false)
					$('#weight-constraint').val(weight_constraint);	
			}
			function compute_height_constraint()
			{
				height_constraint = Math.min($('#length').val(), $('#width').val()) * 3;
				if($('input[name=height-constraint]').prop('disabled') == false)
					$('#height-constraint').val(height_constraint);	
			}

			$('input[name=fragile]').on('change',function(){
				if($('input[name=fragile]').is(':checked')){
					$('input[name$=constraint').prop('disabled', true).val(0);
				}
				else{
					$('input[name$=constraint]').prop('disabled', false)
					compute_height_constraint();
					compute_weight_constraint();
				}
			}).trigger('change');
        </script>

