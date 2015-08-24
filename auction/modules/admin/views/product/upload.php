<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 20/8/15
 * Time: 1:06 PM
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\ListView;
?>
<h2>
    Upload a CSV File
</h2>
<h3>
    Your CSV File Must Contain Field in following Format
</h3>
<?= ListView::widget([
    'dataProvider' => $columns,
    'summary' => false,
    'itemView' => function($model){
        return $model;
    }
])
?>
<br>

<?php $form = ActiveForm::begin([
    'id' => 'crud-model-form',
    'options' => [
        'data-pjax' => true,
        'enctype' => 'multipart/form-data'
    ]
]);
?>

<?= $form->field($model, 'productCSV')->fileInput()->label(false) ?>

<div class="form-group">
    <?= Html::submitButton( 'Upload',['class' => 'btn btn-primary', 'disabled' => 'disabled' ,'id' => 'upload-product-csv']) ?>

    <?= Html::a( 'Download Sample Excel',['sample'],['class' => 'btn btn-danger' ,'id' => 'download-product-csv']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$this->registerJs('jQuery(document).on("change","#products-productcsv",function(){$("#upload-product-csv").attr("disabled",!1)});');
?>
