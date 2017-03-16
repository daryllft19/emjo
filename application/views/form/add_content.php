

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Add Package</h1>
			<form role='form' action='<?php echo site_url('index/form')?>' method='POST'>
			<!-- <div class='row'> -->
				<div class='col-md-6'>
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

					<div class='row'>
					<h4>Top Result/s: (Click the result below that matches the correct address)</h4>
						<div id='top-results'>

						</div>
					</div>
				</div>
				<div class='col-md-6'>
					<!-- <div class="form-group"> -->
					  <label for="length">Address:</label>
					  <input type="hidden" id="address_hidden" name="address_id" value="<?php echo $input_address_id; ?> ">
					  <input type="hidden" name='address' id="address" value="<?php echo $input_address; ?>">

					  <span id='span-address'><?php echo (strlen($input_address)>0)?$input_address:'N/A';?></span>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('address_id'); ?></span>
					<!-- </div> -->

					<div class="form-group">
					  <label for="length">Length (cm):</label>
					  <input type="number" step="0.1" min=0 class="form-control" name='length' id="length" value='<?php echo $length; ?>' autofocus autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('length'); ?></span>
					</div>

					<div class="form-group">
					  <label for="width">Width (cm):</label>
					  <input type="number" step="0.1" min=0 class="form-control" name='width' id="width" value='<?php echo $width; ?>' autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('width'); ?></span>
					</div>

					<div class="form-group">
					  <label for="height">Height (cm):</label>
					  <input type="number" step="0.1" min=0 class="form-control" name='height' id="height" value='<?php echo $height; ?>' autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('height'); ?></span>
					</div>

					<div class="form-group">
					  <label for="weight">Weight (kg):</label>
					  <input type="number" step="1" min=0 class="form-control" name='weight' id="weight" value='<?php $weight; ?>' autocomplete='off'>
					  <span class="help-block" style="font-style:italic;color:red;"><?php echo form_error('weight'); ?></span>
					</div>

					<div class="checkbox">
					  <label><input type="checkbox" name='fragile' value="true">Fragile</label>
					</div>

					<div class="form-group">
					  <label for="height-constraint">Height Constraint(kg):</label>
					  <input type="number" step="1" class="form-control" name='height-constraint' id="height-constraint" value='<?php $height_constraint; ?>'  autocomplete='off'>
					</div>

					<div class="form-group">
					  <label for="weight-constraint">Weight Constraint(kg):</label>
					  <input type="number" step="1" class="form-control" name='weight-constraint' id="weight-constraint" value='<?php $weight_constraint; ?>'  autocomplete='off'>
					</div>


				</div>
				<button type="submit" name="submit" class="btn btn-default">Submit</button>
			<!-- </div> -->
			<?php echo form_close();?>
        </div>
        <script type="text/javascript">

        	function change_province()
        	{
        		var province = $('#select-province').find(':selected').val();
        		var sel_city = $('#select-city');
		        $.get( "/address/search",{'params':{'province':province}}, function( data ) {
		             lData = data['top'][0]

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
		             change_city();
		             change_district();
		             change_barangay();
		             change_area();
		             change_avenue();
		             get_top_address();
		        });
        	}

        	function change_city()
        	{
        		var city = $('#select-city').find(':selected').val();
        		var province = $('#select-province').find(':selected').val();
        		var sel_district = $('#select-district');
		        $.get( "/address/search",{'params':{'province':province,'city':city}}, function( data ) {
		             lData = data['top'][0]

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
		             change_district();
		             change_barangay();
		             change_area();
		             change_avenue();
		             get_top_address();
		        });
        	}

        	function change_district()
        	{
        		var province = $('#select-province').find(':selected').val();
        		var city = $('#select-city').find(':selected').val();
        		var district = $('#select-district').find(':selected').val();
        		var sel_barangay = $('#select-barangay');
		        $.get( "/address/search",{'params':{'province':province,'city':city, 'district':district}}, function( data ) {
		             lData = data['top'][0]

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
		             change_barangay();
		             change_area();
		             change_avenue();
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
		             lData = data['top'][0]

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
		             change_area();
		             change_avenue();
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
		             lData = data['top'][0]

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
		             lData = data['top'][0]

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
		        $.get( "/address/search",{'params':{'province':province, 'city':city, 'district': district,'barangay':barangay, 'area':area, 'avenue': avenue, 'street':street},'limit':3}, function( data ) {
		             elem = '<ul>';
		             lData = data['top'][0]
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
 
        	$(document).ready(function(){
        		get_top_address();
        		change_province();
        	});
        	$('#select-province').on('change',change_province);
        	$('#select-city').on('change',change_city);
        	$('#select-district').on('change',change_district);
        	$('#select-barangay').on('change',change_barangay);
        	$('#select-area').on('change',change_area);
        	$('#select-avenue').on('change',change_avenue);
        	$('select').on('change', get_top_address);	
			$('#top-results').on('click', 'li', function(){
			    $('#address_hidden').val(this.value);
			    $('#address').val($(this).text());
			    $('#span-address').html($(this).text());


			});
			$('#weight').keyup(function(){
				weight_constraint = $(this).val()*4;
				$('#weight-constraint').val(weight_constraint);

				height_constraint = Math.min($('#weight').val(), $('#height').val()) * 3;
				$('#height-constraint').val(height_constraint);
			}).keyup();

			$('#height').keyup(function(){
				height_constraint = Math.min($('#length').val(), $('#width').val()) * 3;
				$('#height-constraint').val(height_constraint);
			}).keyup();

        </script>

