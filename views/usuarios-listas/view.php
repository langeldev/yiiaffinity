<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;


$this->title = $model->lista->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Listas', 'url' => ['/usuarios-listas/mis-listas']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fondo p-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <div id="lista-productos">
    <ol>
    <?php foreach ($listaProducto as $lista): ?>
      <li>
      <div class="row">
        <h3 class="col-6">
                  <?= Html::a(Html::encode($lista->producto->titulo), ['/productos/ficha', 'id' => $lista->producto->id])?>
        </h3>
        <div class="col-4">
        <?php if (!Yii::$app->user->isGuest) : ?>
                        <?php if ($model->usuario_id === Yii::$app->user->id) : ?>
                                <?= Html::a('x', ['listas-productos/delete', 'id' => $lista->id], [
                                    'class' => 'btn btn-outline-danger border-0 rounded-0',
                                    'data' => [
                                        'confirm' => '¿Quiere eliminar "' . Html::encode($lista->producto->titulo) . '" de esta lista?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                  
                        <?php endif ?> 
                    <?php endif ?>
        </div>
      </div>
      </li>
    <?php endforeach ?>
    </ol>
    </div>
</div>
