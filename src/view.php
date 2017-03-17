<?php
use yii\helpers\Html;
use xutl\swagger\SwaggerAsset;

/**
 * @var \yii\web\View $this
 * @var string $oauth
 */
$this->context->layout = false;
$asset = SwaggerAsset::register($this);
$this->title = 'Swagger UI';
$this->registerCss('body {margin: 0px;}');
$this->beginPage();
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="x-ua-compatible" content="IE=edge">
        <?= Html::csrfMetaTags() ?>
        <?= Html::tag('title', Html::encode($this->title)); ?>
        <link rel="icon" type="image/png" href="<?=$asset->baseUrl?>/images/favicon-32x32.png" sizes="32x32" />
        <link rel="icon" type="image/png" href="<?=$asset->baseUrl?>/images/favicon-16x16.png" sizes="16x16" />
        <?php $this->head() ?>
        <script type="text/javascript">
            jQuery(function () {
                var url = window.location.search.match(/url=([^&]+)/);
                if (url && url.length > 1) {
                    url = decodeURIComponent(url[1]);
                } else {
                    url = "<?= $restUrl ?>";
                }

                hljs.configure({
                    highlightSizeThreshold: 5000
                });

                // Pre load translate...
                if(window.SwaggerTranslator) {
                    window.SwaggerTranslator.translate();
                }
                window.swaggerUi = new SwaggerUi({
                    url: url,
                    dom_id: "swagger-ui-container",
                    supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                    onComplete: function(swaggerApi, swaggerUi){
                        if(typeof initOAuth == "function") {
                            initOAuth(<?=$oauth?>);
                        }

                        if(window.SwaggerTranslator) {
                            window.SwaggerTranslator.translate();
                        }
                    },
                    onFailure: function(data) {
                        log("Unable to Load SwaggerUI");
                    },
                    docExpansion: "none",
                    jsonEditor: false,
                    defaultModelRendering: 'schema',
                    showRequestHeaders: false,
                    showOperationIds: false
                });

                window.swaggerUi.load();

                function log() {
                    if ('console' in window) {
                        console.log.apply(console, arguments);
                    }
                }
            });
        </script>
    </head>

    <body class="swagger-section">
    <?php $this->beginBody() ?>
    <div id='header'>
        <div class="swagger-ui-wrap">
            <a id="logo" href="http://swagger.io"><img class="logo__img" alt="swagger" height="30" width="30" src="<?=$asset->baseUrl?>/images/logo_small.png" /><span class="logo__title">swagger</span></a>
            <form id='api_selector'>
                <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
                <div id='auth_container'></div>
                <div class='input'><a id="explore" class="header__btn" href="#" data-sw-translate>Explore</a></div>
            </form>
        </div>
    </div>
    <div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
    <div id="swagger-ui-container" class="swagger-ui-wrap"></div>
    <?php $this->endBody() ?>

    </body>
    </html>
<?php $this->endPage() ?>