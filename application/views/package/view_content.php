
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
                <td>NONE</td>
                </tbody>
              </table>
            </div>


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

        </div>


      </div>
    </div>
        <script>
          var canvas = document.getElementById('package_canvas');
          var engine = new BABYLON.Engine(canvas, true);
          $('#cluster-select').on('change', function (e) {
              var optionSelected = $("option:selected", this);
              var valueSelected = this.value;

              var row = '';
              if(valueSelected==-1){
                
              }else{
                $.get( "/package/",{'cluster_id':valueSelected}, function( data ) {
                    var dBox = [];
                    var cluster = data['cluster']; 
                    
                    for (key in data['packages']){
                      row += "<tr data-cluster="+valueSelected+">";
                      row += "<td editable='text' value='" + data['packages'][key].id+"'>" + data['packages'][key].id + "</td>";
                      row += "<td editable='text' value='" + data['packages'][key].address+"'>" + data['packages'][key]['address'].city + "</td>";
                      row += "<td editable='text' value='" + data['packages'][key].length+"'>" + data['packages'][key].length + "</td>";
                      row += "<td editable='text' value='" + data['packages'][key].width+"'>" + data['packages'][key].width + "</td>";
                      row += "<td editable='text' value='" + data['packages'][key].height+"'>" + data['packages'][key].height + "</td>";
                      row += "<td editable='text' value='" + data['packages'][key].weight+"'>" + data['packages'][key].weight + "</td>";
                      row += "<td editable='date' value='" + data['packages'][key].arrival_date+"'>" + data['packages'][key].arrival_date + "</td>";
                      row += "<td editable='boolean' value='" + data['packages'][key].is_fragile+"'>" + ((data['packages'][key].is_fragile=='t')?"True":"False") + "</td>";
                      row += "</tr>";
                      dBox.push({
                        id: data['packages'][key].id,
                        address: data['packages'][key]['address'].city,
                        length: parseFloat(data['packages'][key]['length']),
                        width: parseFloat(data['packages'][key]['width']),
                        height: parseFloat(data['packages'][key]['height']),
                        weight: parseFloat(data['packages'][key]['weight']),
                        x1: parseFloat(data['packages'][key]['x1']),
                        y1: parseFloat(data['packages'][key]['y1']),
                        z1: parseFloat(data['packages'][key]['z1'])                       
                      });
                    }
                    $('#package-table').html(row);
                    // engine.dispose();
                    draw_canvas(cluster.length, cluster.width, dBox, canvas, engine);
                });
              }
              row = '';
          });
          $(".dropdown-menu li a").click(function(){
            $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
            $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
            alert($(".dropdown-menu li a").value());

          });
          // $('#cluster-select').on('change', function (e) {  
          // window.addEventListener('DOMContentLoaded', function(){
          var draw_canvas = function(cluster_length, cluster_width, dBox, canvas, engine){   


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
                  address.scaling.x = cluster_length;
                  address.scaling.y = cluster_width;

                  var action_mouse_over = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOverTrigger, mouseOverUnit);
                  var action_mouse_out = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOutTrigger, mouseOutUnit);

                  var box = {}
                  // for (var i = 1; i <= 4; i++) {
                  // for (var i = 1; i <= Object.keys(dBox).length; i++) {
                  if(dBox.length > 0){
                    xcalibrate = cluster_length/2;
                    ycalibrate = cluster_width/2;
                    dBox.forEach(function(b, i){
                            box[i] = BABYLON.MeshBuilder.CreateBox("box"+i,  {width: b.width ,height: b.height,depth:b.length}, scene);
                            box[i].material = pinkMat;
                            x = xcalibrate-((b.width/2)+b.x1);
                            y = (b.height/2)+b.z1;
                            z = ycalibrate-((b.length/2)+b.y1);
                            box[i].position = new BABYLON.Vector3(x,y,z);
                            box[i].actionManager = new BABYLON.ActionManager(scene);  
                            box[i].actionManager.registerAction(action_mouse_over);
                            box[i].actionManager.registerAction(action_mouse_out);
                    });
                  }

                  return scene;
              }

              var scene = createScene();
              engine.runRenderLoop(function(){
                  scene.render();
              });

          };


        </script>
