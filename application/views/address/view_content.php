
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Address    <a href='#' onclick='add_address();' class='btn btn-danger' role='button'>Add</a></h1>

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
            <label for="select-barangay">Barangay:</label>
            <select class="form-control" name='select-barangay' id="select-barangay" >
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
                    <th></th>
                    <th>Cluster</th>
                    <th>Province</th>
                    <th>City</th>
                    <th>Barangay</th>
                    <th>District</th>
                    <th>Area</th>
                    <th>Avenue</th>
                    <th>Street</th>
                    <!-- <th>Serviceable</th> -->
                  </tr>
                </thead>
                <tbody id='table-cluster'>
                <?php foreach ($address as $address_item): ?>
                      <?php 
                        echo "<tr data-value='".$address_item['id']."'>";
                        // echo "<td>".$address_item['id']."</td>";
                        echo "<td data-value='".$address_item['id']."'><a href='#' class='btn btn-danger' role='button'>Delete</a></td>";
                        echo "<td data-value='".$address_item["cluster"]['name']."'>".$address_item["cluster"]['name']."</td>";
                        echo "<td contenteditable data-attr='province' data-value='".$address_item["province"]."'>".$address_item["province"]."</td>";
                        echo "<td contenteditable data-attr='city' data-value='".$address_item["city"]."'>".$address_item["city"]."</td>";
                        echo "<td contenteditable data-attr='barangay' data-value='".$address_item["barangay"]."'>".$address_item["barangay"]."</td>";
                        echo "<td contenteditable data-attr='district' data-value='".$address_item["district"]."'>".$address_item["district"]."</td>";
                        echo "<td contenteditable data-attr='area' data-value='".$address_item["area"]."'>".$address_item["area"]."</td>";
                        echo "<td contenteditable data-attr='avenue' data-value='".$address_item["avenue"]."'>".$address_item["avenue"]."</td>";
                        echo "<td contenteditable data-attr='street' data-value='".$address_item["street"]."'>".$address_item["street"]."</td>";
                        // echo "<td data-value='".$address_item["is_serviceable"]."' data-attr='is_serviceable'>";

                        // if ($address_item['is_serviceable'] == 't'){
                        //   echo "<input type='checkbox' checked/>";
                        // }else{
                        //   echo "<input type='checkbox'/>";
                        // }
                        // echo "</td>";
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

<div id="dialog-delete" title="Delete Address">
</div>

<div id="dialog-message" title="Content Modification">
</div>

<div id="dialog-add" title="Add Address">
  <div class='dialog-input-group'>
    <label for="dialog-select-cluster">Cluster:</label>
    <select class="form-control" id="dialog-select-cluster">
        <?php
        foreach ($ret as $key => $value) {
          echo "<option value='".$key."'>".$value['name']."</option>";
        }                
        ?>
    </select>
  </div>
  <div class='dialog-input-group'>
    <label for="dialog-province">Province:</label><br>
    <input id="dialog-province" data-attr='province' type="text" name="dialog-province">
  </div>
  <div class='dialog-input-group'>
    <label for="dialog-city">City:</label><br>
    <input id="dialog-city" data-attr='city' type="text" name="dialog-city">
  </div>
  <div class='dialog-input-group'>
    <label for="dialog-barangay">Barangay:</label><br>
    <input id="dialog-barangay" data-attr='barangay' type="text" name="dialog-barangay">
  </div>
  <div class='dialog-input-group'>
    <label for="dialog-district">District:</label><br>
    <input id="dialog-district" data-attr='district' type="text" name="dialog-district">
  </div>
  <div class='dialog-input-group'>
    <label for="dialog-area">Area:</label><br>
    <input id="dialog-area" data-attr='area' type="text" name="dialog-area">
  </div>
  <div class='dialog-input-group'>
    <label for="dialog-avenue">Avenue:</label><br>
    <input id="dialog-avenue" data-attr='avenue' type="text" name="dialog-avenue">
  </div>
  <div class='dialog-input-group'>
    <label for="dialog-street">Street:</label><br>
    <input id="dialog-Street" data-attr='street' type="text" name="dialog-street">
  </div>



</div>
<script>
          $('div[id^=dialog]').hide();
          $('#table-cluster').on('click','td a', function(){
            // delete_address();
            var node = $(this);
            var id = node.parent().data('value');
            delete_address(this,id);
          });

          function delete_address(e,id=-1)
          {
            $('#dialog-delete').html('<p>Are you sure you want to delete address?</p>');
            $( "#dialog-delete" ).dialog({
                  modal: true,
                  buttons: {
                      Yes: function () {
                          node = $(e).parents('tr');
                          // console.log(id);
                          $.post('/address/delete',{'id':id}, function(data){
                            if(data.success == 1)
                            {
                              alert('Deleted address!');
                              node.hide(1000);
                            }
                          })

                          $(this).dialog("close");
                      },
                      No: function () {
                          $(this).dialog("close");
                      }
                  }
            });
          }
          function add_address()
          {
                var tags = []
                $( "#dialog-add" ).dialog({
                  modal: true,
                  buttons: {
                    Save: function(e) {
                      var input = $('.dialog-input-group select,.dialog-input-group input');
                      var cluster = $(input[0]).prop('value');
                      var province = $(input[1]).prop('value');
                      var city = $(input[2]).prop('value');
                      var barangay = $(input[3]).prop('value');
                      var district = $(input[4]).prop('value');
                      var area = $(input[5]).prop('value');
                      var avenue = $(input[6]).prop('value');
                      var street = $(input[7]).prop('value');
                      var node = $(this);
                      // console.log('adding ' + cluster +' '+province+' '+city+' '+barangay+' '+district+' '+area+' '+avenue+' '+street)
                      var params = {
                        'cluster':cluster,
                        'province':province,
                        'city':city,
                        'district':district,
                        'barangay':barangay,
                        'area':area,
                        'avenue':avenue,
                        'street':street,
                        'duplicate':true
                      }
                          $.post( "/address/add",{'params':params}, function(data){
                            if(data.success == 1)
                            {
                              alert('Added address!');
                              update_table();
                              node.find('input').each(function(){
                                $(this).val('');
                              })
                              node.dialog('close');
                            }
                            else
                              alert('Address exists!');
                          });
                    }
                  }
                });

                $('input').keypress(function(e){
                  var node = $(this)
                  var cluster = $('#dialog-select-cluster').val();

                  var params ={
                    'attr': node.data('attr'),
                    'value': node.val()+e.key
                  }
                  $.get( "/address/get_tags", params, function( data ) {
                    tags = data.tags;
                  
                    node.autocomplete({
                      source: tags
                    })
                  })
                })
           }
          $('table').on('change','input[type=checkbox]', function(){
            var td = $(this).parent();
            var tr = td.parent();

            var col = td.data('attr');
            var id = tr.data('value');
            // var is_serviceable = $(this).prop('checked');
            var params = {};
            params['id'] = id;
            // params['attr'] = 'is_serviceable';
            // params['is_serviceable'] = is_serviceable;
            modify_address(params);
          });
          $('td').on('focus', function(){
              $(this).keypress(function(e){
                var key = e.which;

                if(key == 13)
                {
                    $('td').prop('contenteditable', false);
                    var node = $(this);
                    var id = node.parent().data('value');
                    var attr = node.data('attr');
                    var val = node.html().replace(/<br>/g,'');
                    node.html(val);
                    // console.log('changing adress id '+id+' with column '+attr+' to value '+val); 
                    params = {};
                    params['id'] = id;
                    params['attr'] = attr;
                    params[attr] = val;

                    $('table').prop('disabled', true);
                    modify_address(params);
                    e.preventDefault();
                   
                }
              });
          });


          function modify_address(params)
          {
              var attr = params['attr'];
              delete params['attr'];
                $('#dialog-message').html('<p>Loading...</p>');
                $( "#dialog-message" ).dialog({
                  modal: true
                });
              $.get( "/address/modify",{'params':params}, function( data ) {
                if(attr == 'is_serviceable'){
                  if(params[attr] == true)
                    $('#dialog-message').html('<p>Address can now be serviced!</p>');
                  else
                    $('#dialog-message').html('<p>Address is now disabled for service!</p>');
                }
                else
                  $('#dialog-message').html('<p>You have modified ' + attr + ' to ' + (params[attr]==''?'None':params[attr]) +'!</p>');
                $( "#dialog-message" ).dialog({
                  modal: true,
                  buttons: {
                    Ok: function(e) {
                      $( this ).dialog( "close" );
                      $('td').prop('contenteditable', true);
                      $('#select-cluster').focus();
                    }
                  }
                });
              });   
          }
          function count(dict)
          {
            return Object.keys(dict).length
          }
          function change_cluster()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var sel_province = $('#select-province');
            $.get( "/address/search",{'params':{'cluster':cluster}}, function( data ) {
                 lData = data['top']

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
                 change_barangay();
                 change_district();
                 change_area();
                 change_avenue();
            });
          }

          function change_province()
          {
            var params = {}
            var cluster = $('#select-cluster').find(':selected').val();
            if(cluster != -1)
              params['cluster'] = cluster;
            var province = $('#select-province').find(':selected').val();
            if(province != '')
              params['province'] = province
            if(count(params) == 0)
              params['cluster'] = cluster
            var sel_city = $('#select-city');
            $.get( "/address/search",{'params':params}, function( data ) {
                 lData = data['top']

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
                 change_barangay();
                 change_district();
                 change_area();
                 change_avenue();
                 
            });
          }

          function change_city()
          {
            var params = {}
            var cluster = $('#select-cluster').find(':selected').val();
            if(cluster != -1) 
              params['cluster'] = cluster
            var province = $('#select-province').find(':selected').val();
            if(province != '') 
              params['province'] = province
            var city = $('#select-city').find(':selected').val();
            if(city != '') 
              params['city'] = city
            if(count(params) == 0)
              params['cluster'] = cluster
            var sel_barangay = $('#select-barangay');
            $.get( "/address/search",{'params':params}, function( data ) {
                 lData = data['top']

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
                 change_district();
                 change_area();
                 change_avenue();
                 
            });
          }
          function change_barangay()
          {
            var params = {}
            var cluster = $('#select-cluster').find(':selected').val();
            if(cluster != -1) 
              params['cluster'] = cluster
            var province = $('#select-province').find(':selected').val();
            if(province != '') 
              params['province'] = province
            var city = $('#select-city').find(':selected').val();
            if(city != '') 
              params['city'] = city
            var barangay = $('#select-barangay').find(':selected').val();
            if(barangay != '') 
              params['barangay'] = barangay
            if(count(params) == 0)
              params['cluster'] = cluster
            var sel_district = $('#select-district');
            $.get( "/address/search",{'params':params}, function( data ) {  
                 lData = data['top']

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
                 change_area();
                 change_avenue();                 
            });
          }

          function change_district()
          {
            var params = {}
            var cluster = $('#select-cluster').find(':selected').val();
            if(cluster != -1) 
              params['cluster'] = cluster
            var province = $('#select-province').find(':selected').val();
            if(province != '') 
              params['province'] = province
            var city = $('#select-city').find(':selected').val();
            if(city != '') 
              params['city'] = city
            var barangay = $('#select-barangay').find(':selected').val();
            if(barangay != '') 
              params['barangay'] = barangay
            var district = $('#select-district').find(':selected').val();
            if(district != '') 
              params['district'] = district
            if(count(params) == 0)
              params['cluster'] = cluster
            var sel_area = $('#select-area');
            $.get( "/address/search",{'params':params}, function( data ) {
 
                 lData = data['top']

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
            var params = {};
            var cluster = $('#select-cluster').find(':selected').val();
            if(cluster != -1) 
              params['cluster'] = cluster
            var province = $('#select-province').find(':selected').val();
            if(province != '') 
              params['province'] = province
            var city = $('#select-city').find(':selected').val();
            if(city != '') 
              params['city'] = city
            var barangay = $('#select-barangay').find(':selected').val();
            if(barangay != '') 
              params['barangay'] = barangay
            var district = $('#select-district').find(':selected').val();
            if(district != '') 
              params['district'] = district
            var area = $('#select-area').find(':selected').val();
            if(area != '') 
              params['area'] = area
            if(count(params) == 0)
              params['cluster'] = cluster
            var sel_avenue = $('#select-avenue');
            $.get( "/address/search",{'params':params}, function( data ) {
                 lData = data['top']

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
            var params = {};
            var cluster = $('#select-cluster').find(':selected').val();
            if(cluster != -1) 
              params['cluster'] = cluster
            var province = $('#select-province').find(':selected').val();
            if(province != '') 
              params['province'] = province
            var city = $('#select-city').find(':selected').val();
            if(city != '') 
              params['city'] = city
            var barangay = $('#select-barangay').find(':selected').val();
            if(barangay != '') 
              params['barangay'] = barangay
            var district = $('#select-district').find(':selected').val();
            if(district != '') 
              params['district'] = district
            var area = $('#select-area').find(':selected').val();
            if(area != '') 
              params['area'] = area
            var avenue = $('#select-avenue').find(':selected').val();
            if(avenue != '') 
              params['avenue'] = avenue
            if(count(params) == 0)
              params['cluster'] = cluster
            var sel_street = $('#select-street');
            $.get( "/address/search",{'params':params}, function( data ) {
                 lData = data['top']

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
                 update_table();
            });
          }
          $(document).ready(function(){
            change_cluster();
          });

          function update_table()
          {
            var cluster = $('#select-cluster').find(':selected').val();
            var province = $('#select-province').find(':selected').val();
            var city = $('#select-city').find(':selected').val();
            var barangay = $('#select-barangay').find(':selected').val();
            var district = $('#select-district').find(':selected').val();
            var area = $('#select-area').find(':selected').val();
            var avenue = $('#select-avenue').find(':selected').val();
            var street = $('#select-street').find(':selected').val();
            var table_cluster = $('#table-cluster');

            params={
                'province':province,
                'city':city,
                'barangay':barangay,
                'district': district,
                'area':area,
                'avenue': avenue,
                'street':street
            }
            if(cluster != -1)
            {
              params['cluster'] = cluster;  
            }
            // console.log('params',params);
            $.get( "/address/search",{'params':params}, function( data ) {
                 elem = '';
                 lData = data['top']

                 for(d of lData )
                 {
                 //  addr = '';
                    elem += '<tr data-value="'+ d.id +'">';
                    elem += '<td data-value=' + d.id + '><a href="#" class="btn btn-danger" role="button">Delete</a></td>';
                    elem += '<td data-value="'+ d.cluster +'">'+ d.cluster +'</td>';
                    elem += '<td data-attr="province" contenteditable data-value="'+ d.province +'">'+ d.province +'</td>';
                    elem += '<td data-attr="city" contenteditable data-value="'+ d.city +'">'+ d.city +'</td>';
                    elem += '<td data-attr="barangay" contenteditable data-value="'+ d.barangay +'">'+ d.barangay +'</td>';
                    elem += '<td data-attr="district" contenteditable data-value="'+ d.district +'">'+ d.district +'</td>';
                    elem += '<td data-attr="area" contenteditable data-value="'+ d.area +'">'+ d.area +'</td>';
                    elem += '<td data-attr="avenue" contenteditable data-value="'+ d.avenue +'">'+ d.avenue +'</td>';
                    elem += '<td data-attr="street" contenteditable data-value="'+ d.street+'">'+ d.street +'</td>';
                    // elem += '<td data-attr="is_serviceable" data-value="'+ d.is_serviceable +'"><input type="checkbox"'+ (d.is_serviceable=='t'?'checked':'') +'/></td>';
                    elem += '</tr>';
                 }
                table_cluster.html(elem);

            });
          
          
          }
          $('#table-cluster').on('mouseover','tr td:not(:first-child)',function(){
            var node = $(this);
            node.data('border', node.css('border'));
            node.css('border','1px solid rgb(30,144,255)');
          }).on('mouseout','tr td:not(:first-child)',function(){
            var node = $(this);
            node.css('border',node.data('border'));
          });
          $('#select-cluster').on('change',change_cluster);
          $('#select-province').on('change',change_province);
          $('#select-city').on('change',change_city);
          $('#select-barangay').on('change',change_barangay);
          $('#select-district').on('change',change_district);
          $('#select-area').on('change',change_area);
          $('#select-avenue').on('change',change_avenue);
          // $('select[id^=select]').on('change',update_table);

</script>
