
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Cluster</h1>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Length (cm)</th>
                  <th>Width (cm)</th>
                  <th>Height (cm)</th>
                  <th>Package Count</th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($cluster as $cluster_item): ?>
                    <?php 
                      echo "<tr data-cluster=".$cluster_item['id'].">";
                      echo "<td><a href='#' onclick='clear_package(".$cluster_item['id'].");' class='btn btn-danger' id='btn-clear-package' role='button'>Clear Packages</a></td>";
                      echo "<td contenteditable data-value='".$cluster_item['name']."'>".$cluster_item['name']."</td>";
                      echo "<td contenteditable data-value='".$cluster_item['length']."'>".$cluster_item['length']."</td>";
                      echo "<td contenteditable data-value='".$cluster_item['width']."'>".$cluster_item['width']."</td>";
                      echo "<td contenteditable data-value='".$cluster_item['height']."'>".$cluster_item['height']."</td>";
                      echo "<td><span class='cluster-package-count'>0</span></td>";
                      echo "</tr>";
                    ?>
              <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>


      </div>
    </div>
<div id="dialog-erase" title="Clear Package">
</div>
    <script type="text/javascript">
     $(document).on('ready',count);
     function count()
     {
      var spans = $('span[class="cluster-package-count"]');
        spans.each(function(i){
          var cluster_id = $(spans[i]).parents('tr').data('cluster');
          $.get('/cluster/count',{'cluster_id':cluster_id}, function(data){

            $(spans[i]).html(data.count);
          })
        });
     }
     setInterval(count, 5000);
      function clear_package(id)
        {
          var cluster_node = $('tr[data-cluster='+id+']').children('td:nth-child(2)');
          var erase_code = 'I will erase packages in '+cluster_node.html();
          $("#dialog-erase").html('Type the sentence in bold letters: "<strong>' + erase_code +'</strong>"<br/><input id="dialog-erase-input" type="text"/>');
          $( "#dialog-erase" ).dialog({
                  modal: true,
                  buttons: {
                    Erase: function(e) {
                      cluster = id
                      confirmation = $('#dialog-erase-input').val();
                      node = $(this);
                      if(confirmation == erase_code){
                      // console.log('adding ' + cluster +' '+province+' '+city+' '+barangay+' '+district+' '+area+' '+avenue+' '+street)
                          $.get( "/cluster/clear",{'cluster_id':cluster}, function(data){
                            if(data.success == 1)
                            {
                              alert('Cleared cluster of packages!');
                              node.dialog("close");
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
    </script>
