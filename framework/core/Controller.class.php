<?php

class Controller{

    protected $loader;

    public function __construct()
    {
        $this->loader = new Loader();
    }

    public function redirect($url)
    {
        header("Location:$url");
        exit;
    }

    public function display($view = "index")
    {
        require_once CURR_VIEW_PATH . $view . ".php";
    }
}