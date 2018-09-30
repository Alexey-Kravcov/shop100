<?php

namespace frontend\controllers;

use frontend\models\profile\ProfileGenders;
use frontend\models\ProfileAssign;
use Yii;
use frontend\controllers\FrontendController;
use frontend\models\profile\Profile;
use frontend\models\profile\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProfileController implements the CRUD actions for Profile model.
 */
class ProfileController extends FrontendController
{
    /**
     * @inheritdoc
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
     * Lists all Profile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFill()
    {
        $model = new Profile();
        $profile = $model->findOne(['user_id' => \Yii::$app->user->identity->id ] );

        if($profile) {
            $model->setIsNewRecord(false);
        }
        //echo "<pre>"; echo Yii::getAlias("@app"); echo "</pre>";die();

        if($model->load(\Yii::$app->request->post()) && $model->isNewRecord) /*&& $model->validate()) */ {
            $model->user_id = \Yii::$app->user->id;
            $model->updated_at = time();
            if ($model->isNewRecord) {
                $model->created_at = time();
            }
            echo "<pre>"; print_r($model->getAttributes()); echo "</pre>";

            if($model->validate()) {
                $model->birthday = "1988";
                if ($model->save()) {
                    echo "Данные сохранены";
                    self::actionIndex();
                } else {
                    echo "<pre>errors - "; print_r($model->errors); echo "</pre>";
                }
            }
        } else {
            echo "<pre>"; print_r($profile->getAttributes()); echo "</pre>";

           // $model->populateRecord($profile, $profile->getAttributes());
            if(\Yii::$app->request->isPost) {
                $profile->updated_at = time();
                $profile->gender = $model->gender;
                $profile->name = $model->name;
                $profile->birthday = $model->birthday;
                $profile->phone = $model->phone;
                $profile->status = $model->status;
                $profile->address = $model->address;
                echo "<pre>"; print_r($profile->getAttributes()); echo "</pre>";
                if($profile->save() ) echo "Данные обновлены";
                else "Не удалось обновить данные";
            }



        }
        $gender = ProfileGenders::find()
            -> select(['name'])
            -> indexBy('id')
            -> column();

        return $this->render('create', [
            'model' => $profile,
            'genders' => $gender,
            ]
        );
    }

    public function actionTest() {

        $model = new ProfileAssign();
        echo "Валидация yfxbyftnc";
        if($model->load(Yii::$app->request->post()) ) {
            echo "Валидация пройдена";
            if($model->save()) echo "<h3>Сохранено</h3>";
                else echo "Ошибки сохранения - ".$model->errors;
        } else {
            echo 'Ошибки валидации - '.$model->errors;
        }

        return $this->render('test',[
            'model'=> $model,
        ]);

    }

    /**
     * Displays a single Profile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Profile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Profile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Profile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Profile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
