<?php

Class Home extends Controller{
    public function indexAction(){
        yield $this->render("home/header");
        yield $this->render("home/index");
        yield $this->render("home/footer");
    }
}