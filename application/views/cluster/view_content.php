
  
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
                      echo "<td><a href='#' onclick='delete_cluster(".$cluster_item['id'].");' class='btn btn-danger' id='btn-clear-package' role='button'>Delete</a></td>";
                      echo "<td contenteditable data-attr='name' data-value='".$cluster_item['name']."'>".$cluster_item['name']."</td>";
                      echo "<td contenteditable data-attr='length' data-value='".$cluster_item['length']."'>".$cluster_item['length']."</td>";
                      echo "<td contenteditable data-attr='width' data-value='".$cluster_item['width']."'>".$cluster_item['width']."</td>";
                      echo "<td contenteditable data-attr='height' data-value='".$cluster_item['height']."'>".$cluster_item['height']."</td>";
                      echo "<td><span class='cluster-package-count'>0</span></td>";
                      echo "<td><a href='#' onclick='clear_package(".$cluster_item['id'].");' class='btn btn-danger' id='btn-clear-package' role='button'>Clear Packages</a></td>";
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

<div id="dialog-delete" title="Delete Cluster">
</div>

<div id="dialog-message" title="Content Modification">
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
            clear_btn = $($(spans[i]).parents('tr').children('td:last-child').find('a')[0]);
            if(data.count <= 0 ){
              $($(spans[i])).parents('tr').find('td[contenteditable]').prop('contenteditable',true);
              clear_btn.addClass('disabled');
            }
            else{
              $($(spans[i])).parents('tr').find('td[contenteditable]').prop('contenteditable',false);
              clear_btn.removeClass('disabled')
            }
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
                              count();
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

      function delete_cluster(id)
        {
          packages = parseInt($('tr[data-cluster='+id+']').find('.cluster-package-count').html());
          if(packages > 0){
            alert('Cluster has packages!');
            return;
          }

          var cluster_node = $('tr[data-cluster='+id+']');
          var erase_code = 'I will delete cluster '+cluster_node.children('td:nth-child(2)').html();
          $("#dialog-delete").html('Type the sentence in bold letters: "<strong>' + erase_code +'</strong>"<br/><input id="dialog-delete-input" type="text"/>');
          $( "#dialog-delete" ).dialog({
                  modal: true,
                  buttons: {
                    Erase: function(e) {
                      cluster = id
                      confirmation = $('#dialog-delete-input').val();
                      node = $(this);
                      if(confirmation == erase_code){
                        $.get( "/cluster/delete",{'cluster_id':cluster}, function(data){
                            if(data.success == 1)
                            {
                              cluster_node.fadeOut(3000,function(){
                                $(this).remove();
                              });
                              alert('Cluster deleted!');
                              node.dialog("close");
                            }
                            else
                              alert('Cannot delete cluster!');
                          });
                      }else{
                        alert('Wrong confirmation!');
                        $(this).dialog("close");
                      }
                    }
                  }
                });
        }

        $('td[contenteditable]').on('mouseover',function(){
          var node = $(this);
          node.data('border', node.css('border'));
          if(node.prop('contenteditable') == 'true')
            node.css('border','1px solid rgb(30,144,255)');
        }).on('mouseout',function(){
          var node = $(this);
          node.css('border',node.data('border'));
        }).on('focus',function(){
          var node = $(this);
          var prev_content = node.html();
          node.data('prev', prev_content);
          node.keypress(function(e){
            var key = e.which;

            if(key == 13)
            {
              params = {};
              params['id'] = node.parent('tr').data('cluster');
              params['attr'] = node.data('attr');
              params[params['attr']] = node.html();
              params['old'] = prev_content;
              node.prop('contenteditable',false);
              modify_cluster(node,params);
              e.preventDefault();
              
            }
          });
        }).on('focusout',function(){
          var node = $(this);

          params = {};
          params['id'] = node.parent('tr').data('cluster');
          params['attr'] = node.data('attr');
          params[params['attr']] = node.html();
          params['old'] = node.data('prev');
          node.prop('contenteditable',false);
          if(node.data('prev') != node.html())
            modify_cluster(node,params);
          node.removeData('prev');
        });


        function modify_cluster(node, params)
        {
            var dialog_node = $( "#dialog-message" );
            dialog_node.html('<p>Saving changes...</p>');

            dialog_node.dialog({
            modal: true,
            buttons: {
                Ok: function(e) {
                  $( this ).dialog( "close" );
               }
              }
            }).ready(function(){
              $(this).focus();
            });

            var attr = params['attr']
            var prev_content = params['old']
            delete params['attr']
            delete params['old']
            $.post('/cluster/modify', {'params': params}, function(data){
              if(data.response == 1)
                dialog_node.html('<p>Successful...</p>');
              else{
                node.fadeOut('slow', function(){
                  node.html(prev_content);
                  node.fadeIn('slow');
                });
                
                dialog_node.html('<p>'+data.response.error+'</p>');
              }

            }).fail(function(response){
                node.fadeOut('slow', function(){
                  node.html(prev_content);
                  node.fadeIn('slow');
                });

                dialog_node.html('<p>Error in input!</p>');
            });
        }
    </script>
