<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CriticasSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="criticas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'producto_id') ?>

    <?= $form->field($model, 'usuario_id') ?>

    <?= $form->field($model, 'valoracion') ?>

    <?= $form->field($model, 'titulo') ?>

    <?php // echo $form->field($model, 'critica') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
