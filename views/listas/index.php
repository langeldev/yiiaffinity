<?php

use yii\bootstrap4\Html;

$this->title = 'Listas';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="fondo p-2">
    
    <h1><?= Html::encode($this->title) ?></h1>
    <p class="text-right pr-3">
    <?= Html::a('Mis listas', ['usuarios-listas/mis-listas'])?>
    </p>
    <?php  echo $this->render('_search', ['model' => $datos['searhModel']]); ?>
    <?php if (!Yii::$app->user->isGuest):?>
    <?php endif ?>
    <?= $this->render('_listas', ['datos' => $datos]) ?>
</div>
