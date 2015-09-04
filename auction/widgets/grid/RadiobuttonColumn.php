<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 3/9/15
 * Time: 10:10 AM
 */

namespace auction\widgets\grid;


use yii\grid\Column;
use yii\helpers\Html;

class RadiobuttonColumn extends Column{

    public $name = 'radio-box-column';

    public $header = 'Select An Item';

    /**
     *
     * render a radio button in Grid View
     * @param mixed $model
     * @param mixed $key
     * @param int $index
     * @return radio button
     */
    protected function renderDataCellContent($model, $key, $index)
    {

        return Html::radio($this->name,false,['value' => $model->primaryKey]);

    }
}