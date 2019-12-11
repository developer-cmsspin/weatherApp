<?php

Class Home extends Controller{
    public function indexAction(){
        yield $this->render("layouts/header");
        yield $this->render("home/index");
        yield $this->render("layouts/footer");
    }

    public function historialAction(){
        yield $this->render("layouts/header");
        yield $this->render("home/historial");
        yield $this->render("layouts/footer");
    }
}