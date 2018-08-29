<?php


namespace eseperio\avatar\models;


use eseperio\avatar\traits\ModuleAwareTrait;
use yii\base\Model;
use yii\validators\Validator;

class UploadForm extends Model
{

    use ModuleAwareTrait;

    public $image;

    public function rules()
    {
        $module = $this->module;
        $imageValidator = $module->imageValidator;
        $class = $imageValidator['class'];
        $params = array_slice($imageValidator, 2);
        $validator = Validator::createValidator($class, $this, (array)$module->attributeName, $params);

        return [$validator];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

            return true;
        } else {
            return false;
        }
    }
}