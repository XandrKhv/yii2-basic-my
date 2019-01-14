<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Post;
use app\modules\admin\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');

            if($model->img){
                $filenameNew = $model->upload();

                if ($model->save(false)) {
                    $modelt = Post::findOne($model->id);
                    $modelt->img = 'files/Posts/' . $filenameNew;
                }
                if($modelt->save(false)){
                    Yii::$app->session->setFlash('success', "Запись добавлена");

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                if($model->save()){
                    Yii::$app->session->setFlash('success', "Запись добавлена");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $image = $model->img;

        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');

            if($model->img){
                $filenameNew = $model->upload();

                if($filenameNew) {
                    $modelt = Post::findOne($id);

                    $modelt->img = 'files/Posts/' . $filenameNew;

                    if ($modelt->save(false)) {
                        $path = Yii::getAlias('@webroot') . '/' . $image;
                        @unlink($path);

                        Yii::$app->session->setFlash('success', "Запись обновлена");

                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }else{
                $model->img = $image;

                if($model->save(false)){
                    Yii::$app->session->setFlash('success', "Запись обновлена");

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $path = Yii::getAlias('@webroot') . '/' . $model->img;
        @unlink($path);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
