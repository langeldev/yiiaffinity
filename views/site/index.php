<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;

$this->title = 'YiiAffinity';

?>
<div class="fondo p-2">
    <div class="row p-0 m-0">
        <div class="col-12 my-0">
            <h1 class="text-center text-md-left h1">Novedades</h1>
        </div>

        <?php if (count($peliculas) > 0) : ?>
            <section class=" col-12 my-0">
                <h2 class="text-center text-md-left h2">Películas</h2>
                <?= $this->render('/productos/_productos', [
                    'productos' => $peliculas,
                ]) ?>
            </section>
        <?php endif ?>
        <?php if (count($series) > 0) : ?>
            <section class=" col-12 my-0">
                <h2 class="text-center text-md-left h2">Series</h2>
                <?= $this->render('/productos/_productos', [
                    'productos' => $series,
                ]) ?>
            </section>
        <?php endif ?>
        <?php if (count($documentales) > 0) : ?>
            <section class=" col-12 my-0">
                <h2 class="text-center text-md-left h2">Documentales</h2>
                <?= $this->render('/productos/_productos', [
                    'productos' => $documentales,
                ]) ?>
            </section>
        <?php endif ?>
    </div>
</div>
