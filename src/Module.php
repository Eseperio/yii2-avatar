<?php

namespace eseperio\avatar;

use Yii;
use yii\helpers\ArrayHelper;
use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module
{
    /**
     * Available formats
     */
    const FORMAT_PNG = 1;
    const FORMAT_JPG = 2;

    /**
     * @inheritdoc
     */
    public $defaultRoute = ['avatar'];
    /**
     * This will set the name of the file created for each.
     * The following formats are handled in different ways
     *
     * - `null` will use the `id` property.
     * - `string` will be used to extract the property from the user object using ArrayHelper::getValue
     * - `closure` a custom function that returns a unique identifier.Signature: `function($id , $module){}`
     * - `array` an array pointing to a controller and action to be used as source of unique id.
     *
     * @var null|\Closure|string
     */
    public $avatarFileName = null;
    /**
     * @var string component to be used when generating avatar id. Ignored if $avatarFilename is a closure
     */
    public $userComponent = 'user';
    /**
     * @var bool|string|array the path to default image
     */
    public $defaultImage = false;
    /**
     * @var bool whether create the target directories if they do not exists.
     */
    public $createDirectories = true;
    /**
     * @var int size of thumbnail size
     */
    public $thumbWidth = 250;
    /**
     * @var int size of thumbnail size
     */
    public $thumbHeight = 250;
    /**
     * @var string
     */
    public $outputFormat = 2; //Defaults to jpg. See Module::FORMAT_JPG
    /**
     * @var bool whether keep the original uploaded file
     */
    public $keepOriginal = true;
    /**
     * @var string suffix to be appended to original files. If keep original enabled
     */
    public $originalSuffix = 'or';
    /**
     * @var string directory where the files will be uploaded without trailing slash
     */
    public $uploadDir = '@app/uploads';
    /**
     * @var string directory to store thumbs generated without trailing slash. You can set a non web visible folder and
     *             get the pictures via link to ['/avatar/default/picture','id'=> $id ].
     */
    public $thumbsDir = '@app/images/thumbs';
    /**
     * @var string name of the attribute to be used on forms
     */
    public $attributeName = 'image';
    /**
     * @var array validator to be used for image uploaded
     */
    public $imageValidator = [
        'class' => 'yii\validators\ImageValidator',
        'extensions' => 'png,jpg'
    ];
    /**
     * @var array list of allowed mimetypes
     */
    public $mimeTypes = [
        'image/jpeg',
        'image/png'
    ];
    /**
     * @var string to be used when joining avatar name parts
     */
    public $glue = '_';
    /**
     * @var array users with this permissions will be able to update avatars from other users.
     */
    public $adminPermission = null;
    /**
     * @var string default image binary to be used when no avatar has been found.
     */
    public $defaultImageBlob = "data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUzIDUzIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MyA1MzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiNFN0VDRUQ7IiBkPSJNMTguNjEzLDQxLjU1MmwtNy45MDcsNC4zMTNjLTAuNDY0LDAuMjUzLTAuODgxLDAuNTY0LTEuMjY5LDAuOTAzQzE0LjA0Nyw1MC42NTUsMTkuOTk4LDUzLDI2LjUsNTMgIGM2LjQ1NCwwLDEyLjM2Ny0yLjMxLDE2Ljk2NC02LjE0NGMtMC40MjQtMC4zNTgtMC44ODQtMC42OC0xLjM5NC0wLjkzNGwtOC40NjctNC4yMzNjLTEuMDk0LTAuNTQ3LTEuNzg1LTEuNjY1LTEuNzg1LTIuODg4di0zLjMyMiAgYzAuMjM4LTAuMjcxLDAuNTEtMC42MTksMC44MDEtMS4wM2MxLjE1NC0xLjYzLDIuMDI3LTMuNDIzLDIuNjMyLTUuMzA0YzEuMDg2LTAuMzM1LDEuODg2LTEuMzM4LDEuODg2LTIuNTN2LTMuNTQ2ICBjMC0wLjc4LTAuMzQ3LTEuNDc3LTAuODg2LTEuOTY1di01LjEyNmMwLDAsMS4wNTMtNy45NzctOS43NS03Ljk3N3MtOS43NSw3Ljk3Ny05Ljc1LDcuOTc3djUuMTI2ICBjLTAuNTQsMC40ODgtMC44ODYsMS4xODUtMC44ODYsMS45NjV2My41NDZjMCwwLjkzNCwwLjQ5MSwxLjc1NiwxLjIyNiwyLjIzMWMwLjg4NiwzLjg1NywzLjIwNiw2LjYzMywzLjIwNiw2LjYzM3YzLjI0ICBDMjAuMjk2LDM5Ljg5OSwxOS42NSw0MC45ODYsMTguNjEzLDQxLjU1MnoiLz4KPGc+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNTU2MDgwOyIgZD0iTTI2Ljk1MywwLjAwNEMxMi4zMi0wLjI0NiwwLjI1NCwxMS40MTQsMC4wMDQsMjYuMDQ3Qy0wLjEzOCwzNC4zNDQsMy41Niw0MS44MDEsOS40NDgsNDYuNzYgICBjMC4zODUtMC4zMzYsMC43OTgtMC42NDQsMS4yNTctMC44OTRsNy45MDctNC4zMTNjMS4wMzctMC41NjYsMS42ODMtMS42NTMsMS42ODMtMi44MzV2LTMuMjRjMCwwLTIuMzIxLTIuNzc2LTMuMjA2LTYuNjMzICAgYy0wLjczNC0wLjQ3NS0xLjIyNi0xLjI5Ni0xLjIyNi0yLjIzMXYtMy41NDZjMC0wLjc4LDAuMzQ3LTEuNDc3LDAuODg2LTEuOTY1di01LjEyNmMwLDAtMS4wNTMtNy45NzcsOS43NS03Ljk3NyAgIHM5Ljc1LDcuOTc3LDkuNzUsNy45Nzd2NS4xMjZjMC41NCwwLjQ4OCwwLjg4NiwxLjE4NSwwLjg4NiwxLjk2NXYzLjU0NmMwLDEuMTkyLTAuOCwyLjE5NS0xLjg4NiwyLjUzICAgYy0wLjYwNSwxLjg4MS0xLjQ3OCwzLjY3NC0yLjYzMiw1LjMwNGMtMC4yOTEsMC40MTEtMC41NjMsMC43NTktMC44MDEsMS4wM1YzOC44YzAsMS4yMjMsMC42OTEsMi4zNDIsMS43ODUsMi44ODhsOC40NjcsNC4yMzMgICBjMC41MDgsMC4yNTQsMC45NjcsMC41NzUsMS4zOSwwLjkzMmM1LjcxLTQuNzYyLDkuMzk5LTExLjg4Miw5LjUzNi0xOS45QzUzLjI0NiwxMi4zMiw0MS41ODcsMC4yNTQsMjYuOTUzLDAuMDA0eiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=";

    public function init()
    {
        $this->registerTranslations();
        parent::init();
    }

    public function registerTranslations()
    {
        \Yii::$app->i18n->translations['avatar'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'en-EN',
            'basePath' => '@vendor/eseperio/yii2-avatar/src/i18n',
        ];
    }

    public function getExtension()
    {
        return $this->outputFormat == Module::FORMAT_JPG ? '.jpg' : '.png';
    }

    public function avatarExist($id)
    {
        $path = \Yii::getAlias($this->thumbsDir);

        return file_exists($path . $id);
    }

    public function canUpdate($id = null)
    {
        if (empty($id))
            return false;

        if ($this->getAvatarFileName($id) == $this->getAvatarFileName())
            return true;

        if (!empty($this->adminPermission) && is_string($this->adminPermission))
            return Yii::$app->user->can($this->adminPermission);

        return false;
    }

    /**
     * Returns the avatar filename. If no id is provided then current user id will be used.
     * @param null $id
     * @param null $suffix
     * @return string
     */
    public function getAvatarFileName($id = null, $suffix = null)
    {
        $name = "";
        $userComponent = Yii::$app->get($this->userComponent);

        if (is_array($this->avatarFileName) || $this->avatarFileName instanceof \Closure) {
            $name = call_user_func($this->avatarFileName, $id, $this);
        } elseif (!empty($id)) {
            $name = $id;
        } elseif (is_string($this->avatarFileName)) {
            $name = ArrayHelper::getValue($userComponent, $this->avatarFileName);
        } elseif (empty($this->avatarFileName)) {
            $name = $userComponent->id;
        }
        if (!empty($suffix))
            $name .= $this->glue . $suffix;


        return $name;
    }

    /**
     * Validates whether the path is not trying to go outside
     * @param $needle
     * @param $haystack
     * @return bool
     */
    public function validatePath($needle, $haystack)
    {
        $realpathHaystack = realpath(pathinfo($haystack,PATHINFO_DIRNAME));
        $realpathNeedle = realpath($needle);

        if ($realpathNeedle === $realpathHaystack)
            return true;

        return false;
    }
}