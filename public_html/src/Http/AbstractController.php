<?php


namespace App\Http;

use App\System\Controller\IController;
use Symfony\Component\HttpFoundation\Response;
use App\System\View\View;

abstract class AbstractController implements IController
{
    protected $view;

    public function render($path, $data = [])
    {
      return new Response($this->view->make($path, $data));
    }

    public function __construct()
    {
        $this->view = new View();
    }


}