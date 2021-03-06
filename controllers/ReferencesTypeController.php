<?php

namespace app\controllers;

use app\models\ActionHistory;
use Yii;
use app\models\ReferenceType;
use app\models\ReferenceTypeSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReferenceTypeController implements the CRUD actions for ReferenceType model.
 */
class ReferencesTypeController extends Controller
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
                        'roles' => ['referenceTypeIndex'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['referenceTypeCreate'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['referenceTypeView'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['referenceTypeUpdate'],
                    ],
                    [
                        'actions' => ['blocked'],
                        'allow' => true,
                        'roles' => ['referenceTypeBlocked'],
                    ],
                    [
                        'actions' => ['active'],
                        'allow' => true,
                        'roles' => ['referenceTypeActive'],
                    ],
                    [
                        'actions' => ['history'],
                        'allow' => true,
                        'roles' => ['referenceTypeHistory'],
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
     * Lists all ReferenceType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReferenceTypeSearch();
        $params = Yii::$app->request->queryParams;
        if (!isset($params['ReferenceTypeSearch'])) {
            $params['ReferenceTypeSearch']['status'] = 10;
        }
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReferenceType model.
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
     * Creates a new ReferenceType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReferenceType();

        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $action_history->ActionHistory('fas fa-plus bg-green', '??????????????(??) ?????? ??????????????', 'references-type/view', $model->getId(), $model->name);
                Yii::$app->session->setFlash('success', [
                    'options' => [
                        'title' => '???????????? ??????????????????',
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
                        'title' => '???? ?????????????? ???????????????? ????????????',
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
     * Updates an existing ReferenceType model.
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
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', '????????????????????????????(??) ?????? ??????????????', 'references-type/view', $model->getId(), $model->name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
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
                        'title' => '???? ?????????????? ???????????????? ????????????',
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
                    'title' => '???????????? ?????????????????????????? ???? ???????????????? ????????????',
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
            $action_history->ActionHistory('fas fa-times bg-red', '??????????????????????(??) ?????? ??????????????', 'references-type/view', $model->getId(), $model->name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
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
                'title' => '???? ?????????????? ???????????????????????? ????????????',
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
            $action_history->ActionHistory('fas fa-check bg-info', '??????????????????????(??) ?????? ??????????????', 'references-type/view', $model->getId(), $model->name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
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
                'title' => '???? ?????????????? ???????????????????????? ????????????',
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
        $query = ActionHistory::find()->orderBy('created_at DESC')->where(['url' => 'references-type/view', 'current_record' => $id]);

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
     * Finds the ReferenceType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ReferenceType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReferenceType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
