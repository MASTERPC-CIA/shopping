<?php
/**
 * Example controller that uses the TwoCheckout_Lib library to pass sales to 2Checkout in any of the 4 supported parameter sets and validate the
 * response passed back to the approved URL.
 */
class TwoCheckout extends MX_Controller {
    
    function TwoCheckout(){
            parent::__construct();
            $this->load->library('common/twocheckout_lib');
    }
	
    function index(){
            //Setup Account Info, ('2Checkout Account Number', '2Checkout Secret Word', 'Demo Setting')
            $this->twocheckout_lib->set_acct_info('202502630', 'MTc4MGM0YjMtNmFhZS00YjdkLThlZmItYTVkODU5Y2VkYWMz', 'Y');
            $this->form();
    }
	
    function form(){
        $this->twocheckout_lib->button('Click to Pay!');
        $data['payment_form'] = $this->submit_form();
        //$this->load->view('cart_detail', $data);
        $this->load->view('twocheckout/form', $data); 

    }
    
    function submit_form(){
	    //Parameter Sets
		// Specify the order details using either the Pass-Through-Products parameter set, Third Party Cart parameter set, Authorize.net Parameter set or Plug and Play parameter set. An example utilization of each parameter set is provided in the examples below.
		//////////////////////////////PLEASE ONLY USE ONE PATAMETER SET////////////////////////////////////////
		/****Pass-Through-Product parameter set - To use, uncomment and specify field values . ****/
		//http://www.2checkout.com/blog/knowledge-base/merchants/tech-support/3rd-party-carts/parameter-sets/pass-through-product-parameter-set
		
		/****End of Parameter Set****/
		/****Third Party Cart parameter set - To use, uncomment and specify field values. ****/
		//http://www.2checkout.com/blog/knowledge-base/merchants/tech-support/3rd-party-carts/parameter-sets/does-your-system-have-its-own-parameters-if-so-what-are-they
		$this->twocheckout_lib->add_field('sid', $this->twocheckout_lib->sid);				//Required - 2Checkout account number
		$this->twocheckout_lib->add_field('cart_order_id', 'Test Cart ID 1');	//Required - Cart ID
		$this->twocheckout_lib->add_field('total', '9.99');				//Required - Sale Total
		//Lineitem Data (Each c_''_# is assigned a number starting with '0' and should increment)
		$this->twocheckout_lib->add_field('id_type', '1');					//Always '1'
		$this->twocheckout_lib->add_field('c_prod_0', '999,1');			//Product ID, Quantity
		$this->twocheckout_lib->add_field('c_name_0', 'Test Product');		//Product Name
		$this->twocheckout_lib->add_field('c_price_0', '9.99');			//Product Price
		$this->twocheckout_lib->add_field('c_description_0', 'Example Product Description');		//Product Description
		/****End of Parameter Set****/
		/****Authorize.net parameter set - To use, uncomment and specify field values. ****/
		//http://www.2checkout.com/blog/knowledge-base/merchants/tech-support/3rd-party-carts/parameter-sets/does-your-system-support-authorizenet-parameters-if-so-what-are-they
		
		/****End of Parameter Set****/
		/****Additional Supported Parameters - To use, uncomment and specify field values. ****/
		$this->twocheckout_lib->add_field('x_receipt_link_url', base_url('shopping_cart/twocheckout/success'));
		$this->twocheckout_lib->add_field('demo', $this->twocheckout_lib->demo);					//Either Y or N
		$this->twocheckout_lib->add_field('lang', 'es');					//Language - Chinese – zh, Danish – da, Dutch – nl, French – fr, German – gr, Greek – el, Italian – it, Japanese – jp, Norwegian – no, Portuguese – pt, 
												//Slovenian – sl, 	Spanish – es_ib, Spanish – es_la, Swedish – sv
	
		/****Customer Information - To use, uncomment and specify field values. ****/
		//Customer Billing Information
		$this->twocheckout_lib->add_field('first_name', 'Testing'); 			//First Name
		$this->twocheckout_lib->add_field('last_name', 'Tester');			//Last Name
		$this->twocheckout_lib->add_field('email', 'noreply@2co.com');		//Email Address 
		$this->twocheckout_lib->add_field('phone', '877-294-0273 FREE');		//Phone Number
		$this->twocheckout_lib->add_field('street_address', '1785 Obrien Rd');	//Street Address 1
		$this->twocheckout_lib->add_field('street_address2', 'Apt.1');		//Street Address 2
		$this->twocheckout_lib->add_field('city', 'Columbus');				//City
		$this->twocheckout_lib->add_field('state', 'OH');				//State
		$this->twocheckout_lib->add_field('zip', '43228');				//Postal Code
		$this->twocheckout_lib->add_field('country', 'USA');				//Country
		//Customer Shipping Information
		$this->twocheckout_lib->add_field('ship_name', 'Testing'); 				//Recipient Name
		$this->twocheckout_lib->add_field('ship_street_address', '1785 Obrien Rd');	//Recipient Street Address 1
		$this->twocheckout_lib->add_field('ship_street_address2', 'Apt.1');		//Recipient Street Address 2
		$this->twocheckout_lib->add_field('ship_city', 'Columbus');				//Recipient City
		$this->twocheckout_lib->add_field('ship_state', 'OH');					//Recipient State
		$this->twocheckout_lib->add_field('ship_zip', '43228');				//Recipient Postal Code
		$this->twocheckout_lib->add_field('ship_country', 'USA');				//Recipient Country
	    $this->twocheckout_lib->submit_form();
	}
	
	function success()
	{
		$this->twocheckout_lib->set_acct_info('202502630', 'MTc4MGM0YjMtNmFhZS00YjdkLThlZmItYTVkODU5Y2VkYWMz', 'Y');
		$data['response'] = $this->twocheckout_lib->validate_response();
		$status = $data['response']['status'];
		if ($status == 'pass') {
			$data['response'] = $this->twocheckout_lib->validate_response();
			$this->load->view('twocheckout/success', $data);
		} else {
			$this->load->view('twocheckout/fail', $data);
		}
	}
}



