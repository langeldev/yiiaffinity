<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Registrarse';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-form">

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'anyo_nac')->textInput() ?>

<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

<?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

<?= $form->field($model, 'genero')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'ciudad')->textInput(['maxlength' => true]) ?>

<div class="form-group">
    <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>

</div>
