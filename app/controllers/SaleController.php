<?php

class SaleController extends \BaseController {
	public function index(){
		return "index asdasdasd";
	}
	public function store(){
		$sale = Sale::createNew();
		$sale->cliet_id = "100";
		//$sale->name

	}
}