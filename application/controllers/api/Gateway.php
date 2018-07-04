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
class Gateway extends REST_Controller
{
    private $options;

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    function getNotifications_post()
    {
//        $url = $this->config->item("openbravo_api")."infinite/org.openbravo.service.json.jsonrest/wapi_pendingapprove";
        //https://livebuilds.openbravo.com/erp_pi_pgsql/org.openbravo.service.json.jsonrest/Country?_startRow=10&_endRow=50&_sortBy=name
//        $param ["_startRow"] = ($this->post("page") * $this->post("listPerPage"));
//        $param["_endRow"] = $param['_startRow'] + $this->post("listPerPage") - 1;
//        $param['_sortBy'] = $this->post("sortBy");
//        $param['_sortBy'] = $this->post("sortBy");
//        $param['creationDate>'] = $this->post("creationDate");
//        $param['isnotified'] = false;
        $this->options = array(
            'auth' => [$this->post("username"), $this->post("password")]
        );
//        $url = $this->config->item("openbravo_url") . "infinite/org.openbravo.service.json.jsonrest/wapi_pendingnotif?" . join_param($param);
        $creationDate = $this->post("creationDate");
        $url = $this->config->item("openbravo_url") . "infinite/org.openbravo.service.json.jsonrest/wapi_pendingnotif?_where=isnotified=false+and+active=true";
        if($creationDate){
            if(!empty($creationDate)){
                $url .= "+and+creationDate>".urlencode("'".$creationDate."'");
            }
        }

        $response = Requests::get($url, [], $this->options);
        if ($response->status_code == 200) {
            $res = json_decode($response->body, true);
            $ret = [];
            foreach ($res['response']['data'] as $val) {
                $ret [] = [
                    "_identifier" => $val["_identifier"],
                    "id" => $val['id'],
                    "documentid" => $val['documentid'],
                    "docTypeId" => $val['documentType'],
                    "docType" => $val['documentType$_identifier'],
                    "clientId" => $val['client'],
                    "client" => $val['client$_identifier'],
                    "organizationId" => $val['organization'],
                    "organization" => $val['organization$_identifier'],
                    "dueDate" => $val['dueDate'],
                    "desc" => $val['description'],
//                    "attribute" => json_decode($val['docattribute'],true),
                    "attribute" => $val['docattribute'],
                    "userId" => $val['userContact$_identifier'],
                    "user" => $val['userContact'],
                    "isNotified" => $val['isnotified'],
                    "creationDate" => $val['creationDate'],
                    "active" => $val['active']
                ];
            }
            $this->response(["rc" => 200, "data" => $ret, "url" => $url], 200);
        }
        $this->response(["rc" => 500], 200);
    }

    function getNotification_post()
    {
        $this->options = array(
            'auth' => [$this->post("username"), $this->post("password")]
        );
        $url = $this->config->item("openbravo_url") . "infinite/org.openbravo.service.json.jsonrest/wapi_pendingnotif?_where=id=".urlencode("'".$this->post("id")."'");

        $response = Requests::get($url, [], $this->options);
        if ($response->status_code == 200) {
            $res = json_decode($response->body, true);
            $ret = [];
            if($res['response']['totalRows']==1){
                $val = $res['response']['data'] [0];
                $ret = [
                    "_identifier" => $val["_identifier"],
                    "id" => $val['id'],
                    "documentid" => $val['documentid'],
                    "docTypeId" => $val['documentType'],
                    "docType" => $val['documentType$_identifier'],
                    "clientId" => $val['client'],
                    "client" => $val['client$_identifier'],
                    "organizationId" => $val['organization'],
                    "organization" => $val['organization$_identifier'],
                    "dueDate" => $val['dueDate'],
                    "desc" => $val['description'],
//                    "attribute" => json_decode($val['docattribute'],true),
                    "attribute" => $val['docattribute'],
                    "userId" => $val['userContact$_identifier'],
                    "user" => $val['userContact'],
                    "isNotified" => $val['isnotified'],
                    "creationDate" => $val['creationDate'],
                    "active" => $val['active']
                ];
            }

            $this->response(["rc" => 200, "data" => $ret], 200);
        }
        $this->response(["rc" => 500], 200);
    }

    function getApproval_post()
    {
        $this->options = array(
            'auth' => [$this->post("username"), $this->post("password")]
        );
//        $url = $this->config->item("openbravo_url") . "infinite/org.openbravo.service.json.jsonrest/wapi_pendingnotif?" . join_param($param);
        $creationDate = $this->post("creationDate");
        $url = $this->config->item("openbravo_url") . "infinite/org.openbravo.service.json.jsonrest/wapi_pendingapprove";
        if($creationDate){
            if(!empty($creationDate)){
                $url .= "?_where=creationDate>'".$creationDate."'";
            }
        }

        $response = Requests::get($url, [], $this->options);
        if ($response->status_code == 200) {
            $res = json_decode($response->body, true);
            $ret = [];
            foreach ($res['response']['data'] as $val) {
                $ret [] = [
                    "_identifier" => $val["_identifier"],
                    "id" => $val['id'],
                    "documentid" => $val['documentid'],
                    "docTypeId" => $val['documentType'],
                    "docType" => $val['documentType$_identifier'],
                    "clientId" => $val['client'],
                    "client" => $val['client$_identifier'],
                    "organizationId" => $val['organization'],
                    "organization" => $val['organization$_identifier'],
                    "dueDate" => $val['date'],
                    "desc" => $val['description'],
                    "attribute" => $val['documentAttribute'],
                    "userId" => $val['userContact'],
                    "user" => $val['userContact$_identifier'],
                    "isNotified" => $val['notified'],
                    "creationDate" => $val['creationDate']
                ];
            }
            $this->response(["rc" => 200, "data" => $ret], 200);
        }
        $this->response(["rc" => 500], 200);
    }

    function approveNotifications_post()
    {
        //http://app.meikarta.com/infinite/org.openbravo.service.json.jsonrest/wapi_pendingapprove
        $url = $this->config->item("openbravo_url") . "infinite/org.openbravo.service.json.jsonrest/wapi_pendingapprove";
//        echo json_encode($this->post());
        $data = [
            "data" => [[
                "_entityName" => "wapi_pendingapprove",
                "documentid" => $this->post("documentid"),
                "documentType" => $this->post("docTypeId"),
                'documentType$_identifier' => $this->post("docType"),
//                "client" => $this->post("clientId"),
//                "organization" => $this->post("organizationId"),
                "documentAttribute" => $this->post("attribute"),
                "userContact" => $this->post("userid"),

//                "active" => true,
                "description" =>$this->post("description"),
                "date" => $this->post("dueDate"),
//                "createdBy" => $this->post("userid"),
//                "updatedBy" => $this->post("userid"),
                "notified" => false,

            ]]
        ];
        $this->options = array(
            'auth' => [$this->post("username"), $this->post("password")]
        );
        $headers = [
            "Content-Type"=>"application/json"
        ];
        $response = Requests::post($url, $headers, json_encode($data),$this->options);
        if($response->status_code==200){
            $data = json_decode($response->body,true);
            if($data['response']['status']>=-1){
                $this->response(["rc"=>200,"msg"=>"Update success"],200);
            }
        }
        $this->response(["rc"=>500,"msg"=>"Update error","data"=>$data],200);
    }

    function updateNotifications_post()
    {
        //http://app.meikarta.com/infinite/org.openbravo.service.json.jsonrest/wapi_pendingapprove
        $url = $this->config->item("openbravo_url") . "infinite/org.openbravo.service.json.jsonrest/wapi_pendingnotif";
//        echo json_encode($this->post());
        $data = [
            "data" => [[

                "id" => $this->get("id"),
                '$ref' => "wapi_pendingnotif/".$this->get("id"),
                "_entityName" => "wapi_pendingnotif",
                "isnotified" => true

            ]]
        ];
//        echo json_encode($data);
        $this->options = array(
            'auth' => [$this->post("username"), $this->post("password")]
        );
        $headers = [
            "Content-Type"=>"application/json"
        ];
        $response = Requests::put($url, $headers, json_encode($data),$this->options);
        if($response->status_code==200){
            $data = json_decode($response->body,true);
            if($data['response']['status']>=-1){
                $this->response(["rc"=>200,"msg"=>"Update success"],200);
            }
        }
        $this->response(["rc"=>500,"msg"=>"Update error","data"=>$data],200);
    }


}
