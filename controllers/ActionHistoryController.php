<?php

namespace app\controllers;

use app\models\ActionHistory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\AccessControl;


/**
 * Site controller
 */
class ActionHistoryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['historyIndex'],
                    ],
                ],
            ],
        ];
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $role = ArrayHelper::getColumn(Yii::$app->authManager->getRolesByUser(Yii::$app->user->identity->id), 'name');
        $role = array_shift($role);
        if($role === 'user'){
            $query = ActionHistory::find()
                ->leftJoin('auth_assignment', 'action_history.user = auth_assignment.user_id')
                ->where(['auth_assignment.item_name' => $role])->orderBy('created_at DESC');
        }else{
            $query = ActionHistory::find()->orderBy('created_at DESC');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);
        return $this->render('index',
        [
            'actionsHistory' => $dataProvider,
        ]);
    }
}