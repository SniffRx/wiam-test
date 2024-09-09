<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $imageId = $this->getRandomImageId();
        $imageUrl = "https://picsum.photos/id/$imageId/600/500";

        return $this->render('index', [
            'imageUrl' => $imageUrl,
            'imageId' => $imageId,
        ]);
    }

    public function actionDecision()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        Yii::info('POST data received: ' . file_get_contents('php://input'), __METHOD__);

        $postData = Yii::$app->request->getBodyParams();
        Yii::info('Parsed POST data: ' . print_r($postData, true), __METHOD__);

        $imageId = isset($postData['image_id']) ? $postData['image_id'] : null;
        $decision = isset($postData['decision']) ? $postData['decision'] : null;

        if ($imageId === null || $decision === null) {
            return ['status' => 'error', 'message' => 'Invalid parameters'];
        }

        if (!in_array($decision, ['approve', 'reject'])) {
            return ['status' => 'error', 'message' => 'Invalid decision'];
        }

        // Save decision to the database
        Yii::$app->db->createCommand()->insert('image_decision', [
            'image_id' => $imageId,
            'decision' => $decision,
        ])->execute();

        // Fetch the next image
        $newImageId = $this->getRandomImageId();
        $newImageUrl = "https://picsum.photos/id/$newImageId/600/500";

        return [
            'status' => 'success',
            'image_url' => $newImageUrl,
            'image_id' => $newImageId,
        ];
    }




    private function getRandomImageId()
    {
        $imageIds = range(1000, 1020); // Define a static range of IDs
        return $imageIds[array_rand($imageIds)];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
