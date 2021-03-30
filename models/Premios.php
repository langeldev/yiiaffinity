<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "premios".
 *
 * @property int $id
 * @property int $producto_id
 * @property int $cantidad
 * @property string $nombre
 *
 * @property Productos $producto
 */
class Premios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'premios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'cantidad', 'nombre'], 'required'],
            [['producto_id', 'cantidad'], 'default', 'value' => null],
            [['producto_id', 'cantidad'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['producto_id' => 'id']],
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
            'cantidad' => 'Cantidad',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('premios');
    }
}
