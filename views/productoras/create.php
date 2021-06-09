<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productoras */

$this->title = 'Dar de alta productora';
$this->params['breadcrumbs'][] = ['label' => 'Productoras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-md-2">
    <div class="col-10 col-md-8 m-auto">
        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
