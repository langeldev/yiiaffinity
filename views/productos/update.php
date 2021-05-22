<?php

use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productos */

$this->title = 'Modificar Producto';
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fondo p-2">

    <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tipos' => $tipos,
        'personas' => $personas,
        'productoras' => $productoras,
        'generos' => $generos, 
    ]) ?>

</div>
