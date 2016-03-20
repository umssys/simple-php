<?php

namespace core\system;

use core\system\globals\Server;
use core\system\globals\Session;
use core\system\globals\Request;
use core\system\globals\Post;
use core\system\globals\Get;
use core\system\globals\Files;
use core\system\globals\Env;
use core\system\globals\Cookie;

abstract class Compilador {

    protected $server;
    protected $session;
    protected $request;
    protected $post;
    protected $get;
    protected $files;
    protected $env;
    protected $cookie;

    function __construct($auth = false) {
        $auth ? true : die('Access Denied');
        $this->cargarGlobals();
    }
    
    private function cargarGlobals(){
        $this->server = new Server(true);
        $this->session = new Session(true);
        $this->request = new Request(true);
        $this->post = new Post(true);
        $this->get = new Get(true);
        $this->files = new Files(true);
        $this->env = new Env(true);
        $this->cookie = new Cookie(true);
    }

}
