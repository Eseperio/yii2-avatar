<?php

namespace eseperio\avatar\controllers;

use eseperio\avatar\Module;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\imagine\Image;
use yii\validators\ImageValidator;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * Class DefaultController
 * @package eseperio\avatar\controllers
 * @property Module $module
 */
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
        $module = $this->module;
        Yii::$app->response->format = Response::FORMAT_JSON;
        $response = ['success' => false];
        if (Yii::$app->request->isPost) {
            $image = UploadedFile::getInstanceByName($module->attributeName);
            $validator = new ImageValidator([
                'mimeTypes' => $module->mimeTypes,
                'maxWidth' => 3000,
                'maxHeight' => 3000,
                'skipOnEmpty' => true,
            ]);
            if ($validator->validate($image, $error)) {
                try {
                    $newFilename = $this->getNewFilename();
                    $ext = $module->outputFormat == Module::FORMAT_JPG ? '.jpg' : '.png';
                    $image->saveAs($newFilename . $ext);
                    $thumbInstance = Image::thumbnail($newFilename, $module->thumbWidth, $module->thumbHeight);
                    $thumbInstance->save(Yii::getAlias($module->uploadDir) . Yii::$app->user->id . $ext);
                    $response['success'] = true;
                } catch (\Throwable $e) {
                    $errorMsg = Yii::t('avatar', 'A problem ocurred uploading your picture. Contact administrator');
                    $response['error'] = YII_DEBUG ? $e->getMessage() : $errorMsg;
                }

            } else {
                $response['error'] = $error;
            }
        }


        return $response;
    }

    public function getNewFilename()
    {
        $name = [Yii::$app->user->id];
        if (!empty($this->module->originalSuffix))
            $name[] = $this->module->originalSuffix;

        return implode('_', $name);
    }
}