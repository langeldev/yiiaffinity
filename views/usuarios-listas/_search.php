<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

?>

<div class="usuarios-listas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['mis-listas'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'lista.titulo')
        ->textInput(['placeholder' => 'Busqueda por título'])
        ->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
