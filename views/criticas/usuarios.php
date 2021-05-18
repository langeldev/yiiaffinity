<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\LinkPager;

$this->title = $usuario->login;;
$this->params['breadcrumbs'][] = ['label' => 'Buscar amigos', 'url' => ['usuarios/buscar-amigos']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fondo p-2">
    <div class="col-12">

        
        <section class="perfil-usuario">
            <?= $this->render('/usuarios/_perfil', [
                'usuario' => $usuario
                ])?>

    </section>
    <ul class="nav-ficha col-12 mb-5">
        <li>
                <?= Html::a('Valoraciones [' . count($usuario->valoraciones) . ']', ['/valoraciones/usuarios', 'id' => $usuario->id]) ?>
            </li>
            <li>

                <?= Html::a('Críticas [' .count($usuario->criticas) . ']', '', ['class' => 'ficha-selected']) ?>
            </li>
            
        </ul>
        <div class="my-4 row col-12 justify-content-center pt-4">
        <?= LinkPager::widget([
            'pagination' => $pagination
            ]) ?>
    </div>
    <section class="criticas-container">
        <?php if ($criticas) : ?>
            <?php foreach ($criticas as $critica) : ?>
                <article class="p-3 p-md-5 critica-container">
                    <header class="cabecera-critica-prod">
                        
                        <div class="col-3 col-sm-2 img-critica p-0">
                            <?= Html::img($critica->producto->getImagen(), ['class' => 'img-fluid']) ?>
                        </div>
                        <div class="col-9 col-sm-10">
                            <h4 class="critica-prod "><?= Html::a(Html::encode($critica->producto->titulo), ['/productos/ficha', 'id' => $critica->producto_id]) ?>  <span class="anyo-prod">(<?=Html::encode($critica->producto->anyo)?>)</span></h4>
                            <p class="row">
                                <span class="media">
                                    <?=  Html::encode(number_format($critica->producto->mediaCriticas, 1, ",", "")) ?>
                                </span>
                                <span class="total">
                                    <?= Html::encode($critica->producto->criticasTotales()) ?> <i class="fa fa-user"></i>
                                </span>
                            </p>
                        </div>
                    </header>

                    <div class="cabecera-critica-usu py-2">
                        
                        <h5 class="titulo-critica col-11 p-0"><?= Html::a(Html::encode($critica->titulo), ['/criticas/view', 'id' => $critica->id]) ?></h5>
                        <div class="valor-critica">
                                <?= Html::encode($critica->valoracion) ?>
                        </div>
                        <h6 class="fecha col-11 p-0"><?= Yii::$app->formatter->asDate($critica->created_at, 'long') ?></h6>
                
                       
                    </div>
                    <p class="critica "> 
                        <?= Html::encode($critica->critica) ?>
                    </p>
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <?php if ($critica->usuario_id === Yii::$app->user->id) : ?>
                            <footer>
                                <?= Html::a('Eliminar', ['criticas/delete', 'id' => $critica->id], [
                                    'class' => 'btn btn-eliminar',
                                    'data' => [
                                        'confirm' => '¿Estás seguro de que quiere borrar la crítica?',
                                        'method' => 'post',
                                    ],
                                    ]) ?>
                                <?= Html::a('Modificar', ['criticas/update', 'id' => $critica->producto_id], [
                                            'class' => 'btn btn-votar',
                                            'data' => [
                                                'method' => 'post',
                                            ],
                                ]) ?>
                            </footer>
                        <?php endif ?> 
                        <?php endif ?> 
                </article>
                <?php endforeach ?>
                <?php else: ?>
        <article class="p-5 critica-container text-center">
            <h2>Este usuario hizo ninguna crítica</h2>
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
