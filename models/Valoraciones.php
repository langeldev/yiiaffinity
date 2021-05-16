<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "valoraciones".
 *
 * @property int $producto_id
 * @property int $usuario_id
 * @property float|null $valoracion
 * @property string|null $created_at
 *
 * @property Productos $producto
 * @property Usuarios $usuario
 */
class Valoraciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'valoraciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'usuario_id'], 'required'],
            [['producto_id', 'usuario_id'], 'default', 'value' => null],
            [['producto_id', 'usuario_id'], 'integer'],
            [['valoracion'], 'number'],
            [['created_at'], 'date', 'format' =>'php:Y-m-d H:i:s'],
            [['producto_id', 'usuario_id'], 'unique', 'targetAttribute' => ['producto_id', 'usuario_id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::class, 'targetAttribute' => ['producto_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'producto_id' => 'Producto ID',
            'usuario_id' => 'Usuario ID',
            'valoracion' => 'Valoracion',
        ];
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::class, ['id' => 'producto_id'])->inverseOf('valoraciones');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('valoraciones');
    }

    /**
     * Devuelve un array de clave y valor con los puntos para valorar
     * @return array
     */
    public static function listaPuntos()
    {
        $puntos = [];
        for ($i = 1; $i <=10; $i++) {
            $puntos[] = ['id' => $i, 'name' => $i];
        }
        return ArrayHelper::map($puntos, 'id', 'name');
    }
}
