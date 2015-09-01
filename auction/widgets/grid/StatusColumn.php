<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 28/8/15
 * Time: 4:32 PM
 */

namespace auction\widgets\grid;


use yii\grid\Column;
use yii\helpers\Html;
use auction\components\helpers\DatabaseHelper;


class StatusColumn extends Column{

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

    protected function renderFilterCellContent()
    {
        return Html::activeDropDownList($this->grid->filterModel,$this->statusColumn,DatabaseHelper::Status(),['class' => 'form-control','prompt' => '-------']);
    }

}