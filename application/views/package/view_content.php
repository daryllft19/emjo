
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Package</h1>
          <div class="table-responsive">
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
                      echo "<tr>";
                      echo "<td>".$package_item['id']."</td>";
                      echo "<td>".$package_item['container']."</td>";
                      echo "<td>".$package_item['length']."</td>";
                      echo "<td>".$package_item['width']."</td>";
                      echo "<td>".$package_item['height']."</td>";
                      echo "<td>".$package_item['weight']."</td>";
                      echo "<td>".$package_item['x1']."</td>";
                      echo "<td>".$package_item['y1']."</td>";
                      echo "<td>".$package_item['z1']."</td>";
                      echo "<td>".$package_item['orientation']."</td>";
                      echo "<td>".$package_item['arrival_date']."</td>";
                      if ($package_item['is_fragile']){
                        echo "<td>True</td>";
                      }else{
                        echo "<td>False</td>";
                      }
                      echo "</tr>";
                    ?>
              <?php endforeach; ?>

              </tbody>
            </table>
            <?php }; //CLOSING ELSE?>
          </div>
        </div>


      </div>
    </div>
