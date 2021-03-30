<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductosSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="productos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'titulo') ?>

    <?= $form->field($model, 'titulo_original') ?>

    <?= $form->field($model, 'anyo') ?>

    <?= $form->field($model, 'duracion') ?>

    <?php // echo $form->field($model, 'tipo_id') ?>

    <?php // echo $form->field($model, 'pais') ?>

    <?php // echo $form->field($model, 'sinopsis') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
