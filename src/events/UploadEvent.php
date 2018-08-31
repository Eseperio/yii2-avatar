<?php


namespace eseperio\avatar\events;

use yii\base\Event;

class UploadEvent extends Event
{
    const EVENT_AFTER_UPLOAD = 'avatarAfterUpload';
    public $response;
    protected $filename;

    public function __construct($filename, $responseData, array $config = [])
    {
        $this->filename = $filename;
        $this->response = $responseData;

        parent::__construct($config);
    }

    /**
     * @return mixed
     */
    public function getFilename()
    {
        return $this->filename;
    }




}