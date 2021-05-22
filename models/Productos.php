<?php

namespace app\models;

use app\components\Utilidad;
use yii\imagine\Image;
use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property int $id
 * @property string $titulo
 * @property string $titulo_original
 * @property float $anyo
 * @property int $duracion
 * @property int $tipo_id
 * @property string $pais
 * @property string $sinopsis
 * @property string $imagen
 *
 * @property Criticas[] $criticas
 * @property Usuarios[] $usuarios
 * @property ListasProductos[] $listasProductos
 * @property UsuariosListas[] $listas
 * @property Premios[] $premios
 * @property Tipos $tipo
 * @property ProductosDirectores[] $productosDirectores
 * @property Personas[] $directores
 * @property ProductosFotografia[] $productosFotografias
 * @property Personas[] $fotografia
 * @property ProductosGeneros[] $productosGeneros
 * @property Generos[] $generos
 * @property ProductosGuionistas[] $productosGuionistas
 * @property Personas[] $guion
 * @property ProductosInterpretes[] $productosInterpretes
 * @property Personas[] $interpretes
 * @property ProductosMusica[] $productosMusicas
 * @property Personas[] $musica
 * @property ProductosProductoras[] $productosProductoras
 * @property Productoras[] $productoras
 * @property Valoraciones[] $valoraciones
 * @property Usuarios[] $usuarios0
 */
class Productos extends \yii\db\ActiveRecord
{
    public $cartel;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'titulo_original', 'anyo', 'duracion', 'tipo_id', 'pais', 'sinopsis'], 'required'],
            [['anyo'], 'number'],
            [['duracion', 'tipo_id'], 'default', 'value' => null],
            [['duracion', 'tipo_id'], 'integer'],
            [['sinopsis', 'imagen'], 'string'],
            [['titulo', 'titulo_original', 'pais'], 'string', 'max' => 255],
            [['tipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipos::class, 'targetAttribute' => ['tipo_id' => 'id']],
            [['cartel'], 'image', 'extensions' => 'png, jpg, jpeg']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'titulo_original' => 'Título Original',
            'anyo' => 'Año',
            'duracion' => 'Duración',
            'tipo_id' => 'Tipo',
            'pais' => 'País',
            'sinopsis' => 'Sinopsis',
            'directores' => 'Dirección',
            'guion' => 'Guion',
            'musica' => 'Música',
            'fotografia' => 'Fotografía',
            'interpretes' => 'Reparto',
            'productoras' => 'Porductora',
            'generos' => 'Géneros',
            'imagen' => 'Cartel'
        ];
    }

    /**
     * Gets query for [[Criticas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCriticas()
    {
        return $this->hasMany(Criticas::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::class, ['id' => 'usuario_id'])->viaTable('criticas', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ListasProductos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListasProductos()
    {
        return $this->hasMany(ListasProductos::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Listas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListas()
    {
        return $this->hasMany(UsuariosListas::class, ['id' => 'lista_id'])->viaTable('listas_productos', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[Premios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPremios()
    {
        return $this->hasMany(Premios::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Tipo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(Tipos::class, ['id' => 'tipo_id'])->inverseOf('productos');
    }

    /**
     * Gets query for [[ProductosDirectores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosDirectores()
    {
        return $this->hasMany(ProductosDirectores::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Directores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirectores()
    {
        return $this->hasMany(Personas::class, ['id' => 'persona_id'])->viaTable('productos_directores', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosFotografias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosFotografias()
    {
        return $this->hasMany(ProductosFotografia::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Fotografia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFotografia()
    {
        return $this->hasMany(Personas::class, ['id' => 'persona_id'])->viaTable('productos_fotografia', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosGeneros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosGeneros()
    {
        return $this->hasMany(ProductosGeneros::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Generos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGeneros()
    {
        return $this->hasMany(Generos::class, ['id' => 'genero_id'])->viaTable('productos_generos', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosGuionistas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosGuionistas()
    {
        return $this->hasMany(ProductosGuionistas::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Guion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGuion()
    {
        return $this->hasMany(Personas::class, ['id' => 'persona_id'])->viaTable('productos_guionistas', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosInterpretes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosInterpretes()
    {
        return $this->hasMany(ProductosInterpretes::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Interpretes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterpretes()
    {
        return $this->hasMany(Personas::class, ['id' => 'persona_id'])->viaTable('productos_interpretes', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosMusicas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosMusicas()
    {
        return $this->hasMany(ProductosMusica::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Musica]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMusica()
    {
        return $this->hasMany(Personas::class, ['id' => 'persona_id'])->viaTable('productos_musica', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosProductoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosProductoras()
    {
        return $this->hasMany(ProductosProductoras::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Productoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductoras()
    {
        return $this->hasMany(Productoras::class, ['id' => 'productora_id'])->viaTable('productos_productoras', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[Valoraciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getValoraciones()
    {
        return $this->hasMany(Valoraciones::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Usuarios0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios0()
    {
        return $this->hasMany(Usuarios::class, ['id' => 'usuario_id'])->viaTable('valoraciones', ['producto_id' => 'id']);
    }

      /**
     * Suma las valoraciones del producto
     *
     * @return int $number
     */
    private function suma()
    {
        return Valoraciones::find()->where(['producto_id' => $this->id])->sum('valoracion');
    }
    
    /**
     * Cuenta la cantidad de votos que tiene un producto
     *
     * @return int $number
     */
    public function getVotosTotales()
    {
        return Valoraciones::find()->where(['producto_id' => $this->id])->count();
    }

    /**
     * Hace la media de las valoraciones
     *
     * @return float $number
     */
    public function getMedia()
    {
        return number_format(
            ($this->votosTotales !== 0
            ? $this->suma() / $this->votosTotales
            : 0
            ),
            1
        );
    }

    /**
     * Suma las valoraciones de las críticas deĺ producto
     *
     * @return int $number
     */
    private function sumaCriticas()
    {
        return Criticas::find()->where(['producto_id' => $this->id])->sum('valoracion');
    }

    /**
     * Cuenta la cantidad de criticas que tiene un producto
     *
     * @return int $number
     */
    public function getCriticasTotales()
    {
        return Criticas::find()->where(['producto_id' => $this->id])->count();
    }

    /**
     * Hace la media de las valoraciones de las criticas
     *
     * @return float $number
     */
    public function getMediaCriticas()
    {
        return number_format(
            ($this->criticasTotales !== 0
            ? $this->sumaCriticas() / $this->criticasTotales
            : 0
            ),
            1
        );
    }

    /**
    * Carga las imagenes del formulario y las prepara para subir a AWS
    */
    public function upload()
    {
        if ($this->cartel !== null) {
            $titulo = \str_replace(' ', '', $this->titulo) . '_' . $this->anyo;
            $rutaCartel = Yii::getAlias('@uploads/' . $titulo . '.' . $this->cartel->extension);
            $this->cartel->saveAs($rutaCartel);

            Image::resize($rutaCartel, 260, 327)->save();

            $this->imagen =  Utilidad::subirCartelS3($this->cartel, $titulo, $rutaCartel);
            $this->cartel = null;
        }
    }

    /**
    * Devuelve la url donde está alojado el cartel
    *
    * @return string $imagen
    */
    public function getImagen()
    {
        $imagen = $this->imagen ?? 'default.jpg';
        return Utilidad::getCartel($imagen);
    }

    /**
    * Elimina el cartel si ya existía previamente
    *
    */
    public function borrarCartel()
    {
        if ($this->imagen !== null) {
            Utilidad::borrarEnS3($this->imagen);
        }
    }
}
