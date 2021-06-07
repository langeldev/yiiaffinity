<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = 'Buscar Amigos';
if (!Yii::$app->user->isGuest) {
   $this->params['breadcrumbs'][] = ['label' => 'Mis amigos', 'url' => ['/seguidores/mis-amigos']];
}
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="fondo p-2">
   <div class="col-12">

      <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
      <div class="my-3 text-right">
         <?= Html::a('Mis Amigos', ['/seguidores/mis-amigos'], ['class' => 'btn btn-azul']) ?>
         <div class="my-5 col-12 ml-auto">
            <?php $form = ActiveForm::begin([
               'action' => ['buscar-amigos'],
               'method' => 'get',
            ]); ?>
            <div class="my-5 col-12 row ml-auto px-0">
               <div class="col">

                  <?= $form->field($model, 'nombre')->textInput([
                     'placeholder' => 'Buscar por nombre o alias',
                     'class' => 'form-control form-style'
                  ])->label(false) ?>

               </div>
               <?= Html::submitButton('<span class="fas fa-search"></span>', ['class' => 'btn btn-azul']) ?>

            </div>
            <?php ActiveForm::end(); ?>
         </div>
      </div>

      <div class="row p-2 justify-content-center align-items-center">
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
            <h3>No se encontraron resultados</h3>
         <?php endif ?>
      </div>
   </div>

</div>
