<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
	    if( defined('WEB_AREA') &&  WEB_AREA=='admin')
		    redirect('privilege/auth/index');
	    else 
	        echo 'Welcome to iwide.cn.';
	}
	
	
}
