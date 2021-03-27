<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Dar de alta';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Crear';
?>
<div class="usuarios-create">

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
        <?= Html::submitButton('Dar de alta', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    </div>

</div>
