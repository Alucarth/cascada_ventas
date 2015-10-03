<?php

class SaleController2 extends \BaseController {
	public function index(){
		return "index assssssssss";
	}
	public function store(){

		$sale = new Sale();
		$id = "1201";		
		$sale->client_id = $this->getUserId($id);
		// $sale->user_id = "";
		// $sale->branch_id = "";
		// $sale->account_id="";
		// $sale->invoice_status_id = "";
		// $sale->country_id"";
		// $sale->invoice_number="";
		// $sale->discount="";
		// $sale->po_number="";
		// $sale->invoice_date="";
		// $sale->due_date="";
		// $sale->terms = "";
		// $sale->public_notes = "";
		// $sale->id_deleted = "";
		// $sale->is_recurring = "";
		// $sale->frecuency_id = "";
		// $sale->start_date = "";
		// $sale->end_date = "";
		// $sale->last_sent_date = "";
		// $sale->recurring_invoice_id "";
		// $sale->branch = "";
		// $sale->address1 = "";
		// $sale->address2 = "";
		// $sale->city = "";
		// $sale->state = "";
		// $sale->work_phone = "";
		// $sale->nit = "";
		// $sale->name = "";
		// $sale->number_autho = "";
		// $sale->deadline = "";
		// $sale->key_dosage = "";
		// $sale->activity_pri = "";
		// $sale->activity_sec1 = "";
		// $sale->activity_sec2 = "";
		// $sale->law = "";
		// $sale->title = "";
		// $sale->subtitle = "";
		// $sale->control_code = "";
		// $sale->tax_name = "";
		// $sale->tax_rate = "";
		// $sale->subtotal = "";
		// $sale->amount = "";
		// $sale->fiscal = "";
		// $sale->balance = "";
		// $sale->ice = "";
		// $sale->qr = "";


		//$sale->save();

		print_r($sale);
		echo "saved";
		return 0;
		//$sale->name

	}

	private function getUserId($id)
	{
		return substr($id, -1);
	}

}