<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 28/8/15
 * Time: 4:31 PM
 */

namespace auction\widgets\grid;


use auction\components\Auction;
use yii\grid\Column;
use dosamigos\datepicker\DatePicker;

class DatePickerColumn extends  Column{

    /**
     * @var string [
    'header' => 'Create Date',
    'value' => function($model){
    return Auction::$app->formatter->asDate($model->create_date);
    },
    'filter' => DatePicker::widget([
    'model' => $searchModel,
    'attribute' => 'create_date',
    'template' => '{addon}{input}',
    'clientOptions' => [
    'autoclose' => true,
    'format' => 'yyyy-mm-dd',
    'disableEntry'=>true,
    ],
    'options' => [
    'data-pjax' => false
    ]
    ])
    ],
     */

    public $header = 'Create date';

    public $dateColumn = 'create_date';


    protected function renderDataCellContent($model, $key, $index)
    {

        $dateColumn = $this->dateColumn;
        return Auction::$app->formatter->asDate($model->$dateColumn);

    }

    protected function renderFilterCellContent()
    {
        return DatePicker::widget([
            'model' => $this->grid->filterModel,
            'attribute' => $this->dateColumn,
            'template' => '{addon}{input}',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'disableEntry'=>true,
            ],
            'options' => [
                'data-pjax' => '0',
            ]
        ]);
    }
}