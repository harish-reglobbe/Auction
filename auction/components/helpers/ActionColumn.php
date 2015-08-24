<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 22-08-2015
 * Time: 11:50 AM
 */

namespace auction\components\helpers;

use yii\helpers\Html;
class ActionColumn extends \yii\grid\ActionColumn
{

    public $statusColumn='is_active';

    public function init(){

        $visibleColumn=$this->statusColumn;

        $this->buttons = [
            'update' => function($url,$model){
                return $this->updateButton($url,$model);
            },
            'view' => function($url,$model){
                return $this->viewButton($url,$model);
            },
            'delete' => function($url,$model) use ($visibleColumn){
                return $model->$visibleColumn ? $this->deleteButton($url,$model) : '';
            }
        ];
        parent::init();
    }

    private function viewButton($url,$model){

       return  Html::a('<span class="glyphicon glyphicon-eye-open"></span>', "#", [
           'class' => 'view-modal',
           'data-id' => $model->primaryKey,
       ]);

   }

    private function deleteButton($url,$model){
        return  Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
            'class' => 'delete-modal',
            'data-id' => $model->primaryKey,
        ]);
    }

    private function updateButton($url,$model){
        return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', "#", [
            'class' => 'update-modal',
            'data-id' => $model->primaryKey,
        ]);
    }
}