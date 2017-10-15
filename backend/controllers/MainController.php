<?php

namespace robote13\catalog\backend\controllers;

use yii\web\Controller;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;

/**
 * Default controller for the `shop-catalog` module
 */
class MainController extends Controller
{
    public function actions()
    {
        return[
            'fileapi-upload' => [
                'class' => FileAPIUpload::className(),
                'fileapi'=> $this->module->fileapiComponent
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
