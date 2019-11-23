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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
    <?= $this->Html->script('jquery-3.3.1.slim.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('popper.min.js') ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div>
        <nav class="navbar navbar-expand-md bg-light navbar-light shadow-sm">
          <?= $this->Html->link(
                    '<i class="fa fa-home"></i> Admin ',
                    '/',
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
            <ul class="navbar-nav">
                <li class="nav-item ">
                    <?= $this->Html->link(
                        '<i class="fas fa-power-off"></i> Logout ',
                        '/logout',
                        ['class' => 'nav-link', 'escape' => false]
                    ) ?>
                  <!--<a class="nav-link" href="#"><i class="fa fa-home"></i><?= $this->fetch('title')?></a> -->
                </li>
            </ul>
          </div>  
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-2 mt-md-1 border border-top-0 border-bottom-0 border-left-0 ">
            <div class="list-group list-group-flush">
              <a href="#" class="list-group-item list-group-item-action">First item</a>
              <a href="#" class="list-group-item list-group-item-action">Second item</a>
              <a href="#" class="list-group-item list-group-item-action">Third item</a>
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
</body>
</html>
