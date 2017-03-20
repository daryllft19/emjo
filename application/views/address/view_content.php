
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Address</h1>
          <div class="col-md-4">
              <?php
              //IF LOGGED IN
              if ($this->tank_auth->get_username())
              {

              //START AFTER HERE
              ?>
              
              <div class='input-group'>
                <label for="select-cluster">Cluster:</label>
                <select class="form-control" id="select-cluster">
                  <option value='-1'>NONE</option>
                  <?php
                  foreach ($ret as $key => $value) {
                    echo "<option value='".$key."'>".$value['name']."</option>";
                  }
                  
                  ?>
                </select>
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

              <?php
              //END BEFORE HERE
              //IF LOGGED OUT OF ADMIN
              }else{ 
              //START AFTER HERE
              ?>

              <div class='text-center'><strong>NEEDS ADMIN ACCESS. PLEASE LOGIN</strong></div>
              
              <?php
              //END BEFORE HERE
              }
              ?>
          </div>

          <div class="col-md-8">
            <div class="table-responsive" style="height: 80vh;display:block;">
              <table class="table table-striped" >
                <thead>
                  <tr>
                    <!-- <th>ID</th> -->
                    <th>Cluster</th>
                    <th>Province</th>
                    <th>City</th>
                    <th>Barangay</th>
                    <th>District</th>
                    <th>Area</th>
                    <th>Avenue</th>
                    <th>Street</th>
                    <th>Serviceable</th>
                  </tr>
                </thead>
                <tbody id='table-cluster'>
                <?php foreach ($address as $address_item): ?>
                      <?php 
                        echo "<tr data-value='".$address_item['id']."'>";
                        // echo "<td>".$address_item['id']."</td>";
                        echo "<td data-value='".$address_item["cluster"]['name']."'>".$address_item["cluster"]['name']."</td>";
                        echo "<td contenteditable data-attr='province' data-value='".$address_item["province"]."'>".$address_item["province"]."</td>";
                        echo "<td contenteditable data-attr='city' data-value='".$address_item["city"]."'>".$address_item["city"]."</td>";
                        echo "<td contenteditable data-attr='barangay' data-value='".$address_item["barangay"]."'>".$address_item["barangay"]."</td>";
                        echo "<td contenteditable data-attr='district' data-value='".$address_item["district"]."'>".$address_item["district"]."</td>";
                        echo "<td contenteditable data-attr='area' data-value='".$address_item["area"]."'>".$address_item["area"]."</td>";
                        echo "<td contenteditable data-attr='avenue' data-value='".$address_item["avenue"]."'>".$address_item["avenue"]."</td>";
                        echo "<td contenteditable data-attr='street' data-value='".$address_item["street"]."'>".$address_item["street"]."</td>";
                        echo "<td data-value='".$address_item["is_serviceable"]."' data-attr='is_serviceable'>";

                        if ($address_item['is_serviceable']){
                          echo "<input type='checkbox' checked/>";
                        }else{
                          echo "<input type='checkbox'/>";
                        }
                        echo "</td>";
                        echo "</tr>";
                      ?>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>


      </div>
    </div>
<script>
          $('table').on('change','input[type=checkbox]', function(){
            var td = $(this).parent();
            var tr = td.parent();
            console.log(tr);
            var col = td.data('attr');
            var id = tr.data('value');
            var is_serviceable = $(this).prop('checked')
            modify_address(id, {'is_serviceable':is_serviceable});
          });
          $('td').on('focus', function(){
              $(this).keypress(function(e){
                var key = e.which;

                if(key == 13)
                {
                    // console.log(this);
                    $(this).blur();
                    e.preventDefault();
                }
              });
          }).on('input',function(){
              modify_address();
          });

          function modify_address(addr_id, data)
          {
              console.log('Modifying address: '+addr_id);
              for(var key in data)
              {
                  console.log('changing ' + key + ' to ' + data[key]);
              }
          }

          function change_cluster()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var sel_province = $('#select-province');
            $.get( "/address/search",{'params':{'cluster':cluster}}, function( data ) {
                 lData = data['top'][0]

                 provinces = []
                 for(d of lData)
                 {
                  if(provinces.indexOf(d.province)==-1)
                    provinces.push(d.province); 
                 }

                 elem = '';
                 elem += '<option value="">N/A</option>';
                 for(x of provinces.sort())
                 {
                  elem += '<option value="'+x+'">'+x+"</option>";
                 }
                 sel_province.html(elem);
                 change_province();
                 change_city();
                 change_district();
                 change_barangay();
                 change_area();
                 change_avenue();
            });
          }

          function change_province()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var province = $('#select-province').find(':selected').val();
            var sel_city = $('#select-city');
            $.get( "/address/search",{'params':{'cluster':cluster,'province':province}}, function( data ) {
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
                 
            });
          }

          function change_city()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var city = $('#select-city').find(':selected').val();
            var province = $('#select-province').find(':selected').val();
            var sel_district = $('#select-district');
            $.get( "/address/search",{'params':{'cluster':cluster,'province':province,'city':city}}, function( data ) {
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
                 
            });
          }

          function change_district()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var province = $('#select-province').find(':selected').val();
            var city = $('#select-city').find(':selected').val();
            var district = $('#select-district').find(':selected').val();
            var sel_barangay = $('#select-barangay');
            $.get( "/address/search",{'params':{'cluster':cluster,'province':province,'city':city, 'district':district}}, function( data ) {
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
                 
            });
          }

          function change_barangay()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var province = $('#select-province').find(':selected').val();
            var city = $('#select-city').find(':selected').val();
            var district = $('#select-district').find(':selected').val();
            var barangay = $('#select-barangay').find(':selected').val();
            var sel_area = $('#select-area');
            $.get( "/address/search",{'params':{'cluster':cluster,'province':province,'city':city, 'district':district,'barangay':barangay}}, function( data ) {
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
                 
            });
          }

          function change_area()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var province = $('#select-province').find(':selected').val();
            var city = $('#select-city').find(':selected').val();
            var district = $('#select-district').find(':selected').val();
            var barangay = $('#select-barangay').find(':selected').val();
            var area = $('#select-area').find(':selected').val();
            var sel_avenue = $('#select-avenue');
            $.get( "/address/search",{'params':{'cluster':cluster,'province':province,'city':city, 'district':district,'barangay':barangay,'area':area}}, function( data ) {
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
                 
            });
          }

          function change_avenue()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var province = $('#select-province').find(':selected').val();
            var city = $('#select-city').find(':selected').val();
            var district = $('#select-district').find(':selected').val();
            var barangay = $('#select-barangay').find(':selected').val();
            var area = $('#select-area').find(':selected').val();
            var avenue = $('#select-avenue').find(':selected').val();
            var sel_street = $('#select-street');
            $.get( "/address/search",{'params':{'cluster':cluster,'province':province,'city':city, 'district':district,'barangay':barangay,'area':area,'avenue':avenue}}, function( data ) {
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
                 
            });
          }
          $(document).ready(function(){
            change_cluster();
          });
          $('#select-cluster').on('change',change_cluster);
          $('#select-province').on('change',change_province);
          $('#select-city').on('change',change_city);
          $('#select-district').on('change',change_district);
          $('#select-barangay').on('change',change_barangay);
          $('#select-area').on('change',change_area);
          $('#select-avenue').on('change',change_avenue);
          $('select').on('change',function(){

            var cluster = $('#select-cluster').find(':selected').val();
            var province = $('#select-province').find(':selected').val();
            var city = $('#select-city').find(':selected').val();
            var district = $('#select-district').find(':selected').val();
            var barangay = $('#select-barangay').find(':selected').val();
            var area = $('#select-area').find(':selected').val();
            var avenue = $('#select-avenue').find(':selected').val();
            var street = $('#select-street').find(':selected').val();
            var table_cluster = $('#table-cluster');
            $.get( "/address/search",{'params':{'cluster':cluster,'province':province, 'city':city, 'district': district,'barangay':barangay, 'area':area, 'avenue': avenue, 'street':street}}, function( data ) {
                 elem = '';
                 lData = data['top'][0]

                 for(d of lData )
                 {
                 //  addr = '';
                    elem += '<tr data-value="'+ d.id +'">';
                    elem += '<td data-value="'+ d.cluster +'">'+ d.cluster +'</td>';
                    elem += '<td data-attr="province" contenteditable data-value="'+ d.province +'">'+ d.province +'</td>';
                    elem += '<td data-attr="city" contenteditable data-value="'+ d.city +'">'+ d.city +'</td>';
                    elem += '<td data-attr="barangay" contenteditable data-value="'+ d.barangay +'">'+ d.barangay +'</td>';
                    elem += '<td data-attr="district" contenteditable data-value="'+ d.district +'">'+ d.district +'</td>';
                    elem += '<td data-attr="area" contenteditable data-value="'+ d.area +'">'+ d.area +'</td>';
                    elem += '<td data-attr="avenue" contenteditable data-value="'+ d.avenue +'">'+ d.avenue +'</td>';
                    elem += '<td data-attr="street" contenteditable data-value="'+ d.street+'">'+ d.street +'</td>';
                    elem += '<td data-attr="is_serviceable" data-value="'+ d.is_serviceable +'"><input type="checkbox"'+ (d.is_serviceable?'checked':'') +'/></td>';
                    elem += '</tr>';
                    table_cluster.html(elem);
                 }

            });
          
          });

</script>
