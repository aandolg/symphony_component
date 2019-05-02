<?php

namespace App\Http;


class IndexController extends AbstractController
{
    public function indexAction()
    {
        return $this->render('index', ['title' => 'Index Page']);
    }
}