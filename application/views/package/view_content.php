
        <script type="text/javascript">
          var lBox = [];
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
                      echo "lBox.push({";
                      echo "'id':".$package_item['id'].",";
                      echo "'container':".$package_item['container'].",";
                      echo "'length':".$package_item['length'].",";
                      echo "'width':".$package_item['width'].",";
                      echo "'height':".$package_item['height'].",";
                      echo "'weight':".$package_item['weight'].",";
                      echo "'x1':".$package_item['x1'].",";
                      echo "'y1':".$package_item['y1'].",";
                      echo "'z1':".$package_item['z1']."";
                      echo "});";
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

                  var camera = new BABYLON.ArcRotateCamera("Camera", Math.PI, Math.PI / 8, 150, BABYLON.Vector3.Zero(), scene);

                  camera.attachControl(canvas, true);

                  var light = new BABYLON.HemisphericLight("hemi", new BABYLON.Vector3(0, 1, 0), scene);



                  var box1 = BABYLON.Mesh.CreateBox("Container", 0.3, scene);

                  console.log(lBox);
                  // var box2 = BABYLON.Mesh.CreateBox("Box2", 6.0, scene);
                  // var box3 = BABYLON.Mesh.CreateBox("Box3", 6.0, scene);
                  // var box4 = BABYLON.Mesh.CreateBox("Box4", 6.0, scene);
                  // var box5 = BABYLON.Mesh.CreateBox("Box5", 6.0, scene);
                  // var box6 = BABYLON.Mesh.CreateBox("Box6", 6.0, scene);
                  // var box7 = BABYLON.Mesh.CreateBox("Box7", 6.0, scene);

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
