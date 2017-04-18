
  
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Cluster    <a href='#' onclick='add_cluster();' class='btn btn-danger' role='button'>Add</a></h1>
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
                  <th>Priority</th>
                  <th></th>
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
                      echo "<td>";
                      // echo ($cluster_item['priority']==0)?'checked=checked':'1';
                      echo "<input type='radio' name='priority-".$cluster_item['id']."' data-attr='priority' data-value='0' ".(($cluster_item['priority']==0)?'checked=checked':'')." value=0 autocomplete='off'/>Stack<br/>";
                      echo "<input type='radio' name='priority-".$cluster_item['id']."' data-attr='priority' data-value='1' ".(($cluster_item['priority']==1)?'checked=checked':'')." value=1 autocomplete='off'/>Base";
                      echo "</td>";
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
<div id="dialog-add" title="Add Cluster">
  <div class='dialog-input-group'>
    <label for="dialog-add-name">Name:</label><br>
    <input id="dialog-add-name" data-attr='name' type="text" name="dialog-add-name" autocomplete="off">
  </div>

  <div class='dialog-input-group'>
    <label for="dialog-add-length">Length (cm):</label><br>
    <input id="dialog-add-length" data-attr='length' type="number" min=0 value=0 name="dialog-add-length" autocomplete="off">
  </div>

  <div class='dialog-input-group'>
    <label for="dialog-add-width">Width (cm):</label><br>
    <input id="dialog-add-width" data-attr='width' type="number" min=0 value=0 name="dialog-add-width" autocomplete="off">
  </div>

  <div class='dialog-input-group'>
    <label for="dialog-add-height">Height (cm):</label><br>
    <input id="dialog-add-height" data-attr='height' type="number" min=0 value=0 name="dialog-add-height" autocomplete="off">
  </div>

  <div class='dialog-input-group'>
    <label for="dialog-add-priority">Priority:</label><br>
    <input id="dialog-add-priority-stack" data-attr='length' type="radio" value=0 name="dialog-add-priority" autocomplete='off' checked/>Stack<br/>
    <input id="dialog-add-priority-base" data-attr='length' type="radio" value=1 name="dialog-add-priority" autocomplete='off'/>Base<br/>
  </div>

</div>

<div id="dialog-erase" title="Clear Package">
</div>

<div id="dialog-delete" title="Delete Cluster">
</div>

<div id="dialog-message" title="Content Modification">
</div>

    <script type="text/javascript">
     $(document).on('ready',function(){
        count();
        $('#dialog-add').hide();
     });

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
          $("#dialog-erase").html('Type the sentence in bold letters: "<strong>' + erase_code +'</strong>"<br/><input id="dialog-erase-input" type="text" autocomplete="off"/>');
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
        
        function add_cluster()
          {
                $( "#dialog-add" ).dialog({
                  modal: true,
                  buttons: {
                    Save: function(e) {
                      var params = {
                        'name' : $('#dialog-add-name').val(),
                        'length' : $('#dialog-add-length').val(),
                        'width' : $('#dialog-add-width').val(),
                        'height' : $('#dialog-add-height').val(),
                        'priority' : $('input[name=dialog-add-priority]:checked').val()
                      }
                        flag = false;
                        flag_str = 'INVALID INPUT:\n';
                        if(params['name'].trim() == '')
                        {
                          flag = true;
                          flag_str += 'Name is required.\n';
                        }
                        
                        if(params['length'] <= 0)
                        {
                          flag = true;
                          flag_str += 'Length should be positive non-zero.\n';
                        }

                        if(params['width'] <= 0)
                        {
                          flag = true;
                          flag_str += 'Width should be positive non-zero.\n';
                        }

                        if(params['height'] <= 0)
                        {
                          flag = true;
                          flag_str += 'Height should be positive non-zero.\n';
                        }

                        if(params['priority'] == undefined)
                        {
                          flag = true;
                          flag_str += 'Choose a priority.\n';
                        }

                        if(flag)
                          alert(flag_str);
                        else
                        {
                          $.post( "/cluster/add",{'params':params}, function(data){
                            console.log(params);
                            if(data.success == 1)
                            {
                              alert('Added cluster!');
                              window.location.reload();
                            }
                            else if(data.success == 0)
                              alert('Cluster exists!');
                            else
                              alert('Error adding cluster!');

                          });
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

        $('input[name^=priority]').on('change', function(){
          var node = $(this);
          params = {};
          params['id'] = node.parents('tr').data('cluster');
          params['attr'] = node.data('attr');
          params[params['attr']] = node.val();
          modify_cluster(node, params);
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
