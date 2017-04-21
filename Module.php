<?php

namespace robote13\catalog;

/**
 * shop-catalog module definition class
 */
class Module extends \yii\base\Module
{

    /**
     *
     * @var
     */
    public $relations = [
        'Album' => [
            'album' => ['robote13\filemanager\models\Album', ['album_id' => 'id'], true]
        ]
    ];

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'main';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'robote13\catalog\frontend\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //models\Product::$albumModel = $this->albumModel;
        $this->setDefaultViewPath();
    }

    private function setDefaultViewPath()
    {
        if(!is_dir($this->viewPath))
        {
            $pos = strrpos($this->controllerNamespace,'\\');
            $this->viewPath = str_replace('\\', '/', ltrim('@'.substr($this->controllerNamespace,0,$pos).'/views','\\'));
        }
    }
}
