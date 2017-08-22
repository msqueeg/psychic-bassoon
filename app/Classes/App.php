<?php
namespace Msqueeg\Classes;

class App {
	/**
	 * stores an instance of the Slim application
	 *
	 * @var \SLim\App
	 * 
	 */
	
	private $app;
	
	public function __construct() 
	{

		//instantiate the app
		$config = parse_ini_file( __DIR__.'/../settings.ini', true);
		$app = new \Slim\App(['settings' => $config]);

		//set up dependencies
		require __DIR__ . '/../dependencies.php';

		//register middleware
		require __DIR__ . '/../middleware.php';

		// Register routes
		require __DIR__ .'/../routes.php';

		$this->app = $app;

	}

	public function get()
	{
		return $this->app;
	}

}