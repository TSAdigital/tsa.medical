<?php

namespace app\controllers;

use app\models\ActionHistory;
use app\models\Certificate;
use app\models\Counterparty;
use app\models\CounterpartyFl;
use app\models\Division;
use app\models\Reference;
use app\models\UploadForm;
use app\models\Vaccination;
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
                        'actions' => ['index', 'view', 'create', 'update', 'blocked', 'active', 'history',
                            'subcat', 'counterparty-fl-list', 'counterparty-list', 'download',
                            'create-work', 'view-work', 'update-work', 'blocked-work', 'active-work',
                            'create-reference', 'view-reference', 'update-reference', 'blocked-reference', 'active-reference',
                            'create-certificate', 'view-certificate', 'update-certificate', 'active-certificate', 'blocked-certificate',
                            'add-file', 'view-file', 'update-file', 'delete-file', 'blocked-file', 'active-file',
                            'create-vaccination', 'view-vaccination', 'update-vaccination', 'blocked-vaccination', 'active-vaccination'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['workerIndex'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['workerView'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['workerCreate'],
                    ],
                    [
                        'actions' => ['counterparty-fl-list'],
                        'allow' => true,
                        'roles' => ['workerCreate'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['workerUpdate'],
                    ],
                    [
                        'actions' => ['active'],
                        'allow' => true,
                        'roles' => ['workerActive'],
                    ],
                    [
                        'actions' => ['blocked'],
                        'allow' => true,
                        'roles' => ['workerBlocked'],
                    ],
                    [
                        'actions' => ['history'],
                        'allow' => true,
                        'roles' => ['workerHistory'],
                    ],

                    [
                        'actions' => ['create-work'],
                        'allow' => true,
                        'roles' => ['workCreate'],
                    ],

                    [
                        'actions' => ['subcat'],
                        'allow' => true,
                        'roles' => ['workCreate'],
                    ],

                    [
                        'actions' => ['view-work'],
                        'allow' => true,
                        'roles' => ['workView'],
                    ],

                    [
                        'actions' => ['update-work'],
                        'allow' => true,
                        'roles' => ['workUpdate'],
                    ],
                    [
                        'actions' => ['active-work'],
                        'allow' => true,
                        'roles' => ['workActive'],
                    ],
                    [
                        'actions' => ['blocked-work'],
                        'allow' => true,
                        'roles' => ['workBlocked'],
                    ],
                    [
                        'actions' => ['create-certificate'],
                        'allow' => true,
                        'roles' => ['certificateCreate'],
                    ],
                    [
                        'actions' => ['counterparty-list'],
                        'allow' => true,
                        'roles' => ['certificateCreate'],
                    ],
                    [
                        'actions' => ['view-certificate'],
                        'allow' => true,
                        'roles' => ['certificateView'],
                    ],

                    [
                        'actions' => ['update-certificate'],
                        'allow' => true,
                        'roles' => ['certificateUpdate'],
                    ],
                    [
                        'actions' => ['active-certificate'],
                        'allow' => true,
                        'roles' => ['certificateActive'],
                    ],
                    [
                        'actions' => ['blocked-certificate'],
                        'allow' => true,
                        'roles' => ['certificateBlocked'],
                    ],

                    [
                        'actions' => ['create-reference'],
                        'allow' => true,
                        'roles' => ['referenceCreate'],
                    ],
                    [
                        'actions' => ['counterparty-list'],
                        'allow' => true,
                        'roles' => ['referenceCreate'],
                    ],
                    [
                        'actions' => ['view-reference'],
                        'allow' => true,
                        'roles' => ['referenceView'],
                    ],
                    [
                        'actions' => ['update-reference'],
                        'allow' => true,
                        'roles' => ['referenceUpdate'],
                    ],
                    [
                        'actions' => ['active-reference'],
                        'allow' => true,
                        'roles' => ['referenceActive'],
                    ],
                    [
                        'actions' => ['blocked-reference'],
                        'allow' => true,
                        'roles' => ['referenceBlocked'],
                    ],

                    [
                        'actions' => ['create-vaccination'],
                        'allow' => true,
                        'roles' => ['vaccinationCreate'],
                    ],
                    [
                        'actions' => ['counterparty-list'],
                        'allow' => true,
                        'roles' => ['vaccinationCreate'],
                    ],
                    [
                        'actions' => ['view-vaccination'],
                        'allow' => true,
                        'roles' => ['vaccinationView'],
                    ],
                    [
                        'actions' => ['update-vaccination'],
                        'allow' => true,
                        'roles' => ['vaccinationUpdate'],
                    ],
                    [
                        'actions' => ['active-vaccination'],
                        'allow' => true,
                        'roles' => ['vaccinationActive'],
                    ],
                    [
                        'actions' => ['blocked-vaccination'],
                        'allow' => true,
                        'roles' => ['vaccinationBlocked'],
                    ],

                    [
                        'actions' => ['add-file'],
                        'allow' => true,
                        'roles' => ['fileCreate'],
                    ],
                    [
                        'actions' => ['view-file'],
                        'allow' => true,
                        'roles' => ['fileView'],
                    ],
                    [
                        'actions' => ['download'],
                        'allow' => true,
                        'roles' => ['fileView'],
                    ],
                    [
                        'actions' => ['update-file'],
                        'allow' => true,
                        'roles' => ['fileUpdate'],
                    ],
                    [
                        'actions' => ['active-file'],
                        'allow' => true,
                        'roles' => ['fileActive'],
                    ],
                    [
                        'actions' => ['blocked-file'],
                        'allow' => true,
                        'roles' => ['fileBlocked'],
                    ],
                    [
                        'actions' => ['delete-file'],
                        'allow' => true,
                        'roles' => ['fileDelete'],
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
                    'active-certificate' => ['POST'],
                    'blocked-certificate' => ['POST'],
                    'active-reference' => ['POST'],
                    'blocked-reference' => ['POST'],
                    'active-vaccination' => ['POST'],
                    'blocked-vaccination' => ['POST'],
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

        $vaccination = Vaccination::find()->where(['worker_id' => $id]);
        $pagerVaccination = $_GET;
        $pagerVaccination['#'] = 'vaccination/';
        $vaccination = new ActiveDataProvider([
            'query' => $vaccination,
            'pagination' => [
                'params' => $pagerVaccination,
                'pageParam' => 'page-vaccination',
                'pageSize' => 9,
            ],
        ]);

        $certificate = Certificate::find()->where(['worker_id' => $id]);
        $pagerCertificate = $_GET;
        $pagerCertificate['#'] = 'reference/';
        $certificate = new ActiveDataProvider([
            'query' => $certificate,
            'pagination' => [
                'params' => $pagerCertificate,
                'pageParam' => 'page-certificate',
                'pageSize' => 9,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'age' => $age,
            'work' => $work,
            'reference' => $reference,
            'vaccination' => $vaccination,
            'certificate' => $certificate,
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
                $action_history->ActionHistory('fas fa-plus bg-green', '??????????????(??) ????????????????????', 'workers/view', $model->getId(), $model->counterparty->getFullName());
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
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', '????????????????????????????(??) ????????????????????', 'workers/view', $model->getId(), $model->counterparty->getFullName());
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
            $action_history->ActionHistory('fas fa-times bg-red', '??????????????????????(??) ????????????????????', 'workers/view', $model->getId(), $model->getCounterparty_name());
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
            $action_history->ActionHistory('fas fa-check bg-info', '??????????????????????(??) ????????????????????', 'workers/view', $model->getId(), $model->getCounterparty_name());
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
                    $position = '??????????????(??) ?????????????????? ' . Html::a($model->getPosition_name(), ['workers/view-work', 'id' => $worker->id, 'work' => $model->getId()]) . ' ????????????????????';
                    $action_history->ActionHistory('fas fa-plus bg-green', $position, 'workers/view', $worker->id, $worker->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
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
                            'title' => '???? ?????????????? ???????????????? ????????????',
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
                    'title' => '???????????? ???????????????? ?????????????????? ?? ???????????????????? ????????????',
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
                    $position = '????????????????????????????(??) ?????????????????? ' . Html::a($work->getPosition_name(), ['workers/view-work', 'id' => $model->id, 'work' => $work->getId()]) . ' ?? ????????????????????';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $position, 'workers/view', $model->id, $model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
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
                        'title' => '???? ?????????????? ???????????????? ????????????',
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
                    'title' => '???????????? ?????????????????????????? ???? ???????????????? ????????????',
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
            $position = '??????????????????????(??) ?????????????????? ' . Html::a($work->getPosition_name(), ['workers/view-work', 'id' => $model->id, 'work' => $work->getId()]) . ' ?? ????????????????????';
            $action_history->ActionHistory('fas fa-check bg-info', $position, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
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
            $position = '??????????????????????(??) ?????????????????? ' . Html::a($work->getPosition_name(), ['workers/view-work', 'id' => $model->id, 'work' => $work->getId()]) . ' ?? ??????????????????????';
            $action_history->ActionHistory('fas fa-times bg-red', $position, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->redirect(['view-work', 'id' => $id, 'work' => $work->id]);
    }

    public function actionCreateCertificate($id)
    {
        $model = new Certificate();
        $worker = $this->findModel($id);
        $model->worker_id = $id;
        $action_history = new ActionHistory();

        if ($worker->status == 10) {
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $position = '??????????????(??) ???????????????????? ' . Html::a($model->getSpecialization_name(), ['workers/view-certificate', 'id' => $worker->id, 'certificate' => $model->getId()]) . ' ????????????????????';
                    $action_history->ActionHistory('fas fa-plus bg-green', $position, 'workers/view', $worker->id, $worker->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-certificate', 'id' => $id, 'certificate' => $model->getId()]);
                } else {
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
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???????????? ???????????????? ???????????????????? ?? ???????????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $worker->id, '#' => 'certificate']);
        }

        return $this->render('create-certificate', [
            'model' => $model,
            'worker' => $worker,
        ]);
    }

    public function actionViewCertificate($id, $certificate)
    {
        return $this->render('view-certificate', [
            'model' => $this->findModel($id),
            'certificate' => $this->findCertificate($certificate),
        ]);
    }

    public function actionUpdateCertificate($id, $certificate)
    {
        $model= $this->findModel($id);
        $certificate = $this->findCertificate($certificate);
        $certificate->worker_id = $id;
        $action_history = new ActionHistory();

        if ($certificate->status == 10) {
            if ($certificate->load(Yii::$app->request->post())) {
                if ($certificate->save()) {
                    $data = '????????????????????????????(??) ???????????????????? ' . Html::a($certificate->getSpecialization_name(), ['workers/view-certificate', 'id' => $model->id, 'certificate' => $certificate->getId()]) . ' ?? ????????????????????';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $data, 'workers/view', $model->id, $model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-certificate', 'id' => $id, 'certificate' => $certificate->id]);
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
        } else {
            Yii::$app->session->setFlash('warning', [
                'options' => [
                    'title' => '???????????? ?????????????????????????? ???? ???????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view-certificate', 'id' => $model->id, 'certificate' => $certificate->id]);
        }

        return $this->render('update-certificate', [
            'model' => $model,
            'certificate' => $certificate,
        ]);
    }

    public function actionActiveCertificate($id, $certificate)
    {
        $model = $this->findModel($id);
        $certificate = $this->findCertificate($certificate);
        $action_history = new ActionHistory();
        $certificate->setStatus('STATUS_ACTIVE');

        if ($certificate->status == 10) {
            $data = '??????????????????????(??) ???????????????????? ' . Html::a($certificate->getSpecialization_name(), ['workers/view-certificate', 'id' => $model->id, 'certificate' => $certificate->getId()]) . ' ?? ????????????????????';
            $action_history->ActionHistory('fas fa-check bg-info', $data, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->redirect(['view-certificate', 'id' => $id, 'certificate' => $certificate->id]);
    }

    public function actionBlockedCertificate($id, $certificate)
    {
        $model = $this->findModel($id);
        $certificate = $this->findCertificate($certificate);
        $action_history = new ActionHistory();
        $certificate->setStatus('STATUS_INACTIVE');

        if ($certificate->status == 9) {
            $data = '??????????????????????(??) ???????????????????? ' . Html::a($certificate->getSpecialization_name(), ['workers/view-certificate', 'id' => $model->id, 'certificate' => $certificate->getId()]) . ' ?? ??????????????????????';
            $action_history->ActionHistory('fas fa-times bg-red', $data, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->redirect(['view-certificate', 'id' => $id, 'certificate' => $certificate->id]);
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
                    $position = '??????????????(??) ?????????????? ' . Html::a($model->getReference_type_name(), ['workers/view-reference', 'id' => $worker->id, 'reference' => $model->getId()]) . ' ????????????????????';
                    $action_history->ActionHistory('fas fa-plus bg-green', $position, 'workers/view', $worker->id, $worker->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
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
                            'title' => '???? ?????????????? ???????????????? ????????????',
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
                    'title' => '???????????? ???????????????? ?????????????? ?? ???????????????????? ????????????',
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
                    $position = '????????????????????????????(??) ?????????????? ' . Html::a($reference->getReference_type_name(), ['workers/view-reference', 'id' => $model->id, 'reference' => $reference->getId()]) . ' ?? ????????????????????';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $position, 'workers/view', $model->id, $model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
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
                        'title' => '???? ?????????????? ???????????????? ????????????',
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
                    'title' => '???????????? ?????????????????????????? ???? ???????????????? ????????????',
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
            $position = '??????????????????????(??) ?????????????????? ' . Html::a($reference->getReference_type_name(), ['workers/view-reference', 'id' => $model->id, 'reference' => $reference->getId()]) . ' ?? ????????????????????';
            $action_history->ActionHistory('fas fa-check bg-info', $position, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
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
            $position = '??????????????????????(??) ?????????????? ' . Html::a($reference->getReference_type_name(), ['workers/view-reference', 'id' => $model->id, 'reference' => $reference->getId()]) . ' ?? ??????????????????????';
            $action_history->ActionHistory('fas fa-times bg-red', $position, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->redirect(['view-reference', 'id' => $id, 'reference' => $reference->id]);
    }

    public function actionCreateVaccination($id)
    {
        $vaccination_model = new Vaccination();
        $worker_model = $this->findModel($id);
        $vaccination_model->worker_id = $id;
        $action_history = new ActionHistory();

        if ($worker_model->status == 10) {
            if ($vaccination_model->load(Yii::$app->request->post())) {
                if ($vaccination_model->save()) {
                    $data = '??????????????(??) ???????????? ?? ???????????????????? ' . Html::a($vaccination_model->getVaccine_name(), ['workers/view-vaccination', 'id' => $worker_model->id, 'vaccination' => $vaccination_model->getId()]) . ' ????????????????????';
                    $action_history->ActionHistory('fas fa-plus bg-green', $data, 'workers/view', $worker_model->id, $worker_model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-vaccination', 'id' => $id, 'vaccination' => $vaccination_model->getId()]);
                } else {
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
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???????????? ???????????????? ???????????? ?? ???????????????????? ?? ???????????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view', 'id' => $worker_model->id, '#' => 'vaccination']);
        }

        return $this->render('create-vaccination', [
            'vaccination' => $vaccination_model,
            'worker' => $worker_model,
        ]);
    }


    public function actionViewVaccination($id, $vaccination)
    {
        return $this->render('view-vaccination', [
            'model' => $this->findModel($id),
            'vaccination' => $this->findVaccination($vaccination),
        ]);
    }

    public function actionUpdateVaccination($id, $vaccination)
    {
        $model= $this->findModel($id);
        $vaccination = $this->findVaccination($vaccination);
        $vaccination->worker_id = $id;
        $action_history = new ActionHistory();

        if ($vaccination->status == 10) {
            if ($vaccination->load(Yii::$app->request->post())) {
                if ($vaccination->save()) {
                    $position = '????????????????????????????(??) ???????????? ?? ???????????????????? ' . Html::a($vaccination->getVaccine_name(), ['workers/view-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->getId()]) . ' ?? ????????????????????';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $position, 'workers/view', $model->id, $model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
                            'toast' => true,
                            'position' => 'top-end',
                            'timer' => 5000,
                            'showConfirmButton' => false
                        ]
                    ]);
                    return $this->redirect(['view-vaccination', 'id' => $id, 'vaccination' => $vaccination->id]);
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
        } else {
            Yii::$app->session->setFlash('warning', [
                'options' => [
                    'title' => '???????????? ?????????????????????????? ???? ???????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
            return $this->redirect(['view-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->id]);
        }

        return $this->render('update-vaccination', [
            'model' => $model,
            'vaccination' => $vaccination,
        ]);
    }

    public function actionActiveVaccination($id, $vaccination)
    {
        $model = $this->findModel($id);
        $vaccination = $this->findVaccination($vaccination);
        $action_history = new ActionHistory();
        $vaccination->setStatus('STATUS_ACTIVE');

        if ($vaccination->status == 10) {
            $data = '??????????????????????(??) ???????????? ?? ???????????????????? ' . Html::a($vaccination->getVaccine_name(), ['workers/view-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->getId()]) . ' ?? ????????????????????';
            $action_history->ActionHistory('fas fa-check bg-info', $data, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->redirect(['view-vaccination', 'id' => $id, 'vaccination' => $vaccination->id]);
    }

    public function actionBlockedVaccination($id, $vaccination)
    {
        $model = $this->findModel($id);
        $vaccination = $this->findVaccination($vaccination);
        $action_history = new ActionHistory();
        $vaccination->setStatus('STATUS_INACTIVE');

        if ($vaccination->status == 9) {
            $position = '??????????????????????(??) ???????????? ?? ???????????????????? ' . Html::a($vaccination->getVaccine_name(), ['workers/view-vaccination', 'id' => $model->id, 'vaccination' => $vaccination->getId()]) . ' ?? ??????????????????????';
            $action_history->ActionHistory('fas fa-times bg-red', $position, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->redirect(['view-vaccination', 'id' => $id, 'vaccination' => $vaccination->id]);
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
                    $text = '??????????????(??) ???????? ' . Html::a($model->name, ['workers/view-file', 'id' => $worker->id, 'file' => $model->getId()]) . ' ????????????????????';
                    $action_history->ActionHistory('fas fa-plus bg-green', $text, 'workers/view', $worker->id, $worker->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
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
                            'title' => '???? ?????????????? ???????????????? ????????????',
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
                    'title' => '???????????? ???????????????? ???????? ?? ???????????????????? ????????????',
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
                    $text = '????????????????????????????(??) ???????? ' . Html::a($file->name, ['workers/view-file', 'id' => $model->id, 'file' => $file->getId()]) . ' ?? ????????????????????';
                    $action_history->ActionHistory('fas fa-pencil-alt bg-blue', $text, 'workers/view', $model->id, $model->getCounterparty_name());
                    Yii::$app->session->setFlash('success', [
                        'options' => [
                            'title' => '???????????? ??????????????????',
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
                        'title' => '???? ?????????????? ???????????????? ????????????',
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
                    'title' => '???????????? ?????????????????????????? ???? ???????????????? ????????????',
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
            $text = '??????????????????????(??) ???????? ' . Html::a($file->name, ['workers/view-file', 'id' => $model->id, 'file' => $file->getId()]) . ' ?? ????????????????????';
            $action_history->ActionHistory('fas fa-check bg-info', $text, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
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
            $text = '??????????????????????(??) ???????? ' . Html::a($file->name, ['workers/view-file', 'id' => $model->id, 'file' => $file->getId()]) . ' ?? ??????????????????????';
            $action_history->ActionHistory('fas fa-times bg-red', $text, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????????? ????????????????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'options' => [
                    'title' => '???? ?????????????? ???????????????????????? ????????????',
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

        throw new NotFoundHttpException('?????????????????????? ???????????????? ???? ????????????????????.');
    }

    protected function findCounterpartyFl($id)
    {
        if (($model = CounterpartyFl::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('?????????????????????? ???????????????? ???? ????????????????????.');
    }

    protected function findWork($id)
    {
        if (($model = Work::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('?????????????????????? ???????????????? ???? ????????????????????.');
    }

    protected function findFile($id)
    {
        if (($model = WorkerFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('?????????????????????? ???????????????? ???? ????????????????????.');
    }

    protected function findCertificate($id)
    {
        if (($model = Certificate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('?????????????????????? ???????????????? ???? ????????????????????.');
    }

    protected function findReference($id)
    {
        if (($model = Reference::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('?????????????????????? ???????????????? ???? ????????????????????.');
    }

    protected function findVaccination($id)
    {
        if (($model = Vaccination::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('?????????????????????? ???????????????? ???? ????????????????????.');
    }

    public function actionCounterpartyFlList($q = null, $id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $q = preg_replace('/[^a-zA-Z??-????-??0-9]/ui', '', $q);
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
            $q = preg_replace('/[^a-zA-Z??-????-??0-9]/ui', '', $q);
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
                throw new NotFoundHttpException("???????? '{$download->name}' ???? ????????????!");
            }
        }
        Yii::$app->session->setFlash('warning', [
            'options' => [
                'title' => '???????????? ?????????????????? ???????? ?? ???????????????????? ????????????',
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
            $text = '????????????(??) ???????? ' . Html::a($file->name, ['workers/view-file', 'id' => $model->id, 'file' => $file->getId()]) . ' ?? ????????????????????';
            $action_history->ActionHistory('far fa-trash-alt bg-danger', $text, 'workers/view', $model->id, $model->getCounterparty_name());
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => '???????? ????????????',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }else{
            Yii::$app->session->setFlash('warning', [
                'options' => [
                    'title' => '???? ?????????????? ?????????????? ????????',
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
