<?php

use yii\jui\AutoComplete;
?>
<?php

echo AutoComplete::widget([
    'model' => $model,
    'attribute' => 'country',
    'clientOptions' => [
        'source' => ['USA', 'RUS'],
    ],
]);
?>