<?php
namespace App\Error;

use Cake\Error\ExceptionRenderer;
use App\Controller\AppController;

class MyExceptionRenderer extends ExceptionRenderer
{
    public function missingController($error)
    {
        return $this->controller->redirect('/login');
    }
}