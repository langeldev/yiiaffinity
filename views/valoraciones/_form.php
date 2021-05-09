<?php

use yii\bootstrap4\ActiveForm;

?>

<div class="valoraciones-form">

    <?php $form = ActiveForm::begin([
'successCssClass' => false
    ]); ?>


    <?= $form->field($miValoracion, 'valoracion')->dropdownList($lista, ['prompt' => '-',
    'class' => 'form-control valoracion-form'])->label(false)?>


    <?php ActiveForm::end(); ?>

</div>
