<?php

namespace app\controllers;

use app\models\ActionHistory;
use app\models\Address;
use Yii;
use app\models\Counterparty;
use app\models\CounterpartySearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CounterpartiesController implements the CRUD actions for Counterparty model.
 */
class CounterpartiesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Counterparty models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CounterpartySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Counterparty model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $address = Address::find()->where(['counterparty_id' => $id]);
        $address = new ActiveDataProvider([
            'query' => $address,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'address' => $address,
        ]);
    }

    /**
     * Creates a new Counterparty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Counterparty();

        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $action_history->ActionHistory('fas fa-handshake bg-green', 'добавил(а) контрагента', 'counterparties/view', $model->getId(), $model->name);
                Yii::$app->session->setFlash('success', [
                    'options' => [
                        'title' => 'Контрагент добавлен',
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
                        'title' => 'Не удалось добавить контрагента',
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
     * Updates an existing Counterparty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionHistory($id)
    {
        $query = ActionHistory::find()->orderBy('created_at DESC')->where(['url' => 'counterparties/view', 'current_record' => $id]);

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

    public function actionCreateAddress($id)
    {
        $model = new Address();
        $counterparty = $this->findModel($id);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $action_history->ActionHistory('fas fa-map-marked-alt bg-green', 'добавил(а) адрес контрагенту', 'counterparties/view', $counterparty->id, $counterparty->name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Адрес добавлен',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('create-address', [
            'model' => $model,
            'counterparty' =>  $counterparty,
        ]);
    }

    public function actionUpdateAddress($id, $address)
    {
        $counterparty = $this->findModel($id);
        $model = Address::findOne($address);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();

        if($model->status === 10) {
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()){
                    $action_history->ActionHistory('fas fa-map-marked-alt bg-blue', 'отредактировал(а) адрес контрагенту', 'counterparties/view', $counterparty->id, $counterparty->name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Изменения сохранены',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view', 'id' => $counterparty->id]);
                }
                Yii::$app->session->setFlash('error', [
                    'options' => [
                        'title' => 'Не удалось сохранить изменения',
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
            return $this->redirect(['view', 'id' => $counterparty->id]);
        }
        return $this->render('update-address', [
            'model' => $model,
            'counterparty' =>  $counterparty,
        ]);
    }

    public function actionActiveAddress($id, $address)
    {
        $model = $this->findModel($id);
        $address = Address::findOne($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_ACTIVE');

        if ($address->setStatus('STATUS_ACTIVE') === true) {
            $action_history->ActionHistory('fas fa-map-marked-alt bg-info', 'активировал(а) адрес контрагенту', 'counterparties/view', $model->getId(), $model->name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Адрес активирован',
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
                'title' => 'Не удалось активировать адрес',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionBlockedAddress($id, $address)
    {
        $model = $this->findModel($id);
        $address = Address::findOne($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_INACTIVE');

        if ($address->setStatus('STATUS_INACTIVE') === true) {
            $action_history->ActionHistory('fas fa-map-marked-alt bg-red', 'аннулировал(а) адрес контрагенту', 'counterparties/view', $model->getId(), $model->name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Адрес аннулирован',
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
                'title' => 'Не удалось аннулировать адрес',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /**
     * Finds the Counterparty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Counterparty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Counterparty::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
