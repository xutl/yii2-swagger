<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace xutl\swagger;

use Yii;
use yii\web\View;
use yii\web\AssetBundle;

/**
 * Class SwaggerAsset
 * @package xutl\swagger
 */
class SwaggerAsset extends AssetBundle
{
    public $sourcePath = '@bower/swagger-ui/dist';

    public $autoGenerate = true;

    /**
     * @var string language to register translation file for
     */
    public $language;

    public $js = [
        'lib/object-assign-pollyfill.js',
        'lib/jquery-1.8.0.min.js',
        'lib/jquery.slideto.min.js',
        'lib/jquery.wiggle.min.js',
        'lib/jquery.ba-bbq.min.js',
        'lib/handlebars-4.0.5.js',
        'lib/lodash.min.js',
        'lib/backbone-min.js',
        'swagger-ui.js',
        'lib/highlight.9.1.0.pack.js',
        'lib/highlight.9.1.0.pack_extended.js',
        'lib/jsoneditor.min.js',
        'lib/marked.js',
        'lib/swagger-oauth.js',
        'lang/translator.js',
        'lang/en.js',
        'lang/translator.js',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

    public $css = [
        [
            'css/typography.css',
            'media' => 'screen',
        ],
        [
            'css/reset.css',
            'media' => 'screen',
        ],
        [
            'css/screen.css',
            'media' => 'screen',
        ],
        //the setting will be overload, maybe the yii's issue.
        [
            'css/reset.css',
            'media' => 'print',
        ],
        //[
        //    'css/print.css',
        //    'media' => 'print',
        //],
    ];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view)
    {
        if ($this->autoGenerate) {
            $language = $this->language;
            $fallbackLanguage = substr($this->language, 0, 2);
            if ($fallbackLanguage !== $this->language && !file_exists(Yii::getAlias($this->sourcePath . "/lang/{$language}.js"))) {
                $language = $fallbackLanguage;
            }
            $this->js[] = "lang/$language.js";
        }
        parent::registerAssetFiles($view);
    }
}
?>
