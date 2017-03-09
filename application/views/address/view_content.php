
  
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
                <label for="cluster-select">Cluster:</label>
                <select class="form-control" id="cluster-select">
                  <option value='-1'>NONE</option>
                  <?php
                  foreach ($ret as $key => $value) {
                    echo "<option value='".$key."'>".$value['name']."</option>";
                  }
                  
                  ?>
                </select>
              </div>

              <div class='input-group'>
                <label for="location-select">Location:</label>
                <select class="form-control" id="location-select">
                  <option value='1'>N/A</option>

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
                    <th>City</th>
                    <th>Keywords</th>
                    <th>Serviceable</th>
                  </tr>
                </thead>
                <tbody id='cluster-table'>
                <?php foreach ($address as $address_item): ?>
                      <?php 
                        echo "<tr>";
                        // echo "<td>".$address_item['id']."</td>";
                        echo "<td editable='text' value='".$address_item["cluster"]['id']."'>".$address_item["cluster"]['name']."</td>";
                        echo "<td editable='text' value='".$address_item["city"]."'>".$address_item["city"]."</td>";
                        echo "<td editable='text' value='".$address_item["keywords"]."'>".$address_item["keywords"]."</td>";
                        echo "<td editable='boolean' value='".$address_item["is_serviceable"]."'>";
                        if ($address_item['is_serviceable']){
                          echo "True";
                        }else{
                          echo "False";
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
  <?php
    if ($this->tank_auth->get_username() != 'admin')
    {
  ?>
    $('td[editable]').removeAttr('editable');
  <?php 
    } 
    else if ($this->tank_auth->get_username() == 'admin')
    {
  ?>  
    $('td[editable]').click(function(event){
      //event.target.contentEditable = true;
      //alert(event.target);
      //t = event.target; 
      //event.target.html('<input type=number/>')
    });
  <?php
    }
  ?>
    $('#cluster-select').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;

        if(valueSelected==-1)
          $('#location-select').html("<option value='1'>N/A</option>");
        else{
          $.get( "/address/",{'cluster_id':valueSelected}, function( data ) {
              var options = '';
              for (var x = 0; x < data.length; x++) {
                  options += '<option value="' + data[x]['id'] + '">' + data[x]['keywords'] + '</option>';
              }
              $('#location-select').html(options);

              //                      echo "<tr>";
              //           // echo "<td>".$address_item['id']."</td>";
              //           echo "<td editable='text' value='".$address_item["cluster"]['id']."'>".$address_item["cluster"]['name']."</td>";
              //           echo "<td editable='text' value='".$address_item["city"]."'>".$address_item["city"]."</td>";
              //           echo "<td editable='text' value='".$address_item["keywords"]."'>".$address_item["keywords"]."</td>";
              //           echo "<td editable='boolean' value='".$address_item["is_serviceable"]."'>";
              //           if ($address_item['is_serviceable']){
              //             echo "True";
              //           }else{
              //             echo "False";
              //           }
              //           echo "</td>";
              //           echo "</tr>";

              var row = '';
              for (var x = 0; x < data.length; x++) {
                row += "<tr>";
                row += "<td editable='text' value='" + data[x]['cluster']+"'>"
                row += "</tr>";
              }
              console.log(data);
          });
        }
    });

</script>
