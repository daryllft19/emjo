

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add Package</h1>
			<form role='form' action='<?php echo site_url('index/form')?>' method='POST'>
			<!-- <div class='row'> -->
				<div class='col-md-6'>
					<div class='row'>
					<h4>Top Result/s: (Click the result below that matches the correct address)</h4>
						<div id='top-results'>

						</div>
					</div>
		          	<div class="form-group">
					  <label for="select-province">Province:</label>
					  <select class="form-control" name='select-province' id="select-province">
					       	<?php 
					       		foreach ($province as $key => $value){			       		
									echo "<option value='".$value."'>".$value."</option>";
					       		}

		                    	?>
					  </select>
					</div>

					<div class="form-group">
					  <label for="select-city">City:</label>
					  <select class="form-control" name='select-city' id="select-city" >
							<!-- <option>N/A</option> -->
					  </select>
					</div>

					<div class="form-group">
					  <label for="select-district">District:</label>
					  <select class="form-control" name='select-district' id="select-district" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

					<div class="form-group">
					  <label for="select-barangay">Barangay:</label>
					  <select class="form-control" name='select-barangay' id="select-barangay" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

					<div class="form-group">
					  <label for="select-area">Area:</label>
					  <select class="form-control" name='select-area' id="select-area" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

					<div class="form-group">
					  <label for="select-avenue">Avenue:</label>
					  <select class="form-control" name='select-avenue' id="select-avenue" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

					<div class="form-group">
					  <label for="select-street">Street:</label>
					  <select class="form-control" name='select-street' id="select-street" >
							<!-- <option>N/A</option> -->

					  </select>
					</div>

				</div>
				<div class='col-md-6'>
					<!-- <div class="form-group"> -->
					  <label for="length">Address:</label>
					  <input type="hidden" id="address_hidden" name="address_id" value="<?php echo $input_address_id; ?> ">
					  <input type="hidden" name='address' id="address" value="<?php echo $input_address; ?>">

					  <span id='span-address'><?php echo (strlen($input_address)>0)?$input_address:'N/A';?></span>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('address_id'); ?></span>
					  <a href='#' onclick='clear_address();' class='btn btn-danger' id='btn-clear-address' role='button'>Clear Address</a>
					<!-- </div> -->

					<div class="form-group">
					  <label for="length">Length (cm):</label>
					  <input type="number" step="1" min=0 class="form-control" name='length' id="length" value='<?php echo $length; ?>' autofocus autocomplete='off'>
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
					  <label><input type="checkbox" name='fragile' <?php if($fragile) echo 'checked' ?>>Fragile</label>
					</div>

					<div class="form-group">
					  <label for="height-constraint">Height Constraint(cm):</label>
					  <input type="number" step="1" min=0 class="form-control" name='height-constraint' id="height-constraint" value='<?php echo $height_constraint>0?$height_constraint:0; ?>'  autocomplete='off'>
					</div>

					<div class="form-group">
					  <label for="weight-constraint">Weight Constraint(kg):</label>
					  <input type="number" step="1" min=0 class="form-control" name='weight-constraint' id="weight-constraint" value='<?php echo $weight_constraint>0?$weight_constraint:0; ?>'  autocomplete='off'>
					</div>


				<button type="submit" name="submit" class="btn btn-default">Submit</button>
				</div>
			<!-- </div> -->
			<?php echo form_close();?>
        </div>
        <script type="text/javascript">

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

				$('input').prop('disabled', true);
 			}

        	$(document).ready(function(){
        		// get_top_address();
        		// change_province();
        		// $.get('/address/search',function(data){
        			// console.log(data);
        		// })
        		if($('#span-address').html() == 'N/A')
					$('input').prop('disabled', true);
        		
        		$('#length, #width, #height, #weight').on('change',function(){
        			if($(this).val() != '')
        				$(this).next('.help-block').hide();

        			console.log('val: '+$(this).val());
        			console.log('html: '+$(this).html());
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
				    $('#length').focus();
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
						$('input').prop('disabled', false);
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

