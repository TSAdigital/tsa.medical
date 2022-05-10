<?php

namespace app\controllers;

use app\models\ActionHistory;
use Yii;
use app\models\Position;
use app\models\PositionSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PositionsController implements the CRUD actions for Position model.
 */
class PositionsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'blocked', 'active', 'history'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['positionIndex'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['positionView'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['positionCreate'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['positionUpdate'],
                    ],
                    [
                        'actions' => ['active'],
                        'allow' => true,
                        'roles' => ['positionActive'],
                    ],
                    [
                        'actions' => ['blocked'],
                        'allow' => true,
                        'roles' => ['positionBlocked'],
                    ],
                    [
                        'actions' => ['history'],
                        'allow' => true,
                        'roles' => ['positionHistory'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'blocked' => ['POST'],
                    'active' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Position models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PositionSearch();

        $params = Yii::$app->request->queryParams;
        if (!isset($params['PositionSearch'])) {
            $params['PositionSearch']['status'] = 10;
        }
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Position model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Position model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Position();

        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $action_history->ActionHistory('fas fa-plus bg-green', 'добавил(а) должность', 'positions/view', $model->getId(), $model->name);
                Yii::$app->session->setFlash('success', [
                    'options' => [
                        'title' => 'Запись добавлена',
                        'toast' => true,
                        'position' => 'top-end',
                        'timer' => 5000,
                        'showConfirmButton' => false
                    ]
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->session->setFlash('error', [
                    'options' => [
                        'title' => 'Не удалось добавить запись',
                        'toast' => true,
                        'position' => 'top-end',
                        'timer' => 5000,
                        'showConfirmButton' => false
                    ]
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Position model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();

        if($model->status === 10){
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()){
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', 'отредактировал(а) должность', 'positions/view', $model->getId(), $model->name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись обновлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                Yii::$app->session->setFlash('error', [
                    'options' => [
                        'title' => 'Не удалось обновить запись',
                        'toast' => true,
                        'position' => 'top-end',
                        'timer' => 5000,
                        'showConfirmButton' => false
                    ]
                ]);
            }
        }else{
            Yii::$app->session->setFlash('warning', [
                'options' => [
                    'title' => 'Нельзя редактировать не активную запись',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionBlocked($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_INACTIVE');

        if ($model->status == 9) {
            $action_history->ActionHistory('fas fa-times bg-red', 'аннулировал(а) должность', 'positions/view', $model->getId(), $model->name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Запись аннулирована',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        Yii::$app->session->setFlash('error', [
            'options' => [
                'title' => 'Не удалось аннулировать запись',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->refresh();
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_ACTIVE');

        if ($model->status == 10) {
            $action_history->ActionHistory('fas fa-check bg-info', 'активировал(а) должность', 'positions/view', $model->getId(), $model->name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Запись активирована',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        Yii::$app->session->setFlash('error', [
            'options' => [
                'title' => 'Не удалось активировать запись',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->refresh();
    }

    public function actionHistory($id)
    {
        $query = ActionHistory::find()->orderBy('created_at DESC')->where(['url' => 'positions/view', 'current_record' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('history', [
            'model' => $this->findModel($id),
            'actionsHistory' => $dataProvider,
        ]);
    }

    /**
     * Finds the Position model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Position the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Position::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
