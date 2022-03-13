<?php

namespace app\controllers;

use app\models\ActionHistory;
use app\models\AddressFl;
use app\models\Passport;
use Yii;
use app\models\CounterpartyFl;
use app\models\CounterpartyFlSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CounterpartiesFlController implements the CRUD actions for CounterpartyFl model.
 */
class CounterpartiesFlController extends Controller
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
                    'actions' => [
                        'blocked-passport' => ['POST'],
                        'active-passport' => ['POST'],
                        'blocked-address' => ['POST'],
                        'active-address' => ['POST'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CounterpartyFl models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CounterpartyFlSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CounterpartyFl model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $passport= Passport::find()->where(['counterparty_id' => $id]);
        $passport = new ActiveDataProvider([
            'query' => $passport,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        $address = AddressFl::find()->where(['counterparty_id' => $id]);
        $address = new ActiveDataProvider([
            'query' => $address,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'passport' => $passport,
            'address' => $address,
        ]);
    }

    public function actionCreatePassport($id)
    {
        $model = new Passport();
        $model->counterparty_id = $id;
        $counterparty = $this->findModel($id);
        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $action_history->ActionHistory('fas fa-passport bg-green', 'добавил(а) паспорт контрагенту', 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->firs_name . ' ' . $counterparty->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Паспорт добавлен',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('create-passport', [
            'model' => $model,
            'counterparty' =>  $this->findModel($id),
        ]);
    }

    public function actionUpdatePassport($id, $passport)
    {
        $counterparty = $this->findModel($id);
        $model = Passport::findOne($passport);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();

        if($model->status === 10) {
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()){
                    $action_history->ActionHistory('fas fa-passport bg-info', 'отредактировал(а) паспорт контрагенту', 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->firs_name . ' ' . $counterparty->middle_name);
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
        return $this->render('update-passport', [
            'model' => $model,
            'counterparty' =>  $counterparty,
        ]);
    }

    public function actionActivePassport($id, $passport)
    {
        $model = $this->findModel($id);
        $passport = Passport::findOne($passport);
        $action_history = new ActionHistory();
        $passport->setStatus('STATUS_ACTIVE');

        if ($passport->setStatus('STATUS_ACTIVE') === true) {
            $action_history->ActionHistory('fas fa-passport bg-info', 'активировал(а) паспорт контрагенту', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name. ' ' . $model->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Паспорт активирован',
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
                'title' => 'Не удалось активировать паспорт',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionBlockedPassport($id, $passport)
    {
        $model = $this->findModel($id);
        $passport = Passport::findOne($passport);
        $action_history = new ActionHistory();
        $passport->setStatus('STATUS_INACTIVE');

        if ($passport->setStatus('STATUS_INACTIVE') === true) {
            $action_history->ActionHistory('fas fa-passport bg-red', 'аннулировал(а) паспорт контрагенту', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name. ' ' . $model->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Паспорт аннулирован',
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
                'title' => 'Не удалось аннулировать подразделение',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionCreateAddress($id)
    {
        $model = new AddressFl();
        $counterparty = $this->findModel($id);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $action_history->ActionHistory('fas fa-map-marked-alt bg-green', 'добавил(а) адрес контрагенту', 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->firs_name. ' ' . $counterparty->middle_name);
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
        $model = AddressFl::findOne($address);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();

        if($model->status === 10) {
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()){
                    $action_history->ActionHistory('fas fa-map-marked-alt bg-blue', 'отредактировал(а) адрес контрагенту', 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->firs_name . ' ' . $counterparty->middle_name);
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
        $address = AddressFl::findOne($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_ACTIVE');

        if ($address->setStatus('STATUS_ACTIVE') === true) {
            $action_history->ActionHistory('fas fa-map-marked-alt bg-info', 'активировал(а) адрес контрагенту', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name. ' ' . $model->middle_name);
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
        $address = AddressFl::findOne($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_INACTIVE');

        if ($address->setStatus('STATUS_INACTIVE') === true) {
            $action_history->ActionHistory('fas fa-map-marked-alt bg-red', 'аннулировал(а) адрес контрагенту', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name. ' ' . $model->middle_name);
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
     * Creates a new CounterpartyFl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CounterpartyFl();

        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $action_history->ActionHistory('fas fa-user bg-green', 'добавил(а) контрагента', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name . ' ' . $model->middle_name);
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
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CounterpartyFl model.
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
                    $action_history->ActionHistory('fas fa-user bg-blue', 'отредактировал(а) контрагента', 'counterparties-fl/view', $model->getId(),  $model->last_name . ' ' . $model->firs_name . ' ' . $model->middle_name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Изменения сохранены',
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

        if ($model->setStatus('STATUS_INACTIVE') === true) {
            $action_history->ActionHistory('fas fa-user bg-red', 'аннулировал(а) контрагента', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name . ' ' . $model->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Контрагент аннулирован',
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
                'title' => 'Не удалось аннулировать контрагента',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_ACTIVE');

        if ($model->setStatus('STATUS_ACTIVE') === true) {
            $action_history->ActionHistory('fas fa-user bg-info', 'активировал(а) контрагента', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name . ' ' . $model->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Контрагент активирован',
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
                'title' => 'Не удалось активировать контрагента',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionHistory($id)
    {
        $query = ActionHistory::find()->orderBy('created_at DESC')->where(['url' => 'counterparties-fl/view', 'current_record' => $id]);

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
     * Finds the CounterpartyFl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CounterpartyFl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CounterpartyFl::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
