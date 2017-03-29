
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
              <a href='#' onclick='clear_package();' class='btn btn-danger' id='btn-clear-package' role='button'>Clear Packages</a>
 

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

<div id="dialog-erase" title="Clear Package">
</div>

      </div>
    </div>
        <script>
        $('#cluster-select').ready(function(){
          var btn = $('#btn-clear-package');
          btn.hide();
        }).on('change', function(){
          var btn = $('#btn-clear-package');
          if($(this).val() == -1)
          {
            btn.hide();
          }
          else
            btn.show();

        });
        function clear_package()
        {
          var cluster_node = $('#cluster-select');
          var erase_code = 'I will erase packages in '+cluster_node.find(':selected').html();
          $("#dialog-erase").html('Type the sentence in bold letters: "<strong>' + erase_code +'</strong>"<br/><input id="dialog-erase-input" type="text"/>');
          $( "#dialog-erase" ).dialog({
                  modal: true,
                  buttons: {
                    Erase: function(e) {
                      cluster = cluster_node.val()
                      confirmation = $('#dialog-erase-input').val();
                      if(confirmation == erase_code){
                      // console.log('adding ' + cluster +' '+province+' '+city+' '+barangay+' '+district+' '+area+' '+avenue+' '+street)
                          $.get( "/cluster/clear",{'cluster_id':cluster}, function(data){
                            if(data.success == 1)
                            {
                              alert('Cleared cluster of packages!');
                              location.reload();
                            }
                            else
                              alert('Error!');
                          });
                      }else{
                        alert('Wrong confirmation!');
                        $(this).dialog("close");
                      }
                    }
                  }
                });
        }

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
                      row += "<td data-value='" + data['packages'][key].id+"'>" + data['packages'][key].id + "</td>";
                      row += "<td data-value='" + data['packages'][key].address+"'>" + data['packages'][key]['address'].city + "</td>";
                      row += "<td data-value='" + data['packages'][key].length+"'>" + data['packages'][key].length + "</td>";
                      row += "<td data-value='" + data['packages'][key].width+"'>" + data['packages'][key].width + "</td>";
                      row += "<td data-value='" + data['packages'][key].height+"'>" + data['packages'][key].height + "</td>";
                      row += "<td data-value='" + data['packages'][key].weight+"'>" + data['packages'][key].weight + "</td>";
                      row += "<td data-value='" + data['packages'][key].arrival_date+"'>" + data['packages'][key].arrival_date + "</td>";
                      row += "<td data-value='" + data['packages'][key].is_fragile+"'>" + ((data['packages'][key].is_fragile=='t')?"True":"False") + "</td>";
                      row += "</tr>";

                      addr = '';
                      
                      for(attr of ['area', 'street','avenue','district','barangay','city','province'])
                      {
                        addr += data['packages'][key]['address'][attr];
                        if (data['packages'][key]['address'][attr].length != 0 && attr!='province')
                        {
                          addr += ', ';
                        }
                      }

                      dBox.push({
                        id: data['packages'][key].id,
                        address: addr,
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
                        // console.log(unit_mesh);
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
                  address.scaling.x = cluster_length/100;
                  address.scaling.y = cluster_width/100;

                  var action_mouse_over = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOverTrigger, mouseOverUnit);
                  var action_mouse_out = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOutTrigger, mouseOutUnit);

                  var box = {}
                  // for (var i = 1; i <= 4; i++) {
                  // for (var i = 1; i <= Object.keys(dBox).length; i++) {
                  if(dBox.length > 0){
                    xcalibrate = (cluster_length/100)/2;
                    ycalibrate = (cluster_width/100)/2;
                    dBox.forEach(function(b, i){
                            box[b.id] = BABYLON.MeshBuilder.CreateBox("box"+i,  {width: b.width/100 ,height: b.height/100,depth:b.length/100}, scene);
                          console.log('created box in '+i +' | id:'+b.id);
                          // console.log('created box in '+i +' | id:'+b.id, box[i]);
                            box[b.id].material = pinkMat;
                            x = xcalibrate-(((b.width/100)/2)+b.x1/100);
                            y = ((b.height/100)/2)+b.z1/100;
                            z = ycalibrate-(((b.length/100)/2)+b.y1/100);
                            box[b.id].position = new BABYLON.Vector3(x,y,z);
                            // console.log(box[i].position.y);
                            box[b.id].actionManager = new BABYLON.ActionManager(scene);  
                            box[b.id].actionManager.registerAction(action_mouse_over);
                            box[b.id].actionManager.registerAction(action_mouse_out);
                    });
                  }


                  // $('tr').hover(function(){
                  //   id = $($(this).find('td')[0]).text()-1;
                  //   console.log(id);
                  //   if(id>-1)
                  //   {
                  //     box[id].material = material;
                  //     box[id].renderOutline = true;
                  //   }
                  // },function (){
                  //   id = $($(this).find('td')[0]).text()-1;
                  //   if(id>-1)
                  //   {
                  //     box[id].material = pinkMat;
                  //     box[id].renderOutline = false;
                  //   }
                  // });
                  return scene;
              }

              var scene = createScene();
              engine.runRenderLoop(function(){
                  scene.render();
              });

          };


        </script>
