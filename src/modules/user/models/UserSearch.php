<?php

namespace nullref\fulladmin\modules\user\models;

use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form about User.
 */
class UserSearch extends \dektrium\user\models\UserSearch
{
    public $start_date;
    public $end_date;

    public function rules()
    {
        $rules = parent::rules();
        $rules['start_end_date'] = [['start_date', 'end_date'], 'safe'];

        return $rules;
    }

    /**
     * @param $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = $this->finder->getUserQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->created_at !== null) {
            $date = strtotime($this->created_at);
            $query->andFilterWhere(['between', 'created_at', $date, $date + 3600 * 24]);
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['registration_ip' => $this->registration_ip])
            ->andFilterWhere(['>=', 'created_at', $this->start_date ? strtotime($this->start_date) : null])
            ->andFilterWhere(['<=', 'created_at', $this->end_date ? strtotime($this->end_date) : null]);

        return $dataProvider;
    }
}
