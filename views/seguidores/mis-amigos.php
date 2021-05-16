<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = 'Mis Amigos';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="fondo p-2">

   <?php $form = ActiveForm::begin([
      'action' => ['mis-amigos'],
      'method' => 'get',
   ]); ?>

   <?= $form->field($model, 'nombre')->textInput([
      'placeholder' => 'Buscar por nombre o alias',
   ])->label(false) ?>
   <div class="form-group">
      <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
   </div>
   <?= Html::a('Buscar Amigos', ['/usuarios/buscar-amigos'])?>
   <?php ActiveForm::end(); ?>
  
      <div class="row p-2 justify-content-center">
         <?php if (!empty($amigos['query'])) : ?>
            <?php foreach ($amigos['query'] as $amigo) : ?>
               <div class="col-5 col-md-3 m-2 border border-primary text-center px-0">
                  <?= Html::a(
                     '
                     <i class="fa fa-user amigo-icon py-4"></i>
                     <h4>' . Html::encode($amigo->login) . '</h4>
                     <h5 class="pb-4">' . Html::encode($amigo->nombre) . '</h5>
                  ',
                     ['valoraciones/usuarios', 'id' => $amigo->id],
                     ['class' => 'd-block']

                  );
                  ?>
               </div>
            <?php endforeach ?>
            <div class="my-4 row col-12 justify-content-center">


               <?= LinkPager::widget([
                  'pagination' => $amigos['pagination']
               ]) ?>
            </div>
         <?php else : ?>
            <h3>No tienes amigos <i class="far fa-sad-tear"></i></h3>
         <?php endif ?>
      </div>
</div>
