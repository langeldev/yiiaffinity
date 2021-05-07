<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Dar de alta';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear';
?>
<div class="fondo p-md-2">
    <div class="col-12 col-md-8 m-auto py-3">
        <h1 class="h1"><?= Html::encode($this->title) ?></h1>
        <section class="usuarios-form my-3">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'generos' => $generos,
        'form' => $form,
    ]) ?>

    <div class="form-group text-right py-3">
        <?= Html::submitButton('Dar de alta', ['class' => 'btn btn-principal']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    </section>
    </div>

</div>
