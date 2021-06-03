<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = $usuario->login;;
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => 'Mis amigos', 'url' => ['/seguidores/mis-amigos']];
}
$this->params['breadcrumbs'][] = ['label' => 'Buscar amigos', 'url' => ['usuarios/buscar-amigos']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fondo p-2">
    <div class="col-12">


        <section class="perfil-usuario">
            <?= $this->render('/usuarios/_perfil', [
                'usuario' => $usuario
            ]) ?>
        </section>
        <ul class="nav-user col-12">
            <li>
                <?= Html::a('<i class="far fa-newspaper"></i> Críticas [' . count($usuario->criticas) . ']',  ['/criticas/usuarios', 'id' => $usuario->id]) ?>
            </li>
            <li>
                <?= Html::a('<i class="fas fa-star"></i> Valoraciones [' . count($usuario->valoraciones) . ']', '', ['class' => 'user-selected']) ?>
            </li>
            <li>
                <?= Html::a('<i class="fas fa-list"></i> Listas [' . $usuario->listasTotales . ']', ['/usuarios-listas/usuarios', 'id' => $usuario->id]) ?>
            </li>
        </ul>
        <section class="p-3 valoraciones-container">
            <?php if ($valoraciones) : ?>
                <?php foreach ($valoraciones as $valoracion) : ?>
                    <article class="row valoracion-container p-3">
                        <div class="col-3 col-md-2 img-valoracion">
                            <?= Html::img($valoracion->producto->getImagen(), ['class' => 'img-fluid']) ?>
                        </div>
                        <div class="col-7 col-md-8 p-2">
                            <h3 class="titulo-valoracion"><?= Html::a(Html::encode($valoracion->producto->titulo), ['/productos/ficha', 'id' => $valoracion->producto_id]) ?> </h3>
                           <h4 class="valoracion-anio">(<?= Html::encode($valoracion->producto->anyo) ?>)</h4>
                            <p class="row voto-media">
                                <span class="media">
                                    <?= Html::encode(number_format($valoracion->producto->media, 1, ",", "")) ?>
                                </span>
                                <span class="total">
                                    <?= Html::encode($valoracion->producto->votosTotales) ?> <i class="fa fa-user"></i>
                                </span>
                            </p>
           
                        
                        </div>
                        <div class="col-2 col-md-1 mr-md-1 contenedor-voto">
                            <h5 class="puntos-valoracion">
                                <?= $valoracion->valoracion ?>
                            </h5>
                        </div>
                    </article>
                <?php endforeach ?>
            <?php else : ?>
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
</div>
