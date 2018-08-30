<?php

namespace eseperio\avatar\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\validators\ImageValidator;
use yii\web\Response;
use yii\web\UploadedFile;

class DefaultController extends \yii\web\Controller
{
    public function behaviors()
    {

        return [
            'verb' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'upload' => ['POST']
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => 'true',
                        'actions' => ['upload'],
                        'roles' => ['@']
                    ]
                ]

            ]

        ];
    }

    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['success' => false];
        if (Yii::$app->request->isPost) {
            $image = UploadedFile::getInstanceByName('avatar');
            $validator = new ImageValidator([
                'extensions' => 'png, jpg,jpeg',
                'maxWidth' => 3000,
                'maxHeight' => 3000,
                'skipOnEmpty' => true,
            ]);
            if ($validator->validate($image, $error)) {
                $original = Yii::getAlias('@docs/avatars/') . Yii::$app->user->id . "-" . Yii::$app->params['ORIGINAL_IMAGE_SUFFIX'];
                $image->saveAs($original);
                $thumbInstance = Image::thumbnail($original, 150, 150);
                $thumbInstance->save(Yii::getAlias('@webroot/public_avatars/') . Yii::$app->user->id . ".jpg");
                $response['success'] = true;
            } else {
                $response['error'] = $error;
            }
        }


        return $response;
    }
}