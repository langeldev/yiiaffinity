<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = $usuario->login;;
$this->params['breadcrumbs'][] = ['label' => 'Buscar amigos', 'url' => ['usuarios/buscar-amigos']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fondo p-2">

<section class="perfil-usuario">
    <?= $this->render('/usuarios/_perfil', [
        'usuario' => $usuario
    ])?>
</section>
    <section class="p-3">
    <?php if ($valoraciones) : ?>
        <?php foreach ($valoraciones as $valoracion) : ?>
            <article class="row valoracion-container">
            <div class="col-3 img-valoracion">
                <?= Html::img($valoracion->producto->getImagen(), ['class' => 'img-fluid']) ?>
            </div>
                <h2><?= Html::a(Html::encode($valoracion->producto->titulo), ['/productos/ficha', 'id' => $valoracion->producto_id]) ?> <?= $valoracion->valoracion ?></h2>
            </article>
        <?php endforeach ?>
        <?php else: ?>
        <article class="p-5 critica-container text-center">
            <h2>Este usuario aún no ha valorado</h2>
        </article>
        <?php endif ?>
    </section>
    <div class="my-4 row col-12 justify-content-center">
        <?= LinkPager::widget([
            'pagination' => $pagination
        ]) ?>
    </div>
</div>
