<?php

namespace app\controllers;

use app\models\ActionHistory;
use app\models\Address;
use app\models\Contact;
use Yii;
use app\models\Counterparty;
use app\models\CounterpartySearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Html;
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'blocked', 'active', 'history', 'history-address', 'create-address', 'view-address', 'update-address', 'blocked-address', 'active-address', 'create-contact', 'view-contact', 'update-contact', 'blocked-contact', 'active-contact'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'blocked' => ['POST'],
                    'active' => ['POST'],
                    'blocked-contact' => ['POST'],
                    'active-contact' => ['POST'],
                    'blocked-address' => ['POST'],
                    'active-address' => ['POST'],
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
        $params = Yii::$app->request->queryParams;

        if (!isset($params['CounterpartySearch'])) {
            $params['CounterpartySearch']['status'] = 10;
        }

        $dataProvider = $searchModel->search($params);

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
                'pageParam' => 'page-address',
                'pageSize' => 9,
            ],
        ]);

        $contact = Contact::find()->where(['counterparty_id' => $id]);
        $contact = new ActiveDataProvider([
            'query' => $contact,
            'pagination' => [
                'pageParam' => 'page-contact',
                'pageSize' => 9,
            ],
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'address' => $address,
            'contact' => $contact,
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
            if ($model->save()) {
                $action_history->ActionHistory('fas fa-handshake bg-green', 'добавил(а) контрагента', 'counterparties/view', $model->getId(), $model->name);
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
     * Updates an existing Counterparty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        if ($model->status === 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $action_history->ActionHistory('fas fa-handshake bg-blue', 'отредактировал(а) контрагента', 'counterparties/view', $model->getId(), $model->name);
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
                } else {
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

        if ($counterparty->status == 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $addressHistory = $model->getAddressName();
                    $addressHistory = 'добавил(а) ' . Html::a($addressHistory, ['counterparties/view-address', 'id' => $counterparty->id, 'address' => $model->getId()]) . ' адрес контрагенту';
                    $action_history->ActionHistory('fas fa-map-marked-alt bg-green', $addressHistory, 'counterparties/view', $counterparty->id, $counterparty->name);
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
        $address = Address::findOne($address);

        return $this->render('view-address', [
            'model' => $this->findModel($id),
            'address' => $address,
        ]);
    }

    public function actionUpdateAddress($id, $address)
    {
        $counterparty = $this->findModel($id);
        $model = Address::findOne($address);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();

        if ($model->status === 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $addressHistory = $model->getAddressName();
                    $addressHistory = 'отредактировал(а) ' . Html::a($addressHistory, ['counterparties/view-address', 'id' => $counterparty->id, 'address' => $model->id]) . ' адрес контрагенту';
                    $action_history->ActionHistory('fas fa-map-marked-alt bg-blue', $addressHistory, 'counterparties/view', $counterparty->id, $counterparty->name);
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
        $address = Address::findOne($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_ACTIVE');

        if ($address->status == 10) {
            $addressHistory = $address->getAddressName();
            $addressHistory = 'активировал(а) ' . Html::a($addressHistory, ['counterparties/view-address', 'id' => $model->id, 'address' => $address->id]) . ' адрес контрагенту';
            $action_history->ActionHistory('fas fa-map-marked-alt bg-info', $addressHistory, 'counterparties/view', $model->getId(), $model->name);
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
        $address = Address::findOne($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_INACTIVE');

        if ($address->status == 9) {
            $addressHistory = $address->getAddressName();
            $addressHistory = 'аннулировал(а) ' . Html::a($addressHistory, ['counterparties/view-address', 'id' => $model->id, 'address' => $address->id]) . ' адрес контрагенту';
            $action_history->ActionHistory('fas fa-map-marked-alt bg-red', $addressHistory, 'counterparties/view', $model->getId(), $model->name);
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

    public function actionCreateContact($id)
    {
        $model = new Contact();
        $model->counterparty_id = $id;
        $counterparty = $this->findModel($id);
        $action_history = new ActionHistory();
        if ($counterparty->status == 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $addressHistory = 'добавил(а) контакт ' . Html::a($model->name, ['counterparties/view-contact', 'id' => $counterparty->id, 'contact' => $model->getId()]) . ' контрагенту';
                    $action_history->ActionHistory('fas fa-address-book bg-green', $addressHistory, 'counterparties/view', $counterparty->id, $counterparty->name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись добавлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view', 'id' => $id]);
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
                    'title' => 'Нельзя добавить контакт к неактивной записи',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $counterparty->id]);
        }

        return $this->render('create-contact', [
            'model' => $model,
            'counterparty' => $this->findModel($id),
        ]);
    }

    public function actionViewContact($id, $contact)
    {
        $contact = Contact::findOne($contact);

        return $this->render('view-contact', [
            'model' => $this->findModel($id),
            'contact' => $contact,
        ]);
    }

    public function actionUpdateContact($id, $contact)
    {
        $counterparty = $this->findModel($id);
        $model = Contact::findOne($contact);
        $model->counterparty_id = $id;
        $action_history = new ActionHistory();

        if ($model->status === 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $addressHistory = 'отредактировал(а) контакт ' . Html::a($model->name, ['counterparties/view-contact', 'id' => $counterparty->id, 'contact' => $model->id]) . ' у контрагента';
                    $action_history->ActionHistory('fas fa-address-book bg-blue', $addressHistory, 'counterparties/view', $counterparty->id, $counterparty->name);
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись обновлена',
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
            return $this->redirect(['view', 'id' => $counterparty->id]);
        }

        return $this->render('update-contact', [
            'model' => $model,
            'counterparty' => $counterparty,
        ]);
    }

    public function actionActiveContact($id, $contact)
    {
        $model = $this->findModel($id);
        $contact = Contact::findOne($contact);
        $action_history = new ActionHistory();
        $contact->setStatus('STATUS_ACTIVE');

        if ($contact->status == 10) {
            $addressHistory = 'активировал(а) контакт ' . Html::a($contact->name, ['counterparties/view-contact', 'id' => $model->id, 'contact' => $contact->id]) . ' у контрагента';
            $action_history->ActionHistory('fas fa-address-book bg-info', $addressHistory, 'counterparties/view', $model->getId(), $model->name);
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
        return $this->redirect(['view-contact', 'id' => $model->id, 'contact' => $contact->id]);
    }

    public function actionBlockedContact($id, $contact)
    {
        $model = $this->findModel($id);
        $contact = Contact::findOne($contact);
        $action_history = new ActionHistory();
        $contact->setStatus('STATUS_INACTIVE');

        if ($contact->status == 9) {
            $addressHistory = 'аннулировал(а) контакт ' . Html::a($contact->name, ['counterparties/view-contact', 'id' => $model->id, 'contact' => $contact->id]) . ' у контрагента';
            $action_history->ActionHistory('fas fa-address-book bg-red', $addressHistory, 'counterparties/view', $model->getId(), $model->name);
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
        return $this->redirect(['view-contact', 'id' => $model->id, 'contact' => $contact->id]);
    }

    public function actionBlocked($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_INACTIVE');

        if ($model->status == 9) {
            $action_history->ActionHistory('fas fa-handshake bg-red', 'аннулировал(а) контрагента', 'counterparties/view', $model->getId(), $model->name);
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

        return $this->redirect(['view', 'id' => $model->id]);
    }

    public function actionActive($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_ACTIVE');

        if ($model->status == 10) {
            $action_history->ActionHistory('fas fa-handshake bg-info', 'активировал(а) контрагента', 'counterparties/view', $model->getId(), $model->name);
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

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}
