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
    <ul>
    <?php foreach ($listaProducto as $lista): ?>
      <li>
      <div>
        <h3>
                  <?= Html::a(Html::encode($lista->producto->titulo), ['/productos/ficha', 'id' => $lista->producto->id])?>
        </h3>
      </div>
      </li>
    <?php endforeach ?>
    </ul>
    </div>
</div>
