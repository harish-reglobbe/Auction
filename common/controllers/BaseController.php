<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 21-Jul-15
 * Time: 11:29 AM
 */

namespace common\controllers;


use common\components\IExpressionHandler;
use common\models\reglobe\Product;
use common\models\rgcal\ProductDetails;
use common\models\rgcal\ProductLine;
use yii\web\Controller;


class BaseController extends Controller implements IExpressionHandler {

    /**
     * @param $_expression_
     * @param array $_data_
     * @return mixed
     */
    public function evaluateExpression($_expression_,$_data_=array()){
        if(is_string($_expression_)){
            extract($_data_);
            return eval('return '.$_expression_.';');
        }else{
            $_data_[]=$this;
            return call_user_func_array($_expression_, $_data_);
        }
    }

    /**
     * @param $calculatorData
     * @param $product
     * @param $productLine
     * @return string
     * @throws \HttpException
     */
    protected function _generateCalculator($calculatorData, $productLineId, $product = null){
        $productId     = !empty($product->id) ? $product->id : null;

        $productData   = null;

        $productDetailsObj = new ProductDetails();

        $productLineData = ProductLine::find($productLineId)->one();

        if($productId != null){
            $productData = $productDetailsObj->findOne(['id' => $productId, 'is_active' => 1]);
            $productData['id']               = $productData->id ;
            $productData['image']            = \Yii::$app->s3helper->getProductDetails($productData->image);
            $productData['product_title']    = $productData->product_title;
            $productData['product_brand_id'] = $productData->product_brand_id;
        }else{
            $productData['id']               = '-1';
            $productData['image']            = \Yii::$app->s3helper->getProductCategory($productLineData->product_image);
            $productData['product_title']    = $productLineData->product_name;
            $productData['product_brand_id'] = 1;
        }

        if($productData === null){
            throw new \HttpException(404,'The requested page does not exist.');
        }

        return $this->render('product_calculator',
            [
                'product' => $productData,
                'calculatorData' => $calculatorData,
                'productLine' => $productLineData,
            ]
        );
    }

    /**
     * @param $id
     * @return null|static
     */
    protected function getProductLineData($id){
        $productLine = ProductLine::findOne(['id' => $id]);
        if($productLine===null)
            throw new \HttpException(404,'The requested page does not exist.');
        return $productLine;
    }
    /**
     * @param $id
     * @return null|static
     * @throws \HttpException
     */
    protected function loadProductDetails($id){
        $productDetail = ProductDetails::findOne(['id' => $id, "is_active" => 1]);
        if($productDetail===null)
            throw new \HttpException(404,'The requested page does not exist.');
        return $productDetail;
    }
}