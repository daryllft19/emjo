
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Cluster</h1>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Length (m)</th>
                  <th>Width (m)</th>
                  <th>Height (m)</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($cluster as $cluster_item): ?>
                    <?php 
                      echo "<tr>";
                      echo "<td>".$cluster_item['id']."</td>";
                      echo "<td>".$cluster_item['name']."</td>";
                      echo "<td>".$cluster_item['length']."</td>";
                      echo "<td>".$cluster_item['width']."</td>";
                      echo "<td>".$cluster_item['height']."</td>";
                    ?>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>


      </div>
    </div>
