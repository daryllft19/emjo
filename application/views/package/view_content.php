
        <script type="text/javascript">
          var dBox = [];
        </script>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Package</h1>
              <div class='input-group'>
                <label for="cluster-select">Cluster:</label>
                <div class='row'>
                  <div class='col-sm-6'>
                    <select class="form-control" id="cluster-select">
                      <option value='-1'>NONE</option>
                      <?php
                      foreach ($ret as $key => $value) {
                        echo "<option data-priority='".$value['priority']."' value='".$key."'>".$value['name']."</option>";
                      }
                      
                      ?>
                    </select>
                  </div>

                  <div class='col-sm-6'>
                    <?php
                      if($this->tank_auth->is_logged_in())
                      {
                    ?>
                    <a href='#' onclick='clear_package();' class='btn btn-danger' id='btn-clear-package' role='button'>Clear Packages</a>
                    <?php
                      }
                    ?>
                  </div>
                </div>
                <br>
                <div class='col-large-6'>
                  <big>Priority: <strong><span id='priority'>N/A</span></strong></big>
                  
                </div>
              </div>

          <div class="table-responsive" style='overflow: auto;max-height: 20em;'>
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Address</th>
                    <th>Length (cm)</th>
                    <th>Width (cm)</th>
                    <th>Height (cm)</th>
                    <th>Weight (kg)</th>
                    <th>Height Constraint(cm)</th>
                    <th>Weight Constraint(kg)</th>
                    <th>Timestamp (UTC)</th>
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

<div id="dialog-delete-package" title="Delete Package">
</div>

      </div>
    </div>
        <script>
        $('#cluster-select').ready(function(){
          if($('#cluster-select').val() == -1)
            $('#btn-clear-package').hide();

          <?php
          if (!empty($this->input->get('cluster')))
          {
          ?>

          var btn = $('#btn-clear-package');
          btn.hide();
          $('option[value=<?php echo $this->input->get('cluster');?>]').prop('selected', true).trigger('change');
            
          <?php
          }
          ?>

        }).on('change', function(){
          var btn = $('#btn-clear-package');
          if($(this).val() == -1)
          {
            btn.hide();
          }
          else
            btn.show();

        });
        function delete_package(id)
        {
          console.log(id)
          $( "#dialog-delete-package" ).html("Delete package?")
          $( "#dialog-delete-package" ).dialog({
                  modal: true,
                  buttons: {
                    Yes: function(e) {
                      var params = {
                        'id' : id,
                        'cluster' : $('tr[data-address='+id+']').data('cluster')
                      }
                      $( "#dialog-delete-package" ).html("Deleting package.Please wait...")
                      $('button').prop('disabled', true)
                      $.post('/package/delete',{'params':params}, function(data){
                        if(data.success == 1){
                          $( "#dialog-delete-package" ).html("Package deleted!")
                          window.location.reload();
                        }else{
                          $('button').prop('disabled', false);
                        }
                      });
                    },
                  No: function(){

                      $(this).dialog("close");                    
                  }
                  }
                });
        }

        function clear_package()
        {
          var cluster_node = $('#cluster-select');
          var erase_code = 'I will erase packages in '+cluster_node.find(':selected').html();
          $("#dialog-erase").html('Type the sentence in bold letters: "<strong>' + erase_code +'</strong>"<br/><input id="dialog-erase-input" type="text" autocomplete="off"/>');
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
                              alert((data.msg!=null)?data.msg:'Error!');
                          });
                      }else{
                        alert('Wrong confirmation!');
                        $(this).dialog("close");
                      }
                    }
                  }
                });
        }
        tz = new Date().getTimezoneOffset()/-60;
        if (tz != 0){
          header = $('#package-table').prev('thead').find('th:nth-child(7)').html().replace('UTC', ('UTC '+(tz>0?'+'+tz:tz)));
          $('#package-table').prev('thead').find('th:nth-child(7)').html(header);
        }

          var canvas = document.getElementById('package_canvas');
          var engine = new BABYLON.Engine(canvas, true);
          $('#cluster-select').on('change', function (e) {
              var optionSelected = $("option:selected", this);
              var valueSelected = this.value;

              var row = '';
              if(valueSelected==-1){
                
              }else{
                if(optionSelected.data('priority') == 0)
                  $('#priority').html('Stack');
                if(optionSelected.data('priority') == 1)
                  $('#priority').html('Base');
                $.get( "/package/",{'cluster_id':valueSelected}, function( data ) {

                    window.history.pushState({"html":$('body').html(),"pageTitle":data.pageTitle},"", 'package?cluster='+valueSelected);
                    // window.
                    var dBox = [];
                    var cluster = data['cluster']; 
                    maxL = 0;
                    maxW = 0;
                    maxH = 0;
                    for (key in data['packages']){
                      row += "<tr data-address="+data['packages'][key].id+" data-cluster="+valueSelected+">";
                      row += "<td><a href='#' onclick='delete_package("+data['packages'][key].id+");' class='btn btn-danger' id='btn-delete-package' role='button'>Delete Package</a></td>";
                      row += "<td data-value='" + data['packages'][key].serial_no+"'>" + data['packages'][key].serial_no + "</td>";
                      row += "<td data-value='" + data['packages'][key].address+"'>" + data['packages'][key]['address'].city + "</td>";
                      row += "<td data-value='" + data['packages'][key].length+"'>" + data['packages'][key].length + "</td>";
                      row += "<td data-value='" + data['packages'][key].width+"'>" + data['packages'][key].width + "</td>";
                      row += "<td data-value='" + data['packages'][key].height+"'>" + data['packages'][key].height + "</td>";
                      row += "<td data-value='" + data['packages'][key].weight+"'>" + data['packages'][key].weight + "</td>";
                      row += "<td data-value='" + data['packages'][key].height_constraint+"'>" + data['packages'][key].height_constraint + "</td>";
                      row += "<td data-value='" + data['packages'][key].weight_constraint+"'>" + data['packages'][key].weight_constraint + "</td>";
                      date = data['packages'][key].arrival_date;
                      client_date = new Date(date).toLocaleString();
                      row += "<td data-value='" + date+"'>" + client_date + "</td>";
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
                        serial_no: data['packages'][key].serial_no,
                        address: addr,
                        length: parseFloat(data['packages'][key]['length']),
                        width: parseFloat(data['packages'][key]['width']),
                        height: parseFloat(data['packages'][key]['height']),
                        weight: parseFloat(data['packages'][key]['weight']),
                        x1: parseFloat(data['packages'][key]['x1']),
                        y1: parseFloat(data['packages'][key]['y1']),
                        z1: parseFloat(data['packages'][key]['z1']),
                        orientation: data['packages'][key]['orientation']                 
                      });

                      if(data['packages'][key]['length'] > maxL)
                          maxL = data['packages'][key]['length'];
                      if(data['packages'][key]['width'] > maxW)
                          maxW = data['packages'][key]['width'];
                      if(data['packages'][key]['height'] > maxH)
                          maxH = data['packages'][key]['height'];
                    }
                    $('#package-table').html(row);
                    // engine.dispose();
                    draw_canvas(cluster.length, cluster.width, cluster.height, dBox, canvas, engine, box);
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
          var box = {}
          $('table').on('mouseover','tr',function(){
            address = $(this).data('address')
            // box[address].
          })
          
          var draw_canvas = function(cluster_length, cluster_width, cluster_height, dBox, canvas, engine, box){   


              var createScene = function () {
                  var scene = new BABYLON.Scene(engine);

                  var camera = new BABYLON.ArcRotateCamera("Camera", Math.PI, Math.PI / 8, 5, BABYLON.Vector3.Zero(), scene);

                  camera.attachControl(canvas, true);
                  var light = new BABYLON.HemisphericLight("hemi", new BABYLON.Vector3(0, 1, 0), scene);

                  var material = new BABYLON.StandardMaterial('wireframe', scene);
                  material.wireframe = true;
                  

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
                        id.prop('innerText',box.serial_no);
                        address.prop('innerText',box.address);
                        length.prop('innerText',box.length);
                        width.prop('innerText',box.width);
                        height.prop('innerText',box.height);
                        weight.prop('innerText',box.weight);
                        unit_mesh.source.material = material;
                        $('tr[data-address='+box.id+']').addClass('active');
                        // console.log(unit_mesh);
                        unit_mesh.meshUnderPointer.renderOutline = true;  
                        // unit_mesh.meshUnderPointer.outlineWidth = 0.1;
                    }
                  }

                  var hover_table = function(unit_mesh) {
                    // console.log(unit_mesh)
                  }

                  var mouseOutUnit = function(unit_mesh) {
                    if (unit_mesh.source !== null) {

                        id = $('#box-info-id');
                        address = $('#box-info-address');
                        length = $('#box-info-length');
                        width = $('#box-info-width');
                        height = $('#box-info-height');
                        weight = $('#box-info-weight');
                        // box = dBox[unit_mesh.source.name.replace('box', '')];
                        box = dBox[unit_mesh.source.name.replace('box', '')];
                        id.prop('innerText','N/A');
                        address.prop('innerText','N/A');
                        length.prop('innerText','N/A');
                        width.prop('innerText','N/A');
                        height.prop('innerText','N/A');
                        weight.prop('innerText','N/A');

                        $('tr[data-address='+box.id+']').removeClass('active');
                        // console.log(id);
                        unit_mesh.source.material = box.material;
                        // unit_mesh.source.material = box[id].material;
                        unit_mesh.source.renderOutline = false; 
                        // unit_mesh.source.outlineWidth = 0.1;
                    }
                  }

                  // var address = BABYLON.Mesh.CreateBox("address", 6, scene);

                  // //x , y, z = width, depth, height
                  // // console.log(lBox);
                  var base = BABYLON.Mesh.CreatePlane("ground", 0, scene);
                  var wall = BABYLON.Mesh.CreatePlane("wall", 0, scene);
                  var sidewall = BABYLON.Mesh.CreatePlane("sidewall", 0, scene);
                  // address.material = material;
                  wall.rotation.y = Math.PI / 2;
                  wall.scaling.x = cluster_width/100;
                  wall.scaling.y = cluster_height/100;
                  wall.position.y = cluster_height/200;
                  wall.position.x = cluster_length/200;

                  sidewall.rotation.z = Math.PI / 2;
                  sidewall.scaling.y = cluster_length/100;
                  sidewall.scaling.x = cluster_height/100;
                  sidewall.position.y = cluster_height/200;
                  sidewall.position.z = cluster_width/200;

                  base.rotation.x = Math.PI / 2;
                  // address.rotation.y = Math.PI / 2;
                  base.scaling.x = cluster_length/100;
                  base.scaling.y = cluster_width/100;

                  var action_mouse_over = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOverTrigger, mouseOverUnit);
                  var action_mouse_out = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnPointerOutTrigger, mouseOutUnit);
                  var action_hover_table = new BABYLON.ExecuteCodeAction(BABYLON.ActionManager.OnEveryFrameTrigger, hover_table);

                  // var box = {}
                  // for (var i = 1; i <= 4; i++) {
                  // for (var i = 1; i <= Object.keys(dBox).length; i++) {
                  var max_weight = Math.max.apply(Math,dBox.map(function(o){return o.weight;}));

                  if(dBox.length > 0){
                    dBox.forEach(function(b, i){
                            box[b.id] = BABYLON.MeshBuilder.CreateBox("box"+i,  {width: b.width/100 ,height: b.height/100,depth:b.length/100}, scene);
                          // console.log('created box in '+i +' | id:'+b.id);
                          // console.log('created box in '+i +' | id:'+b.id, box[i]);
                            var mat = new BABYLON.StandardMaterial("color", scene);
                            // mat.emissiveColor = new BABYLON.Color3((b.weight/500)*200, 150-(b.weight/500)*150, 50);
                            r = b.weight/max_weight;
                            g = 1-(b.weight/max_weight)

                            mat.diffuseColor = new BABYLON.Color3(r,g,0.4);
                            box[b.id].material = mat;
                            b['material'] = mat;

                            xcalibrate = (cluster_length/100)/2;
                            ycalibrate = (cluster_width/100)/2;
                            y = ((b.height/100)/2)+b.z1/100;

                            if(b.orientation == 'vertical')
                            {
                              x = xcalibrate-(((b.width/100)/2)+b.x1/100);
                              z = ycalibrate-(((b.length/100)/2)+b.y1/100);
                            }
                            else if(b.orientation == 'horizontal')
                            {
                              x = xcalibrate-(((b.length/100)/2)+b.x1/100);
                              z = ycalibrate-(((b.width/100)/2)+b.y1/100);
                              box[b.id].rotation.y  = Math.PI / 2;
                            }
                            box[b.id].position = new BABYLON.Vector3(x,y,z); 
                            
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
                  scene.actionManager = new BABYLON.ActionManager(scene);
                  // scene.actionManager.registerAction(action_hover_table)
                  return scene;
              }

              var scene = createScene();
              engine.runRenderLoop(function(){
                  scene.render();
              });

          };


        </script>
