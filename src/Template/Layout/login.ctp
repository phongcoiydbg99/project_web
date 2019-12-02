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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:500i|Roboto:300,400,700|Roboto+Mono" rel="stylesheet">
    <?= $this->Html->script('jquery-3.3.1.slim.min.js') ?>
    <?= $this->Html->script('bootstrap.min.js') ?>
    <?= $this->Html->script('popper.min.js') ?>
    <?= $this->Html->script('jquery.min.js') ?>
    <?= $this->Html->script('jquery-3.4.1.js') ?>
    <script type="text/javascript">
        var csrfToken = "<?= $this->request->getParam('_csrfToken') ?>"
        var baseUrl = "<?= $this->Url->build('/', true) ?>";
    </script>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar navbar-expand-md bg-light navbar-light">
      <?= $this->Html->link(
                '<i class="fa fa-home"></i> Home ',
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
        
      </div>  
    </nav>
    <!-- <?= $this->Flash->render() ?> -->
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
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
