<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;


$this->title = 'Modificar Usuario: ' . $model->login;

$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['usuarios/index']];
$this->params['breadcrumbs'][] = 'Modificar';
?>
<div class="fondo p-md-2">
    <div class="col-12 col-md-8 m-auto py-3">
        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
        <section class="generic-form my-5">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'generos' => $generos,
        'form' => $form,
    ]) ?>

    <div class="form-group text-right py-3">
        <?= Html::submitButton('Modificar', ['class' => 'btn btn-principal']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    </section>
    </div>

</div>
