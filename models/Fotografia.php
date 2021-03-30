<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "fotografia".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ProductosFotografia[] $productosFotografias
 * @property Productos[] $productos
 */
class Fotografia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fotografia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[ProductosFotografias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosFotografias()
    {
        return $this->hasMany(ProductosFotografia::className(), ['fotografia_id' => 'id'])->inverseOf('fotografia');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['id' => 'producto_id'])->viaTable('productos_fotografia', ['fotografia_id' => 'id']);
    }
}
