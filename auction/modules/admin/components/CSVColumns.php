<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 20/8/15
 * Time: 2:11 PM
 */

namespace auction\modules\admin\components;

use yii\data\ArrayDataProvider;

class CSVColumns {

    public static function ProductCSVColumn()
    {
        $columns= [
            'Name',
            'Image',
            'Brand',
            'Category',
            "Price",
            'Condition',
            'Extra Condition'
        ];

        return new ArrayDataProvider([
            'allModels' => $columns,
            'pagination' => false
        ]);
    }
}