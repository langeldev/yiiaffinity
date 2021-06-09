<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$js = <<<EOT

    $('#directores').select2({
        width:'100%'
    });
    
    $("#guionistas").select2({
        width:'100%',
    });
    
    $("#musica").select2({
        width:'100%',
    });

    $("#fotografia").select2({
        width:'100%',
    });
    
    $("#interpretes").select2({
        width:'100%',
    });
    
    $("#productoras").select2({
        width:'100%',
    });

    $("#generos").select2({
        width:'100%',
    });
EOT;
$this->registerJs($js);
?>

<div class="generic-form py-5 my-4">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-12 col-md-6">
            <?= $form->field($model, 'cartel')->fileInput() ?>

            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'titulo_original')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'anyo')->textInput(['class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'duracion')->textInput(['class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'tipo_id')->dropdownList($tipos, ['prompt' => 'Seleccione', 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'pais')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'sinopsis')->textarea(['rows' => 6, 'class' => 'form-control form-style']) ?>
        </div>

        <div class="col-12 col-md-6">
            <?= $form->field($model, 'directores')->dropdownList($personas, [
                'id' => 'directores',
                'name' => 'directores',
                'multiple' => 'multiple',

            ])->label('Directores', ['for' => 'directores']) ?>


            <?= $form->field($model, 'guion')->dropdownList($personas, [
                'class' => 'form-control form-style',
                'id' => 'guionistas',
                'name' => 'guionistas',
                'multiple' => 'multiple',
            ]) ?>


            <?= $form->field($model, 'musica')->dropdownList($personas, [
                'id' => 'musica',
                'name' => 'musica',
                'multiple' => 'multiple',
            ]) ?>


            <?= $form->field($model, 'fotografia')->dropdownList($personas, [
                'id' => 'fotografia',
                'name' => 'fotografia',
                'multiple' => 'multiple',
            ]) ?>

            <?= $form->field($model, 'interpretes')->dropdownList($personas, [
                'id' => 'interpretes',
                'name' => 'interpretes',
                'multiple' => 'multiple',
            ]) ?>


            <?= $form->field($model, 'productoras')->dropdownList($productoras, [
                'id' => 'productoras',
                'name' => 'productoras',
                'multiple' => 'multiple',
            ]) ?>


            <?= $form->field($model, 'generos')->dropdownList($generos, [
                'id' => 'generos',
                'name' => 'generos',
                'multiple' => 'multiple',
            ]) ?>
        </div>
        <div class="col-12 text-right">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-principal']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
