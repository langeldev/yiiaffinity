<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;


$this->title = 'Modificar Usuario: ' . $model->login;

$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['usuarios/index']];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="fondo p-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'generos' => $generos,
        'form' => $form,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Modificar', ['class' => 'btn btn-principal']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    </div>
    
</div>
