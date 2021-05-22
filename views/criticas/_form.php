<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Criticas */

$this->title = Html::encode($producto->titulo);
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->producto->titulo), 'url' => ['productos/ficha', 'id' => $model->producto->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-2">

    <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
    <p><?= Html::encode($producto->mediaCriticas) ?></p>
    <p><?= Html::encode($producto->criticasTotales) ?> <i class="fa fa-user"></i></p>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'valoracion')->dropdownList($puntosValoracion, ['prompt' => '-'])
        ->label('Tu voto') ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'critica')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-principal']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
