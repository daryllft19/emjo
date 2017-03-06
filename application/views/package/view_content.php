
        <script type="text/javascript">
          var dBox = {};
        </script>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Package</h1>
              <div class="dropdown package-drpdwn">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                All
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                <?php
                  echo '<li value="0"><a href="#">All</a></li>';
                  foreach ($cluster as $cluster_item): 
                    echo '<li value="'.$cluster_item['id'].'"><a href="#">'. $cluster_item['name'] .'</a></li>';
                  endforeach
                  ?>
                </ul>
              </div>
          <div class="table-responsive"">
            <table class="table table-striped">
              <?php 

              if (empty($package)){
                 echo '<h3>No package.</h3>';
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
                        if ($address_item['id'] == $package_item['container']){
                          echo "<tr data-cluster='".$address_item['cluster']."'>";
                          break;
                        }
                      }

                      echo "<td>".$package_item['id']."</td>";
                      echo "<td>".$package_item['container']."</td>";
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
                      echo "<script>";
                      echo "dBox[".$package_item['id']."] = {";
                      echo "'id':".$package_item['id'].",";
                      echo "'container':".$package_item['container'].",";
                      echo "'length':".$package_item['length'].",";
                      echo "'width':".$package_item['width'].",";
                      echo "'height':".$package_item['height'].",";
                      echo "'weight':".$package_item['weight'].",";
                      echo "'x1':".$package_item['x1'].",";
                      echo "'y1':".$package_item['y1'].",";
                      echo "'z1':".$package_item['z1']."";
                      echo "};";
                      echo "</script>";
                    ?>
              <?php endforeach; ?>

              </tbody>
            </table>
            <?php }; //CLOSING ELSE?>
          </div>

          <?php if (!empty($package)){ ?>
          <div id='canvas' style="margin:0 auto;display:table;">
            <canvas id='package_canvas' style="width:70vw;height:50vh;">
            </canvas>
          </div>
          <?php } ?>
        </div>


      </div>
    </div>
        <script>
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

                  camera.attachControl(canvas, false);

                  var light = new BABYLON.HemisphericLight("hemi", new BABYLON.Vector3(0, 1, 0), scene);

                  var mouseOverUnit = function(unit_mesh) {
                    if (unit_mesh.meshUnderPointer !== null) {
                        // $('tr.')
                        unit_mesh.meshUnderPointer.renderOutline = true;  
                        unit_mesh.meshUnderPointer.outlineWidth = 0.1;
                    }
                  }
                  
                  var mouseOutUnit = function(unit_mesh) {
                    if (unit_mesh.source !== null) {
                        unit_mesh.source.renderOutline = false; 
                        unit_mesh.source.outlineWidth = 0.1;
                    }
                  }

                  // var container = BABYLON.Mesh.CreateBox("Container", 6, scene);
                  // container.material = material;
                  // var material = new BABYLON.StandardMaterial('wireframe', scene);
                  // material.wireframe = true;

                  // //x , y, z = width, depth, height
                  // // console.log(lBox);
                  var container = BABYLON.Mesh.CreatePlane("ground", 0, scene);
                  container.rotation.x = Math.PI / 2;
                  container.scaling.x = 6;
                  container.scaling.y = 2.4
                  // var box1 = BABYLON.MeshBuilder.CreateBox("box1",  {width: .3 ,height: .3,depth:.3}, scene);
                  // box1.position = new BABYLON.Vector3(3-.15, 0+.15, 1.2-.15);
                  // var box2 = BABYLON.MeshBuilder.CreateBox("box2",  {width: .3 ,height: .3,depth:.3}, scene);
                  // box2.position = new BABYLON.Vector3(3-.15, 0+.15+.3, 1.2-.15);
                  // var box3 = BABYLON.MeshBuilder.CreateBox("box3",  {width: .3 ,height: .3,depth:.3}, scene);
                  // box3.position = new BABYLON.Vector3(3-.15, 0+.15+.6, 1.2-.15);
                  // var box4 = BABYLON.MeshBuilder.CreateBox("box4",  {width: .3 ,height: .2,depth:.2}, scene);
                  // box4.position = new BABYLON.Vector3(3-.15, 0.1+.9, 1.2-.1);
                  // var box5 = BABYLON.MeshBuilder.CreateBox("box5",  {width: .3 ,height: .1,depth:.3}, scene);
                  // box5.position = new BABYLON.Vector3(3-.15, .05, 1.2-.15-0.3);
                  var action_mouse_over = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOverTrigger, mouseOverUnit);
                  var action_mouse_out = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOutTrigger, mouseOutUnit);

                  var box = []
                  for (var i = 1; i <= Object.keys(dBox).length; i++) {
                      box[i-1] = BABYLON.MeshBuilder.CreateBox("box"+i,  {width: dBox[i].length ,height: dBox[i].height,depth:dBox[i].width}, scene);
                      box[i-1].position = new BABYLON.Vector3(3-((dBox[i].length/2)+dBox[i].x1),(dBox[i].height/2)+dBox[i].z1,1.2-((dBox[i].width/2)+dBox[i].y1));
                      box[i-1].actionManager = new BABYLON.ActionManager(scene);  
                      box[i-1].actionManager.registerAction(action_mouse_over);
                      box[i-1].actionManager.registerAction(action_mouse_out);
                  }

                  // box1.actionManager = new BABYLON.ActionManager(scene);  
                  // box1.actionManager.registerAction(action);
                  // box1.actionManager.registerAction(action2);

                  // box2.actionManager = new BABYLON.ActionManager(scene); 
                  // box2.actionManager.registerAction(action);
                  // box2.actionManager.registerAction(action2);

                  // box3.actionManager = new BABYLON.ActionManager(scene); 
                  // box3.actionManager.registerAction(action);
                  // box3.actionManager.registerAction(action2);

                  // box4.actionManager = new BABYLON.ActionManager(scene); 
                  // box4.actionManager.registerAction(action);
                  // box4.actionManager.registerAction(action2);

                  // box5.actionManager = new BABYLON.ActionManager(scene); 
                  // box5.actionManager.registerAction(action);
                  // box5.actionManager.registerAction(action2);
                  // //Moving boxes on the x axis
                  // box1.position.x = -20;
                  // box2.position.x = -10;
                  // box3.position.x = 0;
                  // box4.position.x = 15;
                  // box5.position.x = 30;
                  // box6.position.x = 45;

                  // //Rotate box around the x axis
                  // box1.rotation.x = Math.PI / 6;

                  // //Rotate box around the y axis
                  // box2.rotation.y = Math.PI / 3;

                  // //Scaling on the x axis
                  // box4.scaling.x = 2;

                  // //Scaling on the y axis
                  // box5.scaling.y = 2;

                  // //Scaling on the z axis
                  // box6.scaling.z = 2;

                  // //Moving box7 relatively to box1
                  // box7.parent = box1;
                  // box7.position.z = -10;

                  return scene;
              }

              var scene = createScene();
              engine.runRenderLoop(function(){
                  scene.render();
              });

          });
          
        </script>
