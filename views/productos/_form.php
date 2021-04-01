<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="productos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'titulo_original')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anyo')->textInput() ?>

    <?= $form->field($model, 'duracion')->textInput() ?>

    <?= $form->field($model, 'tipo_id')->dropdownList($tipos) ?>

    <?= $form->field($model, 'pais')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sinopsis')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'directors')->dropdownList($directores) ?>

    <?= $form->field($model, 'guions')->dropdownList($guionistas) ?>

    <?= $form->field($model, 'musicas')->dropdownList($musica) ?>

    <?= $form->field($model, 'fotografias')->dropdownList($fotografia) ?>

    <?= $form->field($model, 'interpretes')->dropdownList($reparto) ?>

    <?= $form->field($model, 'productoras')->dropdownList($productoras) ?>

    <?= $form->field($model, 'generos')->dropdownList($generos) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
