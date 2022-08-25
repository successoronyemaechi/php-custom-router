<?php


namespace App;


class Router
{
    private $handlers;
    private $notFoundHandler;
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    public function get($path, $handler)
    {

        $this->addHandler(self::METHOD_GET, $path, $handler);

    }

    public function post($path, $handler){

        $this->addHandler(self::METHOD_POST, $path, $handler);

    }

    private function addHandler($method, $path, $handler){
        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler,
        ];
    }

    public function addNotFoundHandler($handler) {
        $this->notFoundHandler = $handler;
    }

    public function run(){
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        $method = $_SERVER['REQUEST_METHOD'];

        $callBack = null;
        foreach ($this->handlers as $handler){
            if ($handler['path'] === $requestPath && $method === $handler['method']){
                $callBack = $handler['handler'];
            }
        }

        if (is_string($callBack)){
            $parts = explode('::', $callBack);
            if (is_array($parts)){
                $className = array_shift($parts);
                $handler = new $className;

                $method = array_shift($parts);
                $callBack = [$handler, $method];
            }
        }

        if (!$callBack) {
            header("HTTP/1.0 404 Page Not Found");
            if (!empty($this->notFoundHandler)){
                $callBack = $this->notFoundHandler;
            }
        }

        call_user_func_array($callBack, [
            array_merge($_GET, $_POST)
        ]);
    }

}