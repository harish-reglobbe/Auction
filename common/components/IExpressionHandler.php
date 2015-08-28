<?php
/**
 * Created by PhpStorm.
 * User: Amit Sethi
 * Date: 16-07-2015
 * Time: 14:14
 */

namespace common\components;


interface IExpressionHandler {

    public function evaluateExpression($_expression_,$_data_=array());
}