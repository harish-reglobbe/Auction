<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 28/8/15
 * Time: 6:27 PM
 */

namespace auction\widgets\grid;


use yii\grid\Column;

class ImageColumn extends Column{

    public $header = 'Status';

    public $statusColumn = 'is_active';


    public function init(){

        parent::init();
    }

    protected function renderDataCellContent($model, $key, $index)
    {

        $statusColumn = $this->statusColumn;
        return DatabaseHelper::GetStatus($model->$statusColumn);

    }
}