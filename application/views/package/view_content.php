
        <script type="text/javascript">
          var dBox = [];
        </script>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Package</h1>
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
          <div class="table-responsive"">
            <table class="table table-hover">
              <?php 

              if (empty($package)){
                 echo '<h4>No package.</h4>';
                } 
              else{
              ?>
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Address</th>
                  <th>Length (m)</th>
                  <th>Width (m)</th>
                  <th>Height (m)</th>
                  <th>Weight (kg)</th>
                  <th>X Coordinates</th>
                  <th>Y Coordinates</th>
                  <th>Z Coordinates</th>
                  <th>Orientation</th>
                  <th>Date Arrived</th>
                  <th>Fragile</th>
                </tr>
              </thead>
              <tbody>

              <?php foreach ($package as $package_item): ?>

                    <?php 
                      foreach ($address as $address_item) {
                        if ($address_item['id'] == $package_item['address']){
                          echo "<tr data-cluster='".$address_item['cluster']."' id='package-".$package_item['id']."'>";
                          break;
                        }
                      }
                      echo "<td>".$package_item['id']."</td>";
                      echo "<td>".$package_item['address']."</td>";
                      echo "<td>".$package_item['length']."</td>";
                      echo "<td>".$package_item['width']."</td>";
                      echo "<td>".$package_item['height']."</td>";
                      echo "<td>".$package_item['weight']."</td>";
                      echo "<td>".$package_item['x1']."</td>";
                      echo "<td>".$package_item['y1']."</td>";
                      echo "<td>".$package_item['z1']."</td>";
                      if ($package_item['length'] == $package_item['width']){
                        echo "<td>Square</td>";
                      }else{
                        echo "<td>".$package_item['orientation']."</td>";
                      }
                      echo "<td>".$package_item['arrival_date']."</td>";
                      if ($package_item['is_fragile']){
                        echo "<td>True</td>";
                      }else{
                        echo "<td>False</td>";
                      }
                      echo "</tr>";
                      // echo "<script>";
                      // echo "dBox.push({";
                      // echo "'id':".$package_item['id'].",";
                      // echo "'address':".$package_item['address'].",";
                      // echo "'length':".$package_item['length'].",";
                      // echo "'width':".$package_item['width'].",";
                      // echo "'height':".$package_item['height'].",";
                      // echo "'weight':".$package_item['weight'].",";
                      // echo "'x1':".$package_item['x1'].",";
                      // echo "'y1':".$package_item['y1'].",";
                      // echo "'z1':".$package_item['z1']."";
                      // echo "});";
                      // echo "</script>";
                    ?>
              <?php endforeach; ?>

              </tbody>
            </table>
            <?php }; //CLOSING ELSE?>

          <div class="table-responsive"">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Address</th>
                    <th>Length (m)</th>
                    <th>Width (m)</th>
                    <th>Height (m)</th>
                    <th>Weight (kg)</th>
                    <th>Date Arrived</th>
                    <th>Fragile</th>
                  </tr>
                </thead>
                <tbody id='package-table'>
                </tbody>
              </table>
            </div>

          </div>

          <?php if (!empty($package)){ ?>
          <div class='row'>
            <div class='col-sm-4' id='box-info'>
              <h1>Details</h1>
              <h4>ID: <small><span id='box-info-id'>N/A<span></small></h4>
              <h4>Address:<small><span id='box-info-address'>N/A<span></small></h4>
              <h4>Length:<small><span id='box-info-length'>N/A<span></small></h4>
              <h4>Width:<small><span id='box-info-width'>N/A<span></small></h4>
              <h4>Height:<small><span id='box-info-height'>N/A<span></small></h4>
              <h4>Weight:<small><span id='box-info-weight'>N/A</span></small></h4>

            </div>
            <div class='col-sm-8' id='canvas' style="margin:0 auto;display:table;float:right;">
              <canvas id='package_canvas' style="height:50vh;">
              </canvas>
            </div>
          </div>
          <?php } ?>
        </div>


      </div>
    </div>
        <script>
          var dBox = [];
          $(".dropdown-menu li a").click(function(){
            $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
            $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
            alert($(".dropdown-menu li a").value());

          });

          window.addEventListener('DOMContentLoaded', function(){
              var canvas = document.getElementById('package_canvas');
              var engine = new BABYLON.Engine(canvas, true);

              var createScene = function () {
                  var scene = new BABYLON.Scene(engine);

                  var camera = new BABYLON.ArcRotateCamera("Camera", Math.PI, Math.PI / 8, 5, BABYLON.Vector3.Zero(), scene);

                  camera.attachControl(canvas, true);
                  var light = new BABYLON.HemisphericLight("hemi", new BABYLON.Vector3(0, 1, 0), scene);

                  var material = new BABYLON.StandardMaterial('wireframe', scene);
                  material.wireframe = true;

                  var pinkMat = new BABYLON.StandardMaterial("pink", scene);
                  pinkMat.emissiveColor = new BABYLON.Color3(.5, .2, .3);

                  var mouseOverUnit = function(unit_mesh) {
                    if (unit_mesh.meshUnderPointer !== null) {
                        // console.log(box_hovered);
                        // console.log(tooltip);

                        // console.log($('#package'+unit_mesh.source));
                        // console.log($('#package'+unit_mesh.source.name.replace('box', '')));
                        // console.log(unit_mesh);
                        id = $('#box-info-id');
                        address = $('#box-info-address');
                        length = $('#box-info-length');
                        width = $('#box-info-width');
                        height = $('#box-info-height');
                        weight = $('#box-info-weight');
                        box = dBox[unit_mesh.source.name.replace('box', '')];
                        id.prop('innerText',box.id);
                        address.prop('innerText',box.address);
                        length.prop('innerText',box.length);
                        width.prop('innerText',box.width);
                        height.prop('innerText',box.height);
                        weight.prop('innerText',box.weight);
                        unit_mesh.source.material = material;
                        unit_mesh.meshUnderPointer.renderOutline = true;  
                        // unit_mesh.meshUnderPointer.outlineWidth = 0.1;
                    }
                  }
                  
                  var mouseOutUnit = function(unit_mesh) {
                    if (unit_mesh.source !== null) {

                        id = $('#box-info-id');
                        address = $('#box-info-address');
                        length = $('#box-info-length');
                        width = $('#box-info-width');
                        height = $('#box-info-height');
                        weight = $('#box-info-weight');
                        box = dBox[unit_mesh.source.name.replace('box', '')];
                        id.prop('innerText','N/A');
                        address.prop('innerText','N/A');
                        length.prop('innerText','N/A');
                        width.prop('innerText','N/A');
                        height.prop('innerText','N/A');
                        weight.prop('innerText','N/A');

                        unit_mesh.source.material = pinkMat;
                        unit_mesh.source.renderOutline = false; 
                        // unit_mesh.source.outlineWidth = 0.1;
                    }
                  }

                  // var address = BABYLON.Mesh.CreateBox("address", 6, scene);

                  // //x , y, z = width, depth, height
                  // // console.log(lBox);
                  var address = BABYLON.Mesh.CreatePlane("ground", 0, scene);
                  // address.material = material;
                  address.rotation.x = Math.PI / 2;
                  address.scaling.x = 6;
                  address.scaling.y = 2.4

                  var action_mouse_over = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOverTrigger, mouseOverUnit);
                  var action_mouse_out = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOutTrigger, mouseOutUnit);

                  var box = {}
                  // for (var i = 1; i <= 4; i++) {
                  // for (var i = 1; i <= Object.keys(dBox).length; i++) {
                  dBox.forEach(function(b, i){

                      box[i] = BABYLON.MeshBuilder.CreateBox("box"+i,  {width: b.width ,height: b.height,depth:b.length}, scene);
                      box[i].material = pinkMat;
                      x = 3-((b.width/2)+b.x1);
                      y = (b.height/2)+b.z1;
                      z = 1.2-((b.length/2)+b.y1);
                      box[i].position = new BABYLON.Vector3(x,y,z);
                      box[i].actionManager = new BABYLON.ActionManager(scene);  
                      box[i].actionManager.registerAction(action_mouse_over);
                      box[i].actionManager.registerAction(action_mouse_out);
                  });
                  return scene;
              }

              var scene = createScene();
              engine.runRenderLoop(function(){
                  scene.render();
 
              });

          });

          $('#cluster-select').on('change', function (e) {
              var optionSelected = $("option:selected", this);
              var valueSelected = this.value;

              var row = '';
              if(valueSelected==-1){
                
              }else{
                $.get( "/package/",{'cluster_id':valueSelected}, function( data ) {
                    for (key in data){
                      row += "<tr data-cluster="+valueSelected+">";
                      row += "<td editable='text' value='" + data[key].id+"'>" + data[key].id + "</td>";
                      row += "<td editable='text' value='" + data[key].address+"'>" + data[key]['address'].city + "</td>";
                      row += "<td editable='text' value='" + data[key].length+"'>" + data[key].length + "</td>";
                      row += "<td editable='text' value='" + data[key].width+"'>" + data[key].width + "</td>";
                      row += "<td editable='text' value='" + data[key].height+"'>" + data[key].height + "</td>";
                      row += "<td editable='text' value='" + data[key].weight+"'>" + data[key].weight + "</td>";
                      row += "<td editable='date' value='" + data[key].arrival_date+"'>" + data[key].arrival_date + "</td>";
                      row += "<td editable='boolean?' value='" + data[key].is_fragile+"'>" + data[key].is_fragile + "</td>";
                      row += "</tr>";
                      dBox.push({
                        id: data[key].id,
                        address: data[key]['address'].city,
                        length: data[key]['length'],
                        width: data[key]['width'],
                        height: data[key]['height'],
                        weight: data[key]['weight'],
                        x1: data[key]['x1'],
                        y1: data[key]['y1'],
                        z1: data[key]['z1']                        
                      });
                    }
                    $('#package-table').html(row);

                });
              }
              row = '';
          });

        </script>
