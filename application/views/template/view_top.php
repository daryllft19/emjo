<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo site_url('index/')?>">Delivery Handler</a>
        </div>
        <?php
        //IF LOGGED IN
        if ($this->tank_auth->get_username())
        {

        ?>
          <a href="<?php echo site_url('auth/logout?redirect='.$_SERVER["REQUEST_URI"])?>" class="btn btn-danger pull-right" role="button">Logout</a>
          <div class="navbar-text pull-right">
          Logged in as: <?php echo $this->tank_auth->get_username(); ?>
          </div>
        <?php
        
        //IF LOGGED OUT OF ADMIN
        }else{
          
        ?>
          <a id="login-btn" href="#" class="btn btn-danger pull-right" role="button">Login</a>
        <?php
        }
        ?>
      </div>
    </nav>

    <div id="dialog-form" title="Admin Authentication">
     
      <form>
        <fieldset>
          <label for="password">Password:</label>
          <input type="password" name="password" id="password" value="" class="text ui-widget-content ui-corner-all">
     
          <!-- Allow form submission with keyboard without duplicating the dialog button -->
          <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
      </form>
    </div>

    <script type="text/javascript">
          // <a id="login-btn" href="<?php echo site_url('auth/login?redirect='.$_SERVER["REQUEST_URI"])?>" class="btn btn-danger pull-right" role="button">Login</a>

      function login()
      {
        $.post("/AuthHandler/login", {'password':$('#password').val()}, function(data) {
            alert(data);
        });
      }

      $(document).ready(function(){
        var form;

        dialog = $( "#dialog-form" ).dialog({
          autoOpen: false,
          height: 150,
          width: 350,
          modal: true,
          buttons: {
            "Login as Admin": login,
            Cancel: function() {
              dialog.dialog( "close" );
            }
          },
          close: function() {
            form[0].reset();
            $('password').removeClass( "ui-state-error" );
          }
        });

        form = dialog.find( "form" ).on( "submit", function( event ) {
            event.preventDefault();
          });

        $( "#login-btn" ).button().on( "click", function() {
          dialog.dialog( "open" );
        });
      });




    </script>