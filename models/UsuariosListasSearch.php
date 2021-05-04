<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\UsuariosListas;
use Yii;

/**
 * UsuariosListasSerach represents the model behind the search form of `app\models\UsuariosListas`.
 */
class UsuariosListasSearch extends UsuariosListas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'usuario_id', 'lista_id'], 'integer'],
            [['lista.titulo'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['lista.titulo']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UsuariosListas::find()->joinWith('lista l');

        // add conditions that should always apply here
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query->where(['usuarios_listas.usuario_id' => Yii::$app->user->id]),
        ]);
        $dataProvider->sort->attributes['lista.titulo'] = [
            'asc' => ['l.titulo' => SORT_ASC],
            'desc' => ['l.titulo' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'usuario_id' => $this->usuario_id,
            'lista_id' => $this->lista_id,
        ]);

        $query->andFilterWhere(['ilike', 'l.titulo', $this->getAttribute('lista.titulo')]);
        return $dataProvider;
    }
}
