<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 27/8/15
 * Time: 5:48 PM
 */

namespace auction\modules\api\components;

use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;


class RestController extends  \common\controllers\RestController{

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'data',
    ];


    public function behaviors(){

        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => $this->verbs(),
            ],
//            'authenticator' => [
//                'class' => RestAuth::className(),
//            ],
        ];

    }


}