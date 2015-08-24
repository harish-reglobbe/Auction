<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 1/8/15
 * Time: 3:33 PM
 */

namespace auction\modules\admin\components;

use yii\web\HttpException;
use yii\base\Component;

class ReadCsv extends Component{


    private $_data=[];

    private $_file;

    private $_csvColumns;

    private $_noOfColumns;

    private $_noOfRows;

    public $chunkSize;

    private $_allowedMimeType=['application/csv'];


    function __construct($fileInstance){

        $this->_file=$fileInstance;
        $this->allData();

    }

    public function allData(){

        $csv = new ParseCSV();

        /*$csv->encoding('UTF-8');
        $csv->delimiter = ',';
        $csv->output_encoding='ASCII//TRANSLIT';
        $csv->parse($file->tempName);*/

        $csv->auto($this->_file->tempName);

        $this->_data=$csv->data;
        $this->_noOfRows=count($this->_data);

    }


    public function InsertFileRead(){

    }

    public function ReadDataInChucks(){

    }


    public function CheckMimeType(){

        if(!in_array($this->_file->type,$this->_allowedMimeType))
            throw new HttpException(400,'Not a Csv File');

    }

    public function getNoOfColumns(){
        if($this->_noOfColumns === null){
            $this->setNoOfColumns();
        }

        return $this->_noOfColumns;
    }

    public function setNoOfColumns(){
        $this->_noOfColumns=count($this->_data[$this->_noOfRows-1]);
    }

    public function getData(){
        if($this->_data === null){
            $this->setData();
        }

        return $this->_data;
    }

    public function setData(){
        return $this->_data;
    }

}