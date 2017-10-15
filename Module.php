<?php

namespace robote13\catalog;

use Yii;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use vova07\fileapi\FileAPI;

/**
 * shop-catalog module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'main';

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'robote13\catalog\frontend\controllers';

    /**
     * @var string
     */
    public $fileapiComponent = 'fileapis';

    /**
     * @var boolean
     */
    public $enableBadge = true;

    /**
     * @var boolean
     */
    public $enableCategories = true;

    /**
     * @var array default FileAPI component settings
     * @see FileAPI
     */
    private $previewUploaderOptions = [
        'tempPath' => '@app/runtime/catalog-previews',
        'imageTransforms'=>[
            'cropped'=>[
                'maxWidth'=>150,
                'maxHeight'=>150,
                'preview'=> true
            ]
        ],
        'filesystem'=>'catalogPreviews'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        Yii::$container->set('sidanval\tabular\TabularForm', components\TabularForm::className());

        parent::init();
        $this->initFileAPI();
        $this->setDefaultViewPath();
    }

    /**
     * Preview uploader setter.
     * @see FileAPI
     * @param array $options
     */
    public function setPreviewUploaderOptions($options)
    {
        $this->previewUploaderOptions = ArrayHelper::merge($this->previewUploaderOptions, $options);
    }

    /**
     *
     * @param string $dimension 'width' or 'height'
     * @return integer size in pixels, 0 if transformation variant is not found
     */
    public function getCropDimension($dimension,$transformVariant = 'cropped')
    {
        $dimension = ucfirst($dimension);
        return ArrayHelper::getValue($this->previewUploaderOptions, "imageTransforms.{$transformVariant}.max{$dimension}",0);
    }

    private function setDefaultViewPath()
    {
        if(!is_dir($this->viewPath))
        {
            $pos = strrpos($this->controllerNamespace,'\\');
            $this->viewPath = str_replace('\\', '/', ltrim('@'.substr($this->controllerNamespace,0,$pos).'/views','\\'));
        }
    }

    private function initFileAPI(){
        if($this->enableBadge)
        {
            Yii::$container->setSingleton($this->fileapiComponent, array_merge($this->previewUploaderOptions,['class' => FileAPI::className()]));
            Event::on(models\ProductBase::className(), models\ProductBase::EVENT_INIT,function($event){
                    $event->sender->attachBehavior('uploadBehavior',[
                    'class' => 'vova07\fileapi\behaviors\UploadBehavior',
                    'fileapi' => $this->fileapiComponent,
                    'attributes' => [
                        'badge' => [
                            'url' => Yii::getAlias('@web/previews/')
                        ]
                    ]
                ]);
            });
        }
    }
}