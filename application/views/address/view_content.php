
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Address</h1>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Cluster</th>
                  <th>City</th>
                  <th>Keywords</th>
                  <th>Serviceable</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($address as $address_item): ?>
                    <?php 
                      echo "<tr>";
                      echo "<td>".$address_item['id']."</td>";
                      echo "<td editable='number' value='".$address_item["cluster"]."'>".$address_item["cluster"]."</td>";
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
</script>
