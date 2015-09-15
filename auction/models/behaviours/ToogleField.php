<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 15/9/15
 * Time: 6:22 PM
 */

namespace auction\models\behaviours;


use auction\components\helpers\DatabaseHelper;
use yii\behaviors\AttributeBehavior;
use yii\helpers\ArrayHelper;

class ToggleField extends AttributeBehavior{

    protected function getValue($event)
    {
        if($this->owner->isNewRecord){
            return DatabaseHelper::IN_ACTIVE;
        }else{

            $oldAttribute = ArrayHelper::getValue($this->owner->oldAttributes , $this->value);
            $attribute = ArrayHelper::getValue($this->owner->attributes , $this->value);

        }

    }


}