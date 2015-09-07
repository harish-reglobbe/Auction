<?php
/**
 * Created by PhpStorm.
 * User: Double H
 * Date: 29-08-2015
 * Time: 11:00 PM
 */

namespace auction\components\helpers;


use yii\helpers\Html;

class BootstrapHelper
{

    /**
     * Panel Window Helper
     *
     *
     <div class="panel panel-info">
        <div class="panel-heading">
         </div>
        <div class="panel-body">
        </div>
    </div>
     */

    public static function PanelInfo($panelHeading, $panelBody,$panelFooter=false,$options=[]){

        echo Html::beginTag('div', $options);
        echo Html::tag('div' , $panelHeading , ['class' => 'panel-heading']);
        echo Html::tag('div' , $panelBody , ['class' => 'panel-body']);

        if($panelFooter){
            echo Html::tag('div',$panelFooter, ['class' => 'panel-footer']);
        }

        echo Html::endTag('div');

    }
}