	<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <?php
              if ($this->tank_auth->is_logged_in()) {
              ?>
            <li><a href="<?php echo site_url('index/cluster')?>">Cluster</a></li>
            <li><a href="<?php echo site_url('index/address')?>">Address</a></li>
            <li><a href="<?php echo site_url('index/form')?>">Add Package</a></li>
            <li><a href="<?php echo site_url('index/analytics')?>">Analytics</a></li>
            <li><a href="<?php echo site_url('index/export')?>">Export</a></li>
            <?php
              }
            ?>
            <li>
              <a href="<?php echo site_url('index/package')?>">Package</a>
              <ul>
                <li><a href="<?php echo site_url('index/form')?>">Add Package</a></li>
                <li><a href="<?php echo site_url('index/package')?>">View Package</a></li>
              </ul>
            </li>
          </ul>
        </div>
        <div id='body'>