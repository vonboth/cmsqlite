<?php namespace App\Controllers;

class Home extends Base
{
	public function index()
	{
		return view('welcome_message');
	}

	//--------------------------------------------------------------------

}
