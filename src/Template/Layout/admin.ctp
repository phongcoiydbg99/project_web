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
    <?= $this->Html->css('alertify.min.css') ?>
    <?= $this->Html->css('default.min.css') ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
    <?= $this->Html->script('jquery-3.3.1.slim.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('popper.min.js') ?>
    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('myfile.js') ?>
    <?= $this->Html->script('alertify.min.js') ?>
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
<body>
    <div>
        <nav class="navbar navbar-expand-md bg-light navbar-light shadow-sm">
          <?= $this->Html->link(
                    '<i class="fa fa-home"></i> Admin ',
                    '/users/index',
                    ['class' => 'navbar-brand', 'escape' => false]
                ) ?>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
                <!-- <li class="nav-item active">
                <?= $this->Html->link(
                    'About',
                    '/Users/Home',
                    ['class' => 'nav-link', 'escape' => false]
                ) ?>
                </li> --> 
            </ul>
           <!--  <ul class="navbar-nav">
                <li class="nav-item ">
                    <?= $this->Html->link(
                        '<i class="fas fa-power-off"></i> Logout ',
                        '/logout',
                        ['class' => 'nav-link', 'escape' => false]
                    ) ?>
                  
                </li>
            </ul> -->
            <ul class="navbar-nav ml-auto" >
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?= $current['first_name'].' '. $current['last_name']?> </span> 
                      <img class="img-profile rounded-circle" style="width: 35px; height: 35px"  src="http://www.clker.com/cliparts/n/l/p/q/K/L/blue-user-icon.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                      
                      <!-- <div class="dropdown-item" onclick="alertify.alert('Username: <?= $current['username'].'<br/>' ?>Họ và tên: <?=  $current['first_name'].' '. $current['last_name'].'<br/>' ?> Email: <?= $current['email'].'<br/>'?> Ngày sinh: <?= $current['date_birth'].'<br/>' ?> Lớp: <?= $current['class'].'<br/>' ?>')">

                        <img src="https://library.kissclipart.com/20180904/ese/kissclipart-user-icon-png-clipart-computer-icons-user-66fe7db07b02eb73.jpg" style="height="20" width="20">
                        Profile
                      </div> -->
                      <?php echo $this->Html->link('<img src="https://library.kissclipart.com/20180904/ese/kissclipart-user-icon-png-clipart-computer-icons-user-66fe7db07b02eb73.jpg" style="height="20" width="20""/> Profile', ['action'=>'profile'],array('escape'=>false, 'class'=>'dropdown-item'))?>

                      <div class="dropdown-divider"></div>

                      <?php echo $this->Html->link('<img src="https://cdn1.iconfinder.com/data/icons/materia-arrows-symbols-vol-3/24/018_128_arrow_exit_logout-512.png" style="height="20" width="20""/> Logout', '/logout',array('escape'=>false, 'class'=>'dropdown-item'))?>
                    </div>
                  </li>
                </ul>
          </div>  
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-2 mt-md-1 border border-top-0 border-bottom-0 border-left-0 ">
            <div class="list-group list-group-flush">
              <?= $this->Html->link('Sinh viên', ['controller'=>'users','action' => 'index'],['class' => 'list-group-item list-group-item-action', 'escape' => false]) ?>
              <?= $this->Html->link('Phòng thi', ['controller'=>'test_rooms','action' => 'index'],['class' => 'list-group-item list-group-item-action', 'escape' => false]) ?>
              <?= $this->Html->link('Môn thi', ['controller'=>'subjects','action' => 'index'],['class' => 'list-group-item list-group-item-action', 'escape' => false]) ?>
            </div>
        </div>
        <div class="col-lg-10">
            <?= $this->Flash->render() ?>
            <div class="container clearfix">
                <?= $this->fetch('content') ?>
            </div>  
        </div>
    </div>
    
    <footer>
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
