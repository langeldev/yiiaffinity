<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>


<?php $form = ActiveForm::begin([
    'action' => ['mis-listas'],
    'method' => 'get',
    ]); ?>
    <div class="usuarios-listas-search my-5 row col-12 ml-auto ">

<div class="col">
    <?= $form->field($model, 'lista.titulo')
        ->textInput([
            'placeholder' => 'Busqueda por título',
            'class' => 'form-control form-style'
            ])
        ->label(false) ?>

</div>
<?= Html::submitButton('<span class="fas fa-search"></span>', ['class' => 'btn btn-azul']) ?>

</div>
    <?php ActiveForm::end(); ?>
