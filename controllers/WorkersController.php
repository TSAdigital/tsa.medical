<?php

namespace app\controllers;

use app\models\ActionHistory;
use app\models\Counterparty;
use app\models\CounterpartyFl;
use app\models\Division;
use app\models\Reference;
use app\models\UploadForm;
use app\models\Work;
use app\models\WorkerFile;
use DateTime;
use Yii;
use app\models\Worker;
use app\models\WorkerSearch;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * WorkersController implements the CRUD actions for Worker model.
 */
class WorkersController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'blocked', 'active', 'history', 'subcat', 'counterparty-fl-list', 'create-work', 'view-work', 'update-work', 'blocked-work', 'active-work', 'create-reference', 'counterparty-list', 'view-reference', 'update-reference', 'blocked-reference', 'active-reference', 'add-file', 'download', 'view-file', 'update-file', 'delete-file', 'blocked-file', 'active-file'],
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
                    'active-work' => ['POST'],
                    'blocked-work' => ['POST'],
                    'active-reference' => ['POST'],
                    'blocked-reference' => ['POST'],
                    'active-file' => ['POST'],
                    'blocked-file' => ['POST'],
                    'delete-file' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Worker models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkerSearch();

        $params = Yii::$app->request->queryParams;
        if (!isset($params['WorkerSearch'])) {
            $params['WorkerSearch']['status'] = 10;
        }
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Worker model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Exception
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $counterparty = $this->findCounterpartyFl($model->counterparty_id);
        $age = new DateTime(date('Y-m-d', strtotime($counterparty->birthdate)));
        $age = $age->diff(new DateTime)->format('%y');

        if(!empty($model->date_of_employment) and date('Y-m-d', strtotime($model->date_of_employment)) <= date('Y-m-d')){
            $date = date('Y-m-d', strtotime($model->date_of_employment));
            if(!empty($model->date_of_dismissal) and date('Y-m-d', strtotime($model->date_of_employment)) <= date('Y-m-d', strtotime($model->date_of_dismissal)))
            {
                $end_date = new DateTime(date('Y-m-d', strtotime($model->date_of_dismissal)));
            }elseif(!empty($model->date_of_dismissal) and date('Y-m-d', strtotime($model->date_of_employment)) > date('Y-m-d', strtotime($model->date_of_dismissal))){
                $end_date = NULL;
            }else{
                $end_date = new DateTime;
            }

            $work_time = new DateTime($date);
            $work_time = $end_date ? $work_time->diff($end_date)->days : NULL;

        }else{
            $work_time = NULL;
        }

        $work = Work::find()->where(['worker_id' => $id]);
        $pagerWork = $_GET;
        $pagerWork['#'] = 'work/';
        $work = new ActiveDataProvider([
            'query' => $work,
            'pagination' => [
                'params' => $pagerWork,
                'pageParam' => 'page-work',
                'pageSize' => 9,
            ],
        ]);

        $file = WorkerFile::find()->where(['worker_id' => $id]);
        $pagerFile = $_GET;
        $pagerFile['#'] = 'file/';
        $file = new ActiveDataProvider([
            'query' => $file,
            'pagination' => [
                'params' => $pagerFile,
                'pageParam' => 'page-file',
                'pageSize' => 9,
            ],
        ]);


        $reference = Reference::find()->where(['worker_id' => $id]);
        $pagerReference = $_GET;
        $pagerReference['#'] = 'reference/';
        $reference = new ActiveDataProvider([
            'query' => $reference,
            'pagination' => [
                'params' => $pagerReference,
                'pageParam' => 'page-reference',
                'pageSize' => 9,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'age' => $age,
            'work' => $work,
            'reference' => $reference,
            'work_time' => $work_time,
            'file' => $file
        ]);
    }

    /**
     * Creates a new Worker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Worker();

        $action_history = new ActionHistory();
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                $action_history->ActionHistory('fas fa-plus bg-green', 'добавил(а) сотрудника', 'workers/view', $model->getId(), $model->counterparty->getFullName());
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
     * Updates an existing Worker model.
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
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', 'отредактировал(а) сотрудника', 'workers/view', $model->getId(), $model->counterparty->getFullName());
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

    public function actionSubcat() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $out = Division::find()->where(['department'=>$cat_id, 'status' => 10])->select(['id', 'name'])->asArray()->all();
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionBlocked($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_INACTIVE');

        if ($model->status == 9) {
            $action_history->ActionHistory('fas fa-times bg-red', 'аннулировал(а) сотрудника', 'workers/view', $model->getId(), $model->getCounterparty_name());
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
            $action_history->ActionHistory('fas fa-check bg-info', 'активировал(а) сотрудника', 'workers/view', $model->getId(), $model->getCounterparty_name());
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
        $query = ActionHistory::find()->orderBy('created_at DESC')->where(['url' => 'workers/view', 'current_record' => $id]);

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

    public function actionCreateWork($id)
    {
        $model = new Work();
        $worker = $this->findModel($id);
        $model->worker_id = $id;
        $action_history = new ActionHistory();

        if ($worker->status == 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $position = 'добавил(а) должность ' . Html::a($model->getPosition_name(), ['workers/view-work', 'id' => $worker->id, 'work' => $model->getId()]) . ' сотруднику';
                    $action_history->ActionHistory('fas fa-plus bg-green', $position, 'workers/view', $worker->id, $worker->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись добавлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-work', 'id' => $id, 'work' => $model->getId()]);
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
                    'title' => 'Нельзя добавить должность к неактивной записи',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $worker->id, '#' => 'work']);
        }

        return $this->render('create-work', [
            'model' => $model,
            'worker' => $worker,
        ]);
    }

    public function actionViewWork($id, $work)
    {
        return $this->render('view-work', [
            'model' => $this->findModel($id),
            'work' => $this->findWork($work),
        ]);
    }

    public function actionUpdateWork($id, $work)
    {
        $model= $this->findModel($id);
        $work = $this->findWork($work);
        $work->worker_id = $id;
        $action_history = new ActionHistory();

        if ($work->status == 10) {
            if ($work->load(Yii::$app->request->post())) {
                if ($work->save()) {
                    $position = 'отредактировал(а) должность ' . Html::a($work->getPosition_name(), ['workers/view-work', 'id' => $model->id, 'work' => $work->getId()]) . ' у сотрудника';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $position, 'workers/view', $model->id, $model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись обновлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-work', 'id' => $id, 'work' => $work->id]);
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
            return $this->redirect(['view-work', 'id' => $model->id, 'work' => $work->id]);
        }

        return $this->render('update-work', [
            'model' => $model,
            'work' => $work,
        ]);
    }

    public function actionActiveWork($id, $work)
    {
        $model = $this->findModel($id);
        $work = $this->findWork($work);
        $action_history = new ActionHistory();
        $work->setStatus('STATUS_ACTIVE');

        if ($work->status == 10) {
            $position = 'активировал(а) должность ' . Html::a($work->getPosition_name(), ['workers/view-work', 'id' => $model->id, 'work' => $work->getId()]) . ' у сотрудника';
            $action_history->ActionHistory('fas fa-check bg-info', $position, 'workers/view', $model->id, $model->getCounterparty_name());
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

        return $this->redirect(['view-work', 'id' => $id, 'work' => $work->id]);
    }

    public function actionBlockedWork($id, $work)
    {
        $model = $this->findModel($id);
        $work = $this->findWork($work);
        $action_history = new ActionHistory();
        $work->setStatus('STATUS_INACTIVE');

        if ($work->status == 9) {
            $position = 'аннулировал(а) должность ' . Html::a($work->getPosition_name(), ['workers/view-work', 'id' => $model->id, 'work' => $work->getId()]) . ' у сотрудникуа';
            $action_history->ActionHistory('fas fa-times bg-red', $position, 'workers/view', $model->id, $model->getCounterparty_name());
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

        return $this->redirect(['view-work', 'id' => $id, 'work' => $work->id]);
    }

    public function actionCreateReference($id)
    {
        $model = new Reference();
        $worker = $this->findModel($id);
        $model->worker_id = $id;
        $action_history = new ActionHistory();

        if ($worker->status == 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $position = 'добавил(а) справку ' . Html::a($model->getReference_type_name(), ['workers/view-reference', 'id' => $worker->id, 'reference' => $model->getId()]) . ' сотруднику';
                    $action_history->ActionHistory('fas fa-plus bg-green', $position, 'workers/view', $worker->id, $worker->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись добавлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-reference', 'id' => $id, 'reference' => $model->getId()]);
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
                    'title' => 'Нельзя добавить справку к неактивной записи',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $worker->id, '#' => 'reference']);
        }

        return $this->render('create-reference', [
            'model' => $model,
            'worker' => $worker,
        ]);
    }

    public function actionViewReference($id, $reference)
    {
        return $this->render('view-reference', [
            'model' => $this->findModel($id),
            'reference' => $this->findReference($reference),
        ]);
    }

    public function actionUpdateReference($id, $reference)
    {
        $model= $this->findModel($id);
        $reference = $this->findReference($reference);
        $reference->worker_id = $id;
        $action_history = new ActionHistory();

        if ($reference->status == 10) {
            if ($reference->load(Yii::$app->request->post())) {
                if ($reference->save()) {
                    $position = 'отредактировал(а) справку ' . Html::a($reference->getReference_type_name(), ['workers/view-reference', 'id' => $model->id, 'reference' => $reference->getId()]) . ' у сотрудника';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $position, 'workers/view', $model->id, $model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись обновлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-reference', 'id' => $id, 'reference' => $reference->id]);
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
            return $this->redirect(['view-reference', 'id' => $model->id, 'reference' => $reference->id]);
        }

        return $this->render('update-reference', [
            'model' => $model,
            'reference' => $reference,
        ]);
    }

    public function actionActiveReference($id, $reference)
    {
        $model = $this->findModel($id);
        $reference = $this->findReference($reference);
        $action_history = new ActionHistory();
        $reference->setStatus('STATUS_ACTIVE');

        if ($reference->status == 10) {
            $position = 'активировал(а) должность ' . Html::a($reference->getReference_type_name(), ['workers/view-reference', 'id' => $model->id, 'reference' => $reference->getId()]) . ' у сотрудника';
            $action_history->ActionHistory('fas fa-check bg-info', $position, 'workers/view', $model->id, $model->getCounterparty_name());
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

        return $this->redirect(['view-reference', 'id' => $id, 'reference' => $reference->id]);
    }

    public function actionBlockedReference($id, $reference)
    {
        $model = $this->findModel($id);
        $reference = $this->findReference($reference);
        $action_history = new ActionHistory();
        $reference->setStatus('STATUS_INACTIVE');

        if ($reference->status == 9) {
            $position = 'аннулировал(а) справку ' . Html::a($reference->getReference_type_name(), ['workers/view-reference', 'id' => $model->id, 'reference' => $reference->getId()]) . ' у сотрудникуа';
            $action_history->ActionHistory('fas fa-times bg-red', $position, 'workers/view', $model->id, $model->getCounterparty_name());
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

        return $this->redirect(['view-reference', 'id' => $id, 'reference' => $reference->id]);
    }

    public function actionAddFile($id)
    {
        $model = new WorkerFile();
        $worker = $this->findModel($id);
        $file = new UploadForm();
        $model->worker_id = $id;
        $action_history = new ActionHistory();

        if ($worker->status == 10) {
            if ($model->load(Yii::$app->request->post()) and $this->uploadFile($model, $file)) {
                if ($model->save()) {
                    $text = 'добавил(а) файл ' . Html::a($model->name, ['workers/view-file', 'id' => $worker->id, 'file' => $model->getId()]) . ' сотруднику';
                    $action_history->ActionHistory('fas fa-plus bg-green', $text, 'workers/view', $worker->id, $worker->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись добавлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-file', 'id' => $id, 'file' => $model->id]);
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
                    'title' => 'Нельзя добавить файл к неактивной записи',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $worker->id, '#' => 'file']);
        }

        return $this->render('add-file', [
            'model' => $model,
            'worker' => $worker,
            'file' => $file
        ]);
    }

    public function actionViewFile($id, $file)
    {
        return $this->render('view-file', [
            'model' => $this->findModel($id),
            'file' => $this->findFile($file),
        ]);
    }

    public function actionUpdateFile($id, $file)
    {
        $model= $this->findModel($id);
        $file = $this->findFile($file);
        $file->worker_id = $id;
        $action_history = new ActionHistory();
        if($file->url == NULL && Yii::$app->request->isPost)
        {
            $upload= new UploadForm();
            $this->uploadFile($file, $upload);
        }
        if ($file->status == 10) {
            if ($file->load(Yii::$app->request->post())) {
                if ($file->save()) {
                    $text = 'отредактировал(а) файл ' . Html::a($file->name, ['workers/view-file', 'id' => $model->id, 'file' => $file->getId()]) . ' у сотрудника';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $text, 'workers/view', $model->id, $model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => 'Запись обновлена',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-file', 'id' => $id, 'file' => $file->id]);
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
            return $this->redirect(['view-file', 'id' => $model->id, 'file' => $file->id]);
        }

        return $this->render('update-file', [
            'model' => $model,
            'file' => $file,
        ]);
    }

    public function actionActiveFile($id, $file)
    {
        $model = $this->findModel($id);
        $file = $this->findFile($file);
        $action_history = new ActionHistory();
        $file->setStatus('STATUS_ACTIVE');

        if ($file->status == 10) {
            $text = 'активировал(а) файл ' . Html::a($file->name, ['workers/view-file', 'id' => $model->id, 'file' => $file->getId()]) . ' у сотрудника';
            $action_history->ActionHistory('fas fa-check bg-info', $text, 'workers/view', $model->id, $model->getCounterparty_name());
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

        return $this->redirect(['view-file', 'id' => $id, 'file' => $file->id]);
    }

    public function actionBlockedFile($id, $file)
    {
        $model = $this->findModel($id);
        $file = $this->findFile($file);
        $action_history = new ActionHistory();
        $file->setStatus('STATUS_INACTIVE');

        if ($file->status == 9) {
            $text = 'аннулировал(а) файл ' . Html::a($file->name, ['workers/view-file', 'id' => $model->id, 'file' => $file->getId()]) . ' у сотрудникуа';
            $action_history->ActionHistory('fas fa-times bg-red', $text, 'workers/view', $model->id, $model->getCounterparty_name());
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

        return $this->redirect(['view-file', 'id' => $id, 'file' => $file->id]);
    }


    /**
     * Finds the Worker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Worker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Worker::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

    protected function findCounterpartyFl($id)
    {
        if (($model = CounterpartyFl::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

    protected function findWork($id)
    {
        if (($model = Work::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

    protected function findFile($id)
    {
        if (($model = WorkerFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

    protected function findReference($id)
    {
        if (($model = Reference::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

    public function actionCounterpartyFlList($q = null, $id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $q = preg_replace('/[^a-zA-Zа-яА-Я0-9]/ui', '', $q);
            $query = new Query;
            $query->select(['id', "CONCAT(last_name,' ',first_name,' ',middle_name) AS text"])
                ->from('counterparty_fl')
                ->where(['like', "CONCAT(last_name,first_name,middle_name)", $q])
                ->orWhere(['like', 'snils', $q])
                ->andWhere(['status' => 10])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $counterparty = CounterpartyFl::findOne($id);
            $text = $counterparty->last_name . '' . $counterparty->first_name . ' ' . $counterparty->middle_name;
            $out['results'] = ['id' => $id, 'text' => $text];
        }
        return $out;
    }

    public function actionCounterpartyList($q = null, $id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $q = preg_replace('/[^a-zA-Zа-яА-Я0-9]/ui', '', $q);
            $query = new Query;
            $query->select(['id', 'name AS text'])
                ->from('counterparty')
                ->where(['like', 'name', $q])
                ->orWhere(['like', 'inn', $q])
                ->andWhere(['status' => 10])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $counterparty = Counterparty::findOne($id);
            $text = $counterparty->name;
            $out['results'] = ['id' => $id, 'text' => $text];
        }
        return $out;
    }

    public function actionDownload($id, $file)
    {
        $model = $this->findModel($id);
        $download = $this->findFile($file);
        $path = Yii::getAlias('@webroot').'/'.$download->url;
        $path_info = pathinfo($path);
        if($download->status == 10){
            if (file_exists($path) && $download->url != NULL) {
                $file_name = !empty(Inflector::slug($download->name,'-')) ? Inflector::slug($download->name,'-') : 'file';
                return Yii::$app->response->sendFile($path, $file_name . '.' .$path_info['extension']);
            }else {
                throw new NotFoundHttpException("Файл '{$download->name}' не найден!");
            }
        }
        Yii::$app->session->setFlash('warning', [
            'options' => [
                'title' => 'Нельзя скачивать файл у неактивной записи',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->redirect(['view-file', 'id' => $model->id, 'file' => $download->id]);
    }

    public function actionDeleteFile($id, $file)
    {
        $model = $this->findModel($id);
        $file = $this->findFile($file);
        $path = Yii::getAlias('@webroot').'/'.$file->url;
        $path_info = pathinfo($path);
        $file->url = NULL;
        $action_history = new ActionHistory();
        if ($file->save(false)) {
            if (!is_dir($path) && file_exists($path)){
                FileHelper::removeDirectory($path_info['dirname']);
            }
            $text = 'удалил(а) файл ' . Html::a($file->name, ['workers/view-file', 'id' => $model->id, 'file' => $file->getId()]) . ' у сотрудника';
            $action_history->ActionHistory('far fa-trash-alt bg-danger', $text, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Файл удален',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }else{
            Yii::$app->session->setFlash('warning', [
                'options' => [
                    'title' => 'Не удалось удалить файл',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }
        return $this->redirect(['update-file', 'id' => $model->id, 'file' => $file->id]);
    }

    protected function uploadFile($model, $upload)
    {
        $file_name = md5(uniqid(microtime(), true));
        $upload->file_name = $file_name;
        $file_dir = 'uploads/workers/' . md5(uniqid(microtime(), true)) . '/';
        FileHelper::createDirectory($file_dir, 0775, true);
        $upload->file_dir = $file_dir;
        $upload->file = UploadedFile::getInstance($upload, 'file');
        $model->url = $file_dir . $file_name . '.' .$upload->file->extension;
        if($upload->upload()){
            return true;
        }else{
            return false;
        }
    }
}
