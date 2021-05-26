<?php 

namespace App\Router;

class Route {
    
    /**
     * route the items of the route exists
     *
     * @var array string[]
     */
    private $route;

    public function __construct(array $route)
    {
        $this->route = $route;
    }

        
    /**
     * map the URL  
     *
     * @param  string $uri
     * @param  string $viewPath
     * @return void
     */
    public  function map(string $uri, string $viewPath) : void 
    {
        if(in_array($uri,array_keys($this->route))){
            require $viewPath . $this->route[$uri];
        }else{
            header("HTTP/1.0 404 Not Found");
            http_response_code(404);
            require $viewPath . '/404.php';
        }
        
    }
}