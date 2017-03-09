
  
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
    $('#cluster-select').on('change', function (e) {
        var optionSelected = $("option:selected", this);
        var valueSelected = this.value;

        var row = '';
        if(valueSelected==-1){
          $('#location-select').html("<option value='1'>N/A</option>");
          $.get( "/address/", function( data ) {
              adr = data;

              for (key in adr){
                row += "<tr>";
                row += "<td editable='text' value='" + adr[key]['cluster'].name+"'>" + adr[key]['cluster'].name + "</td>"
                row += "<td editable='text' value='" + adr[key].city+"'>" + adr[key].city + "</td>"
                row += "<td editable='text' value='" + adr[key].keywords+"'>" + adr[key].keywords + "</td>"
                row += "<td editable='boolean' value='" + adr[key].is_serviceable+"'>";
                row += adr[key].is_serviceable=='t'?'True':'False';
                row += "</td>"
                row += "</tr>";
              }
              $('#cluster-table').html(row);
          });
        }else{
          $.get( "/address/",{'cluster_id':valueSelected}, function( data ) {
              var options = '';
              adr = data[valueSelected]['location'];
              for (key in adr){
                options += '<option value="' + adr[key].id + '">' + adr[key].keywords + '</option>';

                row += "<tr>";
                row += "<td editable='text' value='" + adr[key].id+"'>" + data[valueSelected]['name'] + "</td>"
                row += "<td editable='text' value='" + adr[key].city+"'>" + adr[key].city + "</td>"
                row += "<td editable='text' value='" + adr[key].keywords+"'>" + adr[key].keywords + "</td>"
                row += "<td editable='boolean' value='" + adr[key].is_serviceable+"'>";
                row += adr[key].is_serviceable=='t'?'True':'False';
                row += "</td>"
                row += "</tr>";
              }
              $('#location-select').html(options);
              $('#cluster-table').html(row);
          });
        }
        row = '';
    });

</script>
