<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$tmdbKey = getenv('TMDBKey');
$buscarPersona = Url::to(['/personas/buscar-personas']);
$buscarProductora = Url::to(['/productoras/buscar-productoras']);
$buscarGenero = Url::to(['/generos/buscar-generos']);

$js = <<<EOT

$(document).ready(function () {
    
    //devuelve la url necesaria segun el tipo
    function obtenerURL(){
        var tipoProducto = tipo();
        return 'https://api.themoviedb.org/3/search/' + tipoProducto;  //+ '?api_key=$tmdbKey&query=' + titulo + '&language=es'
    }

    $('#autorrelleno').select2({
        width: '100%',
        placeholder: 'Seleccione tipo película o serie',
        allowClear: true,
        ajax: {
            type: 'GET',
            url: obtenerURL,
            dataType: 'json',
            delay: 300,
            data: function (params) {
                return {
                    api_key: '$tmdbKey',
                    query: params.term,
                   language: 'es'
                }
            },
            processResults: function (data, textst, xhr) {
                var productos = [];
                var tipoProducto = tipo();
                $.each(data.results, (index, item) => {
                    if (tipoProducto == 'movie') {
                        productos.push({
                            id: item.id,
                            text: item.title
                        });
                    } else {
                        productos.push({
                            id: item.id,
                            text: item.name
                        });
                    }
                });
                return {results: productos}
            }
        },
        minimumInputLength: 1
      
    });

$('#productos-tipo_id').change(comprobar);


function comprobar() {
    var productoTipo = $('#productos-tipo_id').val();
    var autorrelleno = $('#autorrelleno');
    autorrelleno.empty();
   
    if (productoTipo == 1 || productoTipo == 2) {
        autorrelleno.attr('disabled', false);
       
    } else {
        autorrelleno.attr('disabled', true);
    }
}

comprobar();


// comprueba el tipo de producto para la url
function tipo() {
    var tipo =  $('#productos-tipo_id').val();
    var producto = '';
    if (tipo == 1) {
        producto = 'movie';
    }
    if (tipo == 2) {
        producto = 'tv';
    }

    return producto;
}


//Hace una peticion a la api segun el tipo de producto y rellena el los campos del formulario
$('#autorrelleno').change(function (ev) {
    var id = $(this).val();
    var tipoProducto = tipo();
    if (id != '') {
    var url = 'https://api.themoviedb.org/3/' + tipoProducto + '/' + id + '?api_key=$tmdbKey&language=es'
    $.ajax({
        type: 'GET',
             url: url
            }).done(function (data) {
               
                var pelicula = tipoProducto == 'movie';
                
                var titulo = pelicula ? data.title : data.name;
                var original = pelicula ? data.original_title : data.original_name;
                var fecha = pelicula ? data.release_date : data.first_air_date;

                $('#productos-titulo').val(titulo);

                $('#productos-titulo_original').val(original);
                $('#productos-anyo').val(new Date(fecha).getFullYear());
                if (data.episode_run_time > 0 && !pelicula) {
                    $('#productos-duracion').val(data.episode_run_time[0]);
                } else {
                    $('#productos-duracion').val(data.runtime);
                }
                if (data.production_countries.length > 0) {
                    $('#productos-pais').val(data.production_countries[0].name);
                }
                $('#productos-sinopsis').val(data.overview);
            });
        }
    });


    function peticionesGenericas(url){
        return {
            type: 'GET',
            url: url,
            dataType: 'json',
            delay: 300,
            data: function (params) {
                return {
                    search: params.term
                }
            },
            processResults: function (data) {
                var entidades = [];
                console.log(data);
                $.each(data.results, (index, item) => {
                        entidades.push({
                            id: item.id,
                            text: item.nombre
                        });
                });
                return {results: entidades}
            }
        };
    }

    $('#directores').select2({
        width:'100%',
        placeholder: 'Seleccione los directores del producto',
        allowClear: true,
        ajax: peticionesGenericas('$buscarPersona'),
        minimumInputLength: 1
    });
    
    $("#guionistas").select2({
        width:'100%',
        placeholder: 'Seleccione los guionistas del producto',
        allowClear: true,
        ajax: peticionesGenericas('$buscarPersona'),
        minimumInputLength: 1
    });
    
    $("#musica").select2({
        width:'100%',
        placeholder: 'Seleccione los compositores',
        allowClear: true,
        ajax: peticionesGenericas('$buscarPersona'),
        minimumInputLength: 1
    });

    $("#fotografia").select2({
        width:'100%',
        placeholder: 'Seleccione fotografía del producto',
        allowClear: true,
        ajax: peticionesGenericas('$buscarPersona'),
        minimumInputLength: 1
    });
    
    $("#interpretes").select2({
        width:'100%',
        placeholder: 'Seleccione el reparto del producto',
        allowClear: true,
        ajax: peticionesGenericas('$buscarPersona'),
        minimumInputLength: 1
    });
    
    $("#productoras").select2({
        width:'100%',
        placeholder: 'Seleccione las productoras',
        allowClear: true,
        ajax: peticionesGenericas('$buscarProductora'),
        minimumInputLength: 1
    });

    $("#generos").select2({
        width:'100%',
        placeholder: 'Seleccione los géneros',
        allowClear: true,
        ajax: peticionesGenericas('$buscarGenero'),
        minimumInputLength: 2
    });

});
EOT;
$this->registerJs($js);
?>

<div class="generic-form py-5 my-4">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-12 col-md-6">

            <?= $form->field($model, 'tipo_id')->dropdownList($tipos, ['prompt' => 'Seleccione', 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'autorrelleno')->dropdownList([], [
                'class' => 'form-control form-style',
                'id' => 'autorrelleno',

            ]) ?>

            <?= $form->field($model, 'cartel')->fileInput() ?>

            <?= $form->field($model, 'titulo')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'titulo_original')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'anyo')->textInput(['class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'duracion')->textInput(['class' => 'form-control form-style']) ?>


            <?= $form->field($model, 'pais')->textInput(['maxlength' => true, 'class' => 'form-control form-style']) ?>

            <?= $form->field($model, 'sinopsis')->textarea(['rows' => 6, 'class' => 'form-control form-style']) ?>
        </div>

        <div class="col-12 col-md-6">

            <?= $form->field($model, 'directores')->dropdownList($directores, [
                'id' => 'directores',
                'name' => 'directores',
                'multiple' => 'multiple',

            ])->label('Directores', ['for' => 'directores']) ?>


            <?= $form->field($model, 'guion')->dropdownList($guion, [
                'class' => 'form-control form-style',
                'id' => 'guionistas',
                'name' => 'guionistas',
                'multiple' => 'multiple',
            ]) ?>


            <?= $form->field($model, 'musica')->dropdownList($musica, [
                'id' => 'musica',
                'name' => 'musica',
                'multiple' => 'multiple',
            ]) ?>


            <?= $form->field($model, 'fotografia')->dropdownList($fotografia, [
                'id' => 'fotografia',
                'name' => 'fotografia',
                'multiple' => 'multiple',
            ]) ?>

            <?= $form->field($model, 'interpretes')->dropdownList($reparto, [
                'id' => 'interpretes',
                'name' => 'interpretes',
                'multiple' => 'multiple',
            ]) ?>


            <?= $form->field($model, 'productoras')->dropdownList($productoras, [
                'id' => 'productoras',
                'name' => 'productoras',
                'multiple' => 'multiple',
            ]) ?>


            <?= $form->field($model, 'generos')->dropdownList($generos, [
                'id' => 'generos',
                'name' => 'generos',
                'multiple' => 'multiple',
            ]) ?>
        </div>
        <div class="col-12 text-right">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-principal']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
