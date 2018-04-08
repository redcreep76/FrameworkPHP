<?php

class HomeController extends Controller
{
    public function index() {
        $this->display('home.index');
    }

    public function edit($id) {
        $this->display('home.edit', ['id' => $id]);
    }
}