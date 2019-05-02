<?php


namespace App\Http;


class PageController extends AbstractController
{
    public function showAction($alias)
    {
        return $this->render('page', ['alias' => $alias]);
    }
}