<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = 'Buscar Amigos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="fondo p-2">

   <?php $form = ActiveForm::begin([
      'action' => ['buscar-amigos'],
      'method' => 'get',
   ]); ?>

   <?= $form->field($model, 'nombre')->textInput([
      'placeholder' => 'Buscar por nombre o alias',
   ])->label(false) ?>
   <div class="form-group">
      <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
   </div>

   <?php ActiveForm::end(); ?>

   <div class="row p-2 justify-content-center">
      <?php if (!empty($amigos['query'])) : ?>
         <?php foreach ($amigos['query'] as $amigo) : ?>
            <div class="col-5 col-md-3 m-2 border border-primary text-center">
               <i class="fa fa-user p-2 amigo-icon"></i>
               <h4 class="p-2">
                  <?= Html::encode($amigo->login) ?>
               </h4>
               <h5 class="p-2">
                  <?= Html::encode($amigo->nombre) ?>
               </h5>
            </div>
         <?php endforeach ?>
         <div class="my-4 row col-12 justify-content-center">

            <?= LinkPager::widget([
               'pagination' => $amigos['pagination']
            ]) ?>
         </div>
      <?php else : ?>
         <h3>No se encontraron resultados</h3>
      <?php endif ?>
   </div>

</div>
