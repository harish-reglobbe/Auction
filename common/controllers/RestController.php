<?php
/**
 * Created by PhpStorm.
 * User: Amit Sethi
 * Date: 24-06-2015
 * Time: 11:15
 */

namespace common\controllers;


use common\components\IExpressionHandler;
use common\models\api\response\APIResponse;
use yii\rest\Controller;

class RestController extends Controller implements IExpressionHandler{

    public $serializer = [
        'class' => 'common\components\CustomSerializer',
        'collectionEnvelope' => 'data',
    ];

    private $_startTime = false;
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR = -1;
    //------------------------------------------------------------------------------------------------------------------
    public function init(){
        $this->_startTime = microtime(true);
        parent::init();
    }
    //------------------------------------------------------------------------------------------------------------------
    public function sendResponse(APIResponse $response,$validate= true){
        if($response == null || ($validate && !$response->validate())){
            return $this->sendError($response);
        }
        if($this->_startTime){
            $response->_time = (microtime(true)-$this->_startTime)*1000;
        }

        $response->setVersion(\Yii::$app->request->dataVersion);
        return $response;
    }
    //------------------------------------------------------------------------------------------------------------------
    protected function sendError(APIResponse $response){
        $_resp = \Yii::$app->getResponse();
        $_resp->setStatusCode(204);
        return $response->getErrorFields();
    }
    //------------------------------------------------------------------------------------------------------------------
    protected function sendResponseError($status = 200){
        $message  = $this->getStatusCodeMessage($status);
        return array("code" => $status, "message"=>$message);
    }
    //------------------------------------------------------------------------------------------------------------------
    protected function getStatusCodeMessage($status){
        $codes = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Invalid Credentials.',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            1104=>"Auth Failed",

        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
    //------------------------------------------------------------------------------------------------------------------
    public function evaluateExpression($_expression_,$_data_=array()){
        if(is_string($_expression_)){
            extract($_data_);
            return eval('return '.$_expression_.';');
        }else{
            $_data_[]=$this;
            return call_user_func_array($_expression_, $_data_);
        }
    }
}