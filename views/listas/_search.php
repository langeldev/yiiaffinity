<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ListasSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="listas-search my-5 row col-12 ml-auto">

        <div class="col">
            <?= $form->field($model, 'titulo')
                ->textInput([
                    'placeholder' => 'Busqueda por título',
                    'class' => 'form-style form-control'
                ])
                ->label(false) ?>
        </div>
        <?= Html::submitButton('<span class="fas fa-search"></span>', ['class' => 'btn btn-azul']) ?>
    </div>

    <?php ActiveForm::end(); ?>
