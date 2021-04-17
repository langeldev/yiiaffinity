<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Valoraciones */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="valoraciones-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($miValoracion, 'valoracion')->dropdownList($lista, ['prompt' => '-'])->label(false)?>


    <?php ActiveForm::end(); ?>

</div>
