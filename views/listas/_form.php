<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosListas */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="generic-form py-5 my-5">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlenght' => true, 'class' => 'form-control form-style']) ?>

    <div class="form-group text-right mt-5">
        <?= Html::submitButton($model->isNewRecord ? 'Crear': 'Modificar', ['class' => 'btn btn-principal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
