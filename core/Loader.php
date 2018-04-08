<?php

class Loader{

    public function library($lib)
    {
        include LIB_PATH . "Loader.class.php";
    }

    public function helper($helper)
    {
        include HELPER_PATH . "Loader.class.php";
    }
}