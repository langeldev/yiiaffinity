<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "listas".
 *
 * @property int $id
 * @property string $titulo
 *
 * @property UsuariosListas[] $usuariosListas
 */
class Listas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'listas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo'], 'required'],
            [['titulo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
        ];
    }

    /**
     * Gets query for [[UsuariosListas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuariosListas()
    {
        return $this->hasMany(UsuariosListas::class, ['lista_id' => 'id'])->inverseOf('lista');
    }
}
