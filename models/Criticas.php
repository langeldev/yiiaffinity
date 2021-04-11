<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "criticas".
 *
 * @property int $id
 * @property int $producto_id
 * @property int $usuario_id
 * @property float|null $valoracion
 * @property string $titulo
 * @property string $critica
 * @property string|null $created_at
 *
 * @property Productos $producto
 * @property Usuarios $usuario
 */
class Criticas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'criticas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'usuario_id', 'titulo', 'critica', 'valoracion'], 'required'],
            [['producto_id', 'usuario_id'], 'default', 'value' => null],
            [['producto_id', 'usuario_id'], 'integer'],
            [['valoracion'], 'number'],
            [['critica'], 'string'],
            [['created_at'], 'date', 'format' =>'php:Y-m-d H:i:s'],
            [['titulo'], 'string', 'max' => 255],
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
            'id' => 'ID',
            'producto_id' => 'Producto ID',
            'usuario_id' => 'Usuario ID',
            'valoracion' => 'Valoracion',
            'titulo' => 'Titulo',
            'critica' => 'Critica',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::class, ['id' => 'producto_id'])->inverseOf('criticas');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'usuario_id'])->inverseOf('criticas');
    }
}
