<?php

namespace app\controllers;

use app\models\ActionHistory;
use app\models\User;
use app\models\UserSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UsersController implements the CRUD actions for User model.
 */
class UsersController extends Controller
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['profile'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'user-blocked', 'user-active'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'user-blocked' => ['POST'],
                    'user-active' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();
        $action_history = new ActionHistory();

        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->save();
            if ($model->save()){
                $action_history->ActionHistory('fas fa-user bg-green', 'добавил(а) пользователя', 'users/profile', $model->getId(), $model->username);
                Yii::$app->session->setFlash('success', [
                    'options' => [
                        'title' => 'Пользователь добавлен',
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
                    'title' => 'Не удалось добавить пользователя',
                    'toast' => true,
                    'position' => 'top-end',
                    'timer' => 5000,
                    'showConfirmButton' => false
                ]
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $old = $model->username;

        if ($model->load(Yii::$app->request->post())) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            $model->save();
            if ($model->save()){
                $action_history->ActionHistory('fas fa-user bg-blue', 'отредактировал(а) пользователя', 'users/profile', $model->getId(), $old != $model->username ? $old . ' <i class="fas fa-code"></i> ' . $model->username : $model->username);
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUserBlocked($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_INACTIVE');

        if ($model->setStatus('STATUS_INACTIVE') === true) {
            $action_history->ActionHistory('fas fa-user bg-red', 'заблокировал(а) пользователя', 'users/profile', $model->getId(), $model->username);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Пользователь заблокирован',
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
                'title' => 'Не удалось заблокировать пользователя',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->refresh();
    }

    public function actionUserActive($id)
    {
        $model = $this->findModel($id);
        $action_history = new ActionHistory();
        $model->setStatus('STATUS_ACTIVE');

        if ($model->setStatus('STATUS_ACTIVE') === true) {
            $action_history->ActionHistory('fas fa-user bg-info', 'разблокировал(а) пользователя', 'users/profile', $model->getId(), $model->username);
            Yii::$app->session->setFlash('success', [
                'options' => [
                    'title' => 'Пользователь активирован',
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
                'title' => 'Не удалось активировать пользователя',
                'toast' => true,
                'position' => 'top-end',
                'timer' => 5000,
                'showConfirmButton' => false
            ]
        ]);
        return $this->refresh();
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }

    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionProfile($id)
    {
        $query = ActionHistory::find()->orderBy('created_at DESC')->where(['user' => $id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);
        return $this->render('profile', [
            'model' => $this->findModel($id),
            'actionsHistory' => $dataProvider,
        ]);
    }
}
