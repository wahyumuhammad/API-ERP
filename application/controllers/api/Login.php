<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . 'libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

class Login extends REST_Controller
{

    private $client;
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function login_post()
    {
        $url = $this->config->item("openbravo_url")."infinite/ws/org.wirabumi.mobileinfra.validateUserAccount";
        $options = array(
            'auth' => [$this->post("username"), $this->post("password")]
        );
//        $response = Requests::get($url,['auth' => [$this->post("username"), $this->post("password")]]);
        $response = Requests::get($url,[],$options);
//        print_r($response);
        if($response->status_code==200){
            $res = trim($response->body);
            if(!empty($res)){
                if(strlen($res)==32)
                {
                    $this->response(["rc"=>200,"data"=>$response->body],200);
                }
            }
        }
        $this->response(["rc"=>500],200);
    }


}
