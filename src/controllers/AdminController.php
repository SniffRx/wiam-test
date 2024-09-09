<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\ImageDecision;

class AdminController extends Controller
{
    public function actionIndex()
    {
        $token = Yii::$app->request->get('token');
        if ($token !== 'xyz123') {
            throw new NotFoundHttpException('Page not found');
        }

        $decision = ImageDecision::find()->all();
        return $this->render('index', [
            'decision' => $decision,
        ]);
    }

    public function actionDelete($id)
    {
        $model = ImageDecision::findOne($id);
        if ($model) {
            $model->delete();
        }
        return $this->redirect(['index', 'token' => 'xyz123']);
    }
}
