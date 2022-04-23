<?php

namespace app\controllers;

use app\models\ActionHistory;
use app\models\AddressFl;
use app\models\Passport;
use Yii;
use app\models\CounterpartyFl;
use app\models\CounterpartyFlSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Html;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'blocked', 'active', 'history', 'create-address', 'view-address', 'update-address', 'blocked-address', 'active-address', 'create-passport', 'view-passport', 'update-passport', 'blocked-passport', 'active-passport', 'generate'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'actions' => [
                        'blocked' => ['POST'],
                        'active' => ['POST'],
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
        $params = Yii::$app->request->queryParams;

        if (!isset($params['CounterpartyFlSearch'])) {
            $params['CounterpartyFlSearch']['status'] = 10;
        }

        $dataProvider = $searchModel->search($params);

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
                'pageParam' => 'page-passport',
                'pageSize' => 9,
            ],
        ]);
        $address = AddressFl::find()->where(['counterparty_id' => $id]);
        $address = new ActiveDataProvider([
            'query' => $address,
            'pagination' => [
                'pageParam' => 'page-address-fl',
                'pageSize' => 9,
            ],
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'passport' => $passport,
            'address' => $address,
        ]);
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

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $action_history->ActionHistory('fas fa-plus bg-green', 'добавил(а) контрагента', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name);
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
            } else {
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
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', 'отредактировал(а) контрагента', 'counterparties-fl/view', $model->getId(),  $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name);
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

        if ($model->setStatus('STATUS_INACTIVE') === true) {
            $action_history->ActionHistory('fas fa-times bg-red', 'аннулировал(а) контрагента', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name);
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
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_ACTIVE');

        if ($model->setStatus('STATUS_ACTIVE') === true) {
            $action_history->ActionHistory('fas fa-check bg-info', 'активировал(а) контрагента', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name);
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

    public function actionCreatePassport($id)
    {
        $model = new Passport();
        $model->counterparty_id = $id;
        $counterparty = $this->findModel($id);
        $action_history = new ActionHistory();

        if ($counterparty->status == 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $addressHistory = 'добавил(а) ' . Html::a('паспорт', ['counterparties-fl/view-passport', 'id' => $counterparty->id, 'passport' => $model->getId()]) . ' контрагенту';
                    $action_history->ActionHistory('fas fa-plus bg-green', $addressHistory, 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->first_name . ' ' . $counterparty->middle_name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись добавлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-passport', 'id' => $id, 'passport' => $model->getId()]);
                } else {
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
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => 'Нельзя добавить паспорт к неактивной записи',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $counterparty->id]);
        }

        return $this->render('create-passport', [
            'model' => $model,
            'counterparty' =>  $this->findModel($id),
        ]);
    }

    public function actionViewPassport($id, $passport)
    {
        return $this->render('view-passport', [
            'model' => $this->findModel($id),
            'passport' => $this->findPassport($passport),
        ]);
    }

    public function actionUpdatePassport($id, $passport)
    {
        $counterparty = $this->findModel($id);
        $model = $this->findPassport($passport);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();

        if($model->status === 10) {
            if ($model->load(Yii::$app->request->post())) {
                if($model->save()){
                    $addressHistory = 'отредактировал(а) ' . Html::a('паспорт', ['counterparties-fl/view-passport', 'id' => $counterparty->id, 'passport' => $model->getId()]) . ' у контрагента';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $addressHistory, 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->first_name . ' ' . $counterparty->middle_name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Изменения сохранены',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-passport', 'id' => $counterparty->id, 'passport' => $model->id]);
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
            return $this->redirect(['view-passport', 'id' => $counterparty->id, 'passport' => $model->id]);
        }
        return $this->render('update-passport', [
            'model' => $model,
            'counterparty' =>  $counterparty,
        ]);
    }

    public function actionActivePassport($id, $passport)
    {
        $model = $this->findModel($id);
        $passport = $this->findPassport($passport);
        $action_history = new ActionHistory();
        $passport->setStatus('STATUS_ACTIVE');

        if ($passport->setStatus('STATUS_ACTIVE') === true) {
            $addressHistory = 'активировал(а) ' . Html::a('паспорт', ['counterparties-fl/view-passport', 'id' => $model->id, 'passport' => $passport->getId()]) . ' у контрагента';
            $action_history->ActionHistory('fas fa-check bg-info', $addressHistory, 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->first_name. ' ' . $model->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Запись активирована',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view-passport', 'id' => $model->id, 'passport' => $passport->id]);
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
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionBlockedPassport($id, $passport)
    {
        $model = $this->findModel($id);
        $passport = $this->findPassport($passport);
        $action_history = new ActionHistory();
        $passport->setStatus('STATUS_INACTIVE');

        if ($passport->setStatus('STATUS_INACTIVE') === true) {
            $addressHistory = 'аннулировал(а) ' . Html::a('паспорт', ['counterparties-fl/view-passport', 'id' => $model->id, 'passport' => $passport->getId()]) . ' у контрагента';
            $action_history->ActionHistory('fas fa-times bg-red', $addressHistory, 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->first_name. ' ' . $model->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Запись аннулирована',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view-passport', 'id' => $model->id, 'passport' => $passport->id]);
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
        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionCreateAddress($id)
    {
        $model = new AddressFL();
        $counterparty = $this->findModel($id);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();

        if ($counterparty->status == 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $addressHistory = $model->getAddressName();
                    $addressHistory = 'добавил(а) адрес ' . Html::a($addressHistory, ['counterparties-fl/view-address', 'id' => $counterparty->id, 'address' => $model->getId()]) . ' контрагенту';
                    $action_history->ActionHistory('fas fa-plus bg-green', $addressHistory, 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->first_name . ' ' . $counterparty->middle_name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись добавлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-address', 'id' => $id, 'address' => $model->getId()]);
                } else {
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
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => 'Нельзя добавить адрес к неактивной записи',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $counterparty->id]);
        }

        return $this->render('create-address', [
            'model' => $model,
            'counterparty' => $counterparty,
        ]);
    }

    public function actionViewAddress($id, $address)
    {
        return $this->render('view-address', [
            'model' => $this->findModel($id),
            'address' => $this->findAddressFl($address),
        ]);
    }

    public function actionUpdateAddress($id, $address)
    {
        $counterparty = $this->findModel($id);
        $model = $this->findAddressFl($address);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();

        if ($model->status == 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $addressHistory = $model->getAddressName();
                    $addressHistory = 'отредактировал(а) адрес ' . Html::a($addressHistory, ['counterparties-fl/view-address', 'id' => $counterparty->id, 'address' => $model->id]) . ' у контрагента';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $addressHistory, 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->first_name . ' ' . $counterparty->middle_name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись обновлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-address', 'id' => $id, 'address' => $address]);
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
        } else {
            Yii::$app->session->setFlash('warning', [
                'options' => [
                    'title' => 'Нельзя редактировать не активную запись',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view-address', 'id' => $counterparty->id, 'address' => $model->id]);
        }

        return $this->render('update-address', [
            'model' => $model,
            'counterparty' => $counterparty,
        ]);
    }

    public function actionActiveAddress($id, $address)
    {
        $model = $this->findModel($id);
        $address = $this->findAddressFl($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_ACTIVE');

        if ($address->status == 10) {
            $addressHistory = $address->getAddressName();
            $addressHistory = 'активировал(а) адрес ' . Html::a($addressHistory, ['counterparties-fl/view-address', 'id' => $model->id, 'address' => $address->id]) . ' у контрагента';
            $action_history->ActionHistory('fas fa-check bg-info', $addressHistory, 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Запись активирована',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => 'Не удалось активировать запись',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->redirect(['view-address', 'id' => $id, 'address' => $address->id]);
    }

    public function actionBlockedAddress($id, $address)
    {
        $model = $this->findModel($id);
        $address = $this->findAddressFl($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_INACTIVE');

        if ($address->status == 9) {
            $addressHistory = $address->getAddressName();
            $addressHistory = 'аннулировал(а) адрес ' . Html::a($addressHistory, ['counterparties-fl/view-address', 'id' => $model->id, 'address' => $address->id]) . ' у контрагента';
            $action_history->ActionHistory('fas fa-times bg-red', $addressHistory, 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->first_name . ' ' . $model->middle_name);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Запись аннулирована',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => 'Не удалось аннулировать запись',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->redirect(['view-address', 'id' => $id, 'address' => $address->id]);
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

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

    protected function findPassport($passport)
    {
        if (($model = Passport::findOne($passport)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

    protected function findAddressFl($address)
    {
        if (($model = AddressFl::findOne($address)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}