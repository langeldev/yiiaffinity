<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'YiiAffinity';
?>
<div class="fondo">
    <div class="col-12 row p-0 m-0">
        <aside class="d-none d-md-block col-md-2 nav-lateral p-0">
            <?php if (!Yii::$app->user->isGuest) : ?>
                <ul class="pl-3">
                    <li>
                        <?= Html::a('Editar Perfil', ['usuarios/editar-perfil']) ?>
                    </li>
                    <li>
                        <?= Html::a('Amigos', ['usuarios/buscar-amigos']) ?>
                    </li>
                    <li>
                        <?= Html::a('Listas', ['usuarios-listas/mis-listas']) ?>
                    </li>
                </ul>
            <?php endif ?>
        </aside>
        <section class="body-content col-12 col-md-10 my-0">

            <h2 class="text-center text-md-left ml-md-4 h2">Cartelera</h2>
            <div class="card-deck col-12 m-auto">
                <div class="row align-center">
                    <?php foreach ($productos as $producto) : ?>
                        <div class="col-6 col-lg-4 my-4">
                            <div class="card">
                                <img class="card-img-top cartel" src="#" alt="">
                                <div class="card-body">
                                    <h5 class="card-title titulo">
                                        <?= Html::a($producto->titulo, ['productos/ficha', 'id' => $producto->id]) ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>
    </div>
</div>
