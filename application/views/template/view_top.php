<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo site_url('index/')?>">Delivery Handler</a>
        </div>
        <a href="../auth/logout" class="btn btn-danger pull-right" role="button">Logout</a>
        <div class="navbar-text pull-right">
        Logged in as: <?php echo $this->tank_auth->get_username(); ?>
        </div>
      </div>
    </nav>
