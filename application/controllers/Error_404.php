<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Error_404 extends Web_controller{

	public function index()
	{
		echo '<!DOCTYPE html> <html lang="en"> <head> <meta charset="utf-8"> <title>404 Page Not Found</title> <link rel="shortcut icon" href="'.favicon().'"> <style type="text/css"> ::selection { background-color: #E13300; color: white; } ::-moz-selection { background-color: #E13300; color: white; } body {background-color: #fff; margin: 40px; font: 15px/20px normal Helvetica, Arial, sans-serif; color: #4F5155; } a {color: #003399; font-weight: normal; } h1 {color: #444; font-size: 27px; font-weight: normal; margin: 0 0 14px 0; padding: 29px; } code {font-family: Consolas, Monaco, Courier New, Courier, monospace; font-size: 12px; background-color: #f9f9f9; color: #002166; display: block; margin: 14px 0 14px 0; padding: 12px 10px 12px 10px; } #container {margin: 10px; text-align: center; } p {margin: 12px 15px 12px 15px; font-size: 18px; } </style> </head> <body> <div id="container"> <h1>404 Page Not Found</h1> <p>The page you requested was not found</p> </div> </body> </html>';
	}
}