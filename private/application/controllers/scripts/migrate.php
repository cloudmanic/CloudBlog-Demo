<?php if(! isset($_SERVER['iscli'])) exit('No direct script access allowed');
class Migrate extends Controller {
	function Migrate() {
		parent::Controller();
	}
	
	//
	// Test.
	//
	function test()
	{
		echo "Woot";
	}
}
?>