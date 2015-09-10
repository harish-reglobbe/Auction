<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 10/9/15
 * Time: 4:03 PM
 */

namespace auction\widgets;


class DetailView extends \yii\widgets\DetailView{

    public $template = '<a href="#" class="list-group-item">{label}<span class="pull-right text-muted small"><em>{value}</em></span></a>';

}