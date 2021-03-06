<?php

namespace app\controllers;

use Yii;
use app\models\Chats;
use app\models\ChatsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ChatsController implements the CRUD actions for Chats model.
 */
class ChatsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'update', 'delete', 'create', 'grupo', 'recuperar-chat'],
                'rules' => [
                    [
                        'actions' => ['grupo', 'recuperar-chat'],
                        'allow' => true,
                        'roles' => ['estudiante'],
                    ],
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'create'],
                        'allow' => true,
                        'roles' => ['profesor'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Chats models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChatsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionGrupo($chatid)
    {
        $userid = Yii::$app->user->identity->id;   
        $oUser = \app\models\Usuarios::findOne(['id' => $userid]);
        $chatiddecoded = Yii::$app->security->decryptByPassword($chatid, $oUser->password);
        
        $oChat = Chats::findOne(['id' => $chatiddecoded]);
        $grupo = \app\models\GruposAlumnos::findOne(['grupos_formados_id' => $oChat->grupos_formados_id, 'usuarios_id' => $userid]);
        if (!$grupo && $oUser->tipo != 1){
            throw new \yii\web\ForbiddenHttpException("No puede acceder a esta página");
        }
        
        $chat = \app\models\Sentencias::getSentenciasChat($chatiddecoded);
        $datosChat = Chats::findOne(['id' => $chatiddecoded]);
        $tarea = \app\models\Tareas::findOne(['id' => $datosChat->tareas_id]);

        return $this->render('grupo', [
            'chat' => $chat,
            'chatid' => $chatiddecoded,
            'tarea' => $tarea,
            'grupo_id' => $oChat->grupos_formados_id,
        ]);
    }
    
    public function actionRecuperarChat($chatid)
    {               
        $chat = \app\models\Sentencias::getSentenciasChat($chatid);

        return $this->renderAjax('recuperar-chat', [
            'chat' => $chat,
        ]);
    }

    /**
     * Displays a single Chats model.
     * @param integer $id
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
     * Creates a new Chats model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chats();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Chats model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
     * Deletes an existing Chats model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Chats model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chats the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Chats::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
