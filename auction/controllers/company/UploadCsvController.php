<?php

namespace auction\controllers\company;

use auction\models\Products;
use auction\modules\admin\components\CSVColumns;
use auction\modules\admin\components\ReadCsv;
use yii\web\UploadedFile;

class UploadCsvController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model= new Products();

        $columns= CSVColumns::ProductCSVColumn();

        if(isset($_POST['Products'])){
            $fileInstance=UploadedFile::getInstance($model, 'productCSV');
            $csvData= new ReadCsv($fileInstance);

            $model->uploadCsvFile($csvData->data);

        }

        return $this->render('index',[
            'model' => $model,
            'columns' => $columns
        ]);
    }

}
