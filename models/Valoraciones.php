<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "valoraciones".
 *
 * @property int $producto_id
 * @property int $usuario_id
 * @property float|null $valoracion
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
            [['producto_id', 'usuario_id'], 'unique', 'targetAttribute' => ['producto_id', 'usuario_id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['producto_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
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
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('valoraciones');
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('valoraciones');
    }
}
