<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('adminlte.css') ?>
    <?= $this->Html->css('adminlte.min.css') ?>
    <?= $this->Html->css('myfile.css') ?>
    <?= $this->Html->css('alertify.min.css') ?>
    <?= $this->Html->css('default.min.css') ?>
    <?= $this->Html->css('summernote-bs4.css') ?>
    <?= $this->Html->css('icheck-bootstrap.min.css') ?>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
    <?= $this->Html->script('jquery-3.3.1.slim.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('popper.min.js') ?>
    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('printThis.js') ?>
    <?= $this->Html->script('jquery-3.4.1.js') ?>
    <?= $this->Html->script('alertify.min.js') ?>
    <?= $this->Html->script('adminlte.min.js') ?>
    <?= $this->Html->script('myfile.js') ?>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript">
        var csrfToken = "<?= $this->request->getParam('_csrfToken') ?>"
        var baseUrl = "<?= $this->Url->build('/', true) ?>";
    </script>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
         <?= $this->Html->link(
                    '<i class="fa fa-home"></i> Home ',
                    '/',
                    ['class' => 'nav-link', 'escape' => false]
                ) ?>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto" >
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-user"></i>
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              
                  <!-- <div class="dropdown-item" onclick="alertify.alert('Username: <?= $current['username'].'<br/>' ?>Họ và tên: <?=  $current['first_name'].' '. $current['last_name'].'<br/>' ?> Email: <?= $current['email'].'<br/>'?> Ngày sinh: <?= $current['date_birth'].'<br/>' ?> Lớp: <?= $current['class'].'<br/>' ?>')">

                    <img src="https://library.kissclipart.com/20180904/ese/kissclipart-user-icon-png-clipart-computer-icons-user-66fe7db07b02eb73.jpg" style="height="20" width="20">
                    Profile
                  </div> -->
                <?php echo $this->Html->link('<i class="fas fa-id-badge"></i> Profile', ['controller'=>'users','action'=>'profile'],array('escape'=>false, 'class'=>'dropdown-item'))?>
                <div class="dropdown-divider"></div>
                <?php echo $this->Html->link('<i class="fas fa-sign-out-alt"></i> Logout', '/logout',array('escape'=>false, 'class'=>'dropdown-item'))?>
            </div>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php echo $this->Html->link('<span class="brand-text font-weight-light">'.$current['first_name'].' '. $current['last_name'].'</span>', ['controller'=>'users','action'=>'profile'],array('escape'=>false, 'class'=>'brand-link'))?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
                <?= $this->Html->link('<i class="nav-icon fas fa-th"></i> <p>Lịch thi</p>', ['controller'=>'subjects','action' => 'view_test'],['class' => 'nav-link', 'escape' => false]) ?>
          </li>
          <li class="nav-item">
            <?= $this->Html->link('<i class="far fa-circle nav-icon"></i><p>Đăng ký</p>', ['controller'=>'subjects','action' => 'index'],['class' => 'nav-link ', 'escape' => false]) ?>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <div class="content">
          <?= $this->Flash->render() ?>
        <div class="container clearfix ">
            <?= $this->fetch('content') ?>
        </div>
    <!-- /.content -->
    </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
</div>
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
<!-- Default to the left -->
    <strong>Project_web</strong> 
</footer>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 2000);
</script>
</body>
</html>