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
        $passport= Passport::find()->where(['counterparty' => $id]);
        $passport = new ActiveDataProvider([
            'query' => $passport,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        $address = AddressFl::find()->where(['counterparty' => $id]);
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
        $model->counterparty = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $model->counterparty = $id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
            $action_history->ActionHistory('fas fa-passport bg-info', 'активировал(а) паспорт', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name. ' ' . $model->middle_name);
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
        return $this->refresh();
    }

    public function actionBlockedPassport($id, $passport)
    {
        $model = $this->findModel($id);
        $passport = Passport::findOne($passport);
        $action_history = new ActionHistory();
        $passport->setStatus('STATUS_INACTIVE');

        if ($passport->setStatus('STATUS_INACTIVE') === true) {
            $action_history->ActionHistory('fas fa-passport bg-red', 'аннулировал(а) паспорт', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name. ' ' . $model->middle_name);
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
        return $this->refresh();
    }

    public function actionCreateAddress($id)
    {
        $model = new AddressFl();
        $counterparty = $this->findModel($id);
        $model->counterparty = $id;
        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $action_history->ActionHistory('fas fa-map-marked-alt bg-green', 'добавил(а) адрес', 'counterparties-fl/view', $counterparty->id, $counterparty->last_name . ' ' . $counterparty->firs_name. ' ' . $counterparty->middle_name);
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('create-address', [
            'model' => $model,
            'counterparty' =>  $this->findModel($id),
        ]);
    }

    public function actionUpdateAddress($id, $address)
    {
        $counterparty = $this->findModel($id);
        $model = AddressFl::findOne($address);
        $model->counterparty = $id;
        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
            $action_history->ActionHistory('fas fa-map-marked-alt bg-info', 'активировал(а) адрес', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name. ' ' . $model->middle_name);
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
        return $this->refresh();
    }

    public function actionBlockedAddress($id, $address)
    {
        $model = $this->findModel($id);
        $address = AddressFl::findOne($address);
        $action_history = new ActionHistory();
        $address->setStatus('STATUS_INACTIVE');

        if ($address->setStatus('STATUS_INACTIVE') === true) {
            $action_history->ActionHistory('fas fa-map-marked-alt bg-red', 'аннулировал(а) адрес', 'counterparties-fl/view', $model->getId(), $model->last_name . ' ' . $model->firs_name. ' ' . $model->middle_name);
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
        return $this->refresh();
    }

    /**
     * Creates a new CounterpartyFl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CounterpartyFl();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CounterpartyFl model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
