<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Registrarse';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-md-2">
    <div class="col-12 col-md-8 m-auto py-3">
        <h1 class="text-center text-md-left ml-md-0 h1"><?= Html::encode($this->title) ?></h1>
        <section class="generic-form my-3">
            <?php $form = ActiveForm::begin(); ?>

            <?= $this->render('_form', [
                'model' => $model,
                'generos' => $generos,
                'form' => $form,

            ]) ?>


            <div class="form-group text-right py-3">
                <?= Html::submitButton('Registrarse', ['class' => 'btn btn-principal']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </section>
    </div>

</div>
