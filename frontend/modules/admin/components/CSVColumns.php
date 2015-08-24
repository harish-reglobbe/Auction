<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 20/8/15
 * Time: 2:11 PM
 */

namespace frontend\modules\admin\components;

use yii\data\ArrayDataProvider;

class CSVColumns {

    public static function ProductCSVColumn($asArray=false)
    {
        $columns= [
            'Name',
            'Image',
            'Brand',
            'Category',
            'Lot',
            'Prize',
            'Condition',
            'Extra Condition'
        ];

        if($asArray){
            return $columns;
        }

        return new ArrayDataProvider([
            'allModels' => $columns,
            'pagination' => false
        ]);
    }
}