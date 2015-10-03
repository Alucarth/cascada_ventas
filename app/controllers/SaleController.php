<?php

class SaleController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		return 'hola ';
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{


		$respuesta = array();
    	//$input =  $this->setDataOffline();
    	$input = Request::get('ventas');
    	
    	$url = new Url();
	    $url->url = "www.nada.com";
	    $url->description = $input;	    
	    $url->save();

    	$input = json_decode($input);
    	
    	

    	foreach ($input as $key => $venta) {    		
    		$this->saveSale($venta);	    		
    		array_push($respuesta, $venta->invoice_number);  		
    	}
    	

    	
		return Response::json(array(
	        'error' => false,
	        'respuesta' => $$respuesta),
	        200
	    );

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	private function getUserId($id)
	{
		return substr($id, -1);
	}

    private function setDataOffline(){
	    	$data = "[
		   {
		    \"invoice_items\": [
		      {
		        \"boni\": \"3\",
		        \"desc\": \"2\",
		        \"qty\": \"41\",
		        \"id\": \"1\",
		        \"units\": \"6\",
		        \"cost\": \"10\",
		        \"ice\": \"1\",
		        \"cc\": \"10\",
		        \"product_key\": \"10\",
		        \"notes\": \"this is notes from the product\"
		      }
		    ],
		    \"fecha\": \"01-10-2015\",
		    \"name\": \"MOLLISACA\",
		    \"cod_control\": \"AB-07-3B-27\",
		    \"nit\": \"122038325\",
		    \"invoice_number\": \"9\",
		    \"client_id\": \"2\",
		    \"user_id\": \"1\",
		    \"ice\": \"1\",
		    \"deadline\": \"2017-10-10\",
		    \"account_id\": \"1\",
		    \"branch_id\": \"1\",
		    \"law\": \"this is a law\",
		    \"activity_pri\": \"actividad pri marai\",
		    \"activity_sec1\": \"actividad secundaria\",
		    \"address1\": \"direccion 1\",
		    \"address2\": \"direccion 2\",
		    \"number_autho\": \"321654687\",
		    \"postal_code\": \"0000\",
		    \"city\": \"la paz\",
		    \"state\": \"la paz\",
		    \"country_id\": \"1\",
		    \"key_dosage\": \"32134856513215\",
		    \"branch\": \"nombre branch\"
		  }
			]"; 
		$datos = json_decode($data);
		
		return $datos;
    }	

    public function saveSales(){    		   
	    // return Response::json(array(
	    //     'error' => false,
	    //     'urls' => $urls->toArray()),
	    //     200
	    // );


//     	$myfile = fopen("proofasdasdas.txt", "w") or die("Unable to open file!");
// 		$txt = "datos\n";
// 		fwrite($myfile, $txt);
// 		$txt = "datos\n";
// 		fwrite($myfile, $txt);
// 		fclose($myfile);
// return 2;
    	$respuesta = array();
    	//$input =  $this->setDataOffline();
    	$input = Request::get('ventas');
    	
    	$url = new Url();
	    $url->url = 'www.nada.com';
	    $url->description = Request::get($input);	    
	    $url->save();

    	$input = json_decode($input);
    	
    	

    	foreach ($input as $key => $venta) {    		
    		$this->saveSale($venta);	    		
    		array_push($respuesta, $venta->invoice_number);  		
    	}
    	

    	$datos = array('resultado ' => "0",'respuesta'=>$respuesta);		
    	print_r($datos);
		return Response::json($datos);
    }
    private function saveSale($venta)
    {

		$input = $venta;		
		$numero =(int) $input->invoice_number;
		$client_id = $input->client_id;		
		$user_id = $input->user_id;
    	$items = $input->invoice_items;    	
    	$amount = 0;
    	$subtotal=0;
    	$fiscal=0;
    	$icetotal=0;
    	$bonidesc =0;
    	foreach ($items as $item) 
    	{
    		
    		$product_id = $item->id;    		 
    		
    		$qty = (int) $item->qty;
    		$cost = $item->cost/$item->units;
    		$st = ($cost * $qty);
    		$subtotal = $subtotal + $st; 
    		$bd= ($item->boni*$cost) + $item->desc;
    		$bonidesc= $bonidesc +$bd;
    		$amount = $amount +$st-$bd;
    		
    		if($item->ice == 1)
    		{    		
    			//caluclo ice bruto 
    			$iceBruto = ($qty *($item->cc/1000)*$input->ice);
    			$iceNeto = (((int)$item->boni) *($item->cc/1000)*$input->ice);
    			$icetotal = $icetotal +($iceBruto-$iceNeto) ;    			
    		}    		
    	}
    	$fiscal = $amount -$bonidesc-$icetotal;

    	$balance= $amount;
    	
    	$invoice_dateCC = date("Ymd");
    	$invoice_date = date("Y-m-d");
    
		$invoice_date_limitCC = date("Y-m-d", strtotime($input->deadline));
		
	     $cod_control = $input->cod_control;
	     
	     // creando invoice
	     $sale = new Sale();
	     $sale->invoice_number=$input->invoice_number;
	     $sale->client_id=$client_id;
	     $sale->user_id=$user_id;
	     $sale->account_id = $input->account_id;
	     $sale->branch_id= $input->branch_id;
	     $sale->amount =number_format((float)$amount, 2, '.', '');	
	     $sale->subtotal = $subtotal;
	     $sale->fiscal =$fiscal;
	     $sale->law = $input->law;
	     $sale->balance=$balance;
	     $sale->control_code=$cod_control;
	     $sale->start_date =$invoice_date;
	     $sale->invoice_date=$invoice_date;

	     ///datos de branch
		 $sale->activity_pri=$input->activity_pri;
	     $sale->activity_sec1=$input->activity_sec1;	     	    
	     $sale->end_date=$invoice_date_limitCC;	     
	     $sale->address1=$input->address1;
	     $sale->address2=$input->address2;
	     $sale->number_autho=$input->number_autho;
	     $sale->work_phone=$input->postal_code;
 		 $sale->city=$input->city;
		 $sale->state=$input->state;	    
	     $sale->country_id= $input->country_id;
	     $sale->key_dosage = $input->key_dosage;
	     $sale->deadline = $input->deadline;

	     $sale->custom_value1 =$icetotal;
	     $sale->ice = $input->ice;
	     //cliente
	     $sale->nit=$input->nit;
	     $sale->name =$input->name;
	     
	     $sale->save();
	     
	     //$account = Auth::user()->account;
	     

			$ice = $sale->amount-$sale->fiscal;
			$desc = $sale->subtotal-$sale->amount;

			$amount = number_format($sale->amount, 2, '.', '');
			$fiscal = number_format($sale->fiscal, 2, '.', '');

			$icef = number_format($ice, 2, '.', '');
			$descf = number_format($desc, 2, '.', '');

			if($icef=="0.00"){
				$icef = 0;
			}
			if($descf=="0.00"){
				$descf = 0;
			}

			$sale->qr="";//=HTML::image_data('qr/' . $account->account_key .'_'. $input->invoice_number . '.jpg');

	     	$sale->save();
				$fecha =$input->fecha;
			$f = date("Y-m-d", strtotime($fecha));
	     	DB::table('sales')
            ->where('id', $sale->id)
            ->update(array('branch' => $input->branch,'invoice_date'=>$f));	     
	    foreach ($items as $item) 
    	{
    		    		    		    	
    		 $product_id = $item->id;	    		 
	    		$cost = $item->cost/$item->units;
	    		$line_total= ((int)$item->qty)*$cost;
    		
    		  $product = new Product();
    		  $product->sale_id = $sale->id; 
		      $product->product_id = $product_id;
		      $product->product_key = $item->product_key;
		      $product->notes = $item->notes;
		      $product->cost = $cost;
		      $product->boni = (int)$item->boni;
		      $product->desc =$item->desc;
		      $product->qty = (int)$item->qty;
		      $product->line_total=$line_total;
		      $product->tax_rate = 0;
		      $product->save();
		  
    	}           
    }

}
