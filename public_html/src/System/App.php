<?php

namespace App\System;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Router;

class App
{
    private $request;
    private $router;
    private $routes;
    private $requestContext;
    private $controller;
    private $arguments;
    private $basePath;

    public static $instance = null;

    public static function getInstance($basepath = null)
    {
        if (static::$instance === null) {
            static::$instance = new static($basepath);
        }
        return static::$instance;
    }

    private function __construct($basepath = null)
    {
        $this->basePath = $basepath;
        $this->setRequest();
        $this->setRequestContext();
        $this->setRouter();
        $this->routes = $this->router->getRouteCollection();
    }

    private function setRequest()
    {
        $this->request = Request::createFromGlobals();
    }

    public function getRequest()
    {
        return $this->request;
    }

    private function setRequestContext()
    {
        $this->requestContext = new RequestContext();
        $this->requestContext->fromRequest($this->request);
    }

    private function setRouter()
    {
        $fileLocator = new FileLocator();
        $this->router = new Router(
            new YamlFileLoader($fileLocator),
            $this->basePath . '/config/routes.yaml',
            array('cache_dir' => BASEPATH . '/storage/cache')
        );
    }

    public function getController()
    {
        return (new ControllerResolver())->getController($this->request);
    }

    public function getArguments($controller)
    {
        return (new ArgumentResolver())->getArguments($this->request, $controller);
    }
    
    public function run()
    {
        $matcher = new UrlMatcher($this->routes, $this->requestContext);
        try {
            $this->request->attributes->add($matcher->match($this->request->getPathInfo()));
            $this->controller = $this->getController();
            $this->arguments = $this->getArguments($this->controller);
            $response = call_user_func_array($this->controller, $this->arguments);
        } catch (Exception $e) {
            exit('error');
        }

        $response->send();
    }
}