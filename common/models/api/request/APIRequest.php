<?php
/**
 * Created by PhpStorm.
 * User: XPS
 * Date: 6/1/2015
 * Time: 6:09 PM
 */


namespace common\models\api\request;

use Yii;
use yii\base\Model;

abstract class APIRequest extends Model {

    public abstract function loadFromRequest();//return request data in required format

}