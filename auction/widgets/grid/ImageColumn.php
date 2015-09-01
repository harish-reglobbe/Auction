<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 28/8/15
 * Time: 6:27 PM
 */

namespace auction\widgets\grid;


use auction\components\Auction;
use yii\helpers\Html;

class ImageColumn extends StatusColumn{

    public $header = 'Thumb Image';

    public $statusColumn = 'image';

    public $directory;


    public function init(){
        $this->directory = Auction::$app->request->baseUrl.'/uploads/brands/thumbs/';;
        parent::init();
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        return Html::img($this->directory.$model->image);
    }

    protected function renderFilterCellContent()
    {
        return '';
    }
}