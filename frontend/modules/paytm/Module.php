<?php

namespace frontend\modules\paytm;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\paytm\controllers';

    //PAY TM_MERCHANT_KEY
    public $merchantKey;

    //PAY TM_MERCHANT_MID
    public $merchantId;

    //PAY TM_MERCHANT_WEBSITE
    public $merchantWebsite;

    //PAY TM Test DOMAIN
    public $paytmTestDomain='pguat.paytm.com';

    //PAY TM Secure DOMAIN
    public $payTmSecureDomain='secure.paytm.in';

    //Pay Tm refund Url
    private $_refundUrl;
    private $_statusQueryUrl;
    private $_processTransactionUrl;

    //Pay Tm Domain
    private $_payDomain;

    //Setter of Pay Tm Refund Url
    private function setRefundUrl(){
        $this->_refundUrl= 'https://'. $this->_payDomain.'/oltp/HANDLER_INTERNAL/REFUND';
    }
    //Getter of Pay Tm Refund URL
    public function getRefundUrl(){
        if($this->_refundUrl === null){
            $this->setRefundUrl();
        }

        return $this->_refundUrl;
    }


    //Setter of Status Query Url
    private function setStatusQueryUrl(){
        $this->_statusQueryUrl='https://'.$this->_payDomain.'/oltp/HANDLER_INTERNAL/TXNSTATUS';
    }
    //Getter of Status Query Url
    public function getStatusQueryUrl(){
        if($this->_statusQueryUrl === null){
            $this->setStatusQueryUrl();
        }

        return $this->_statusQueryUrl;
    }


    //Setter of Process Transaction Url
    private function setProcessTransactionUrl(){
        $this->_processTransactionUrl='https://'.$this->_payDomain.'/oltp/HANDLER_INTERNAL/TXNSTATUS';
    }
    //Getter of Status Query Url
    public function getProcessTransactionUrl(){
        if($this->__processTransactionUrl === null){
            $this->setProcessTransactionUrl();
        }

        return $this->_processTransactionUrl;
    }


    public function init()
    {
        $this->_payDomain=$this->payTmSecureDomain;

        if(YII_ENV === 'test'){
            $this->_payDomain=$this->paytmTestDomain;
        }

        parent::init();

        // custom initialization code goes here
    }
}
