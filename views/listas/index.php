<?php

use yii\bootstrap4\Html;

$this->title = 'Listas';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="fondo p-2">
    <div class="col-12">
        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
        <div class="my-3 text-right">
            <?= Html::a('Mis listas', ['usuarios-listas/mis-listas'], ['class' => 'btn btn-azul']) ?>
            <?php if (!Yii::$app->user->isGuest) : ?>
                <?php if (Yii::$app->user->identity->soyAdmin) : ?>
                    <?= Html::a('Crear', ['create'], ['class' => 'btn btn-principal']) ?>
                <?php endif ?>
            <?php endif ?>
            <?php echo $this->render('_search', ['model' => $datos['searhModel']]); ?>
        </div>

        <?php if (!Yii::$app->user->isGuest) : ?>
        <?php endif ?>
        <?= $this->render('_listas', ['datos' => $datos]) ?>
    </div>
</div>
