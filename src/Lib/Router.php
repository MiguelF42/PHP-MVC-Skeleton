<?php

namespace Application\Lib;

use Application\Router\Route;
use Application\Router\RouterException;

abstract class Router
{
    protected const LOCK = '';
    protected $url; // Contiendra l'URL sur laquelle on souhaite se rendre
    protected $routes = []; // Contiendra la liste des routes
    protected $namedRoutes = [];// Contiendra les routes nommées

    public function __construct($url)
    {
        $this->url = ltrim($url,static::LOCK);
    }

    public function get($path, $callable, $name = null)
    {
        return $this->add($path,$callable,$name,'GET');
    }

    public function post($path, $callable, $name = null)
    {
        return $this->add($path,$callable,$name,'POST');
    }

    private function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null)
        {
            $name = $callable;
        }
        if($name)
        {
            $this->namedRoutes[$name] = $route;
        }
        return $route; // On retourne la route pour "enchainer" les méthodes
    }

    public function url($name,$params = [])
    {
        if(!isset($this->naùedRoutes[$name]))
        {
            throw new RouterException('No such matches this name');
        }

        return $this->namedRoutes[$name]->getUrl($params);
    }

}