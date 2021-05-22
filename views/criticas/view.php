<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Criticas */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => $model->producto->titulo, 'url' => ['productos/ficha', 'id' => $model->producto_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fondo p-2">
    <div class="col-12">
        <section class="perfil-usuario">
            <?= $this->render('/usuarios/_perfil', [
                'usuario' => $model->usuario
            ]) ?>
        </section>
        <section class="criticas-container">
            <article class="p-3 p-md-5 critica-container">
                <header class="cabecera-critica-prod">

                    <div class="col-3 col-sm-2 img-critica p-0">
                        <?= Html::img($model->producto->getImagen(), ['class' => 'img-fluid']) ?>
                    </div>
                    <div class="col-9 col-sm-10">
                        <h4 class="critica-prod "><?= Html::a(Html::encode($model->producto->titulo), ['/productos/ficha', 'id' => $model->producto_id]) ?> <span class="anyo-prod">(<?= Html::encode($model->producto->anyo) ?>)</span></h4>
                        <p class="row">
                            <span class="media">
                                <?= Html::encode(number_format($model->producto->mediaCriticas, 1, ",", "")) ?>
                            </span>
                            <span class="total">
                                <?= Html::encode($model->producto->criticasTotales) ?> <i class="fa fa-user"></i>
                            </span>
                        </p>
                    </div>
                </header>
                <div class="cabecera-critica-usu py-2">
                    <div class="col-10 p-0">
                        <h5 class="titulo-critica p-0"><?= Html::encode($model->titulo) ?></h5>
                        <h6 class="fecha p-0"><?= Yii::$app->formatter->asDate($model->created_at, 'long') ?></h6>
                    </div>
                    <div class="valor-critica">
                        <?= Html::encode($model->valoracion) ?>
                    </div>
                </div>
                <p class="critica ">
                    <?= Html::encode($model->critica) ?>
                </p>
                <?php if (!Yii::$app->user->isGuest) : ?>
                    <?php if ($model->usuario_id === Yii::$app->user->id) : ?>
                        <footer>
                            <?= Html::a('Eliminar', ['criticas/delete', 'id' => $model->id], [
                                'class' => 'btn btn-eliminar',
                                'data' => [
                                    'confirm' => '¿Estás seguro de que quiere borrar la crítica?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                            <?= Html::a('Modificar', ['criticas/update', 'id' => $model->producto_id], [
                                'class' => 'btn btn-azul',
                                'data' => [
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </footer>
                    <?php endif ?>
                <?php endif ?>
            </article>
        </section>
    </div>
</div>
