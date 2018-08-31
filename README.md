# yii2-avatar
**0.0.1 ALPHA**

Module to upload custom avatar picture

The intention of this library is add the ability to upload a profile picture via a simple widget.

It must not be dependent from another user management library.



## Usage

Add the module to your configuration like follows:
```php
'modules' => [
'avatar' => [
'class' => 'eseperio\avatar\Module',
'adminPermission' => 'admin',
]
]
```

Now place the included widget where you want to display the avatar.

```php


<?= \eseperio\avatar\widgets\Avatar::widget([
'avatarId' => Yii::$app->user->id
]) ?>


```

##### Advanced configuration

|Param|Default|Description|
|-----|-------|-----------|
|userComponent|`'user'`|  component to be used when generating avatar id. Ignored if $avatarFilename is a closure|
|defaultImage|`false`|array the path to default image|
|createDirectories|`true`|  whether create the target directories if they do not exists.|
|thumbWidth|`250`|  size of thumbnail size|
|thumbHeight|`250`|  size of thumbnail size|
|outputFormat|`2` (jpeg)| Format for generated images
|keepOriginal|`true`|  whether keep the original uploaded file|
|originalSuffix|`'or'`|  suffix to be appended to original files. If keep original enabled|
|uploadDir|`'@app/uploads'`|  directory to store thumbs generated without trailing slash. You can set a non web visible folder and get the pictures via link to `['/avatar/default/picture','id'=> $id ]`.|
|thumbsDir|`'@app/images/thumbs'`|  directory where the files will be uploaded without trailing slash|
|attributeName|`'image'`|  name of the attribute to be used on forms|
|imageValidator|see code|  name of the attribute to be used on forms validator to be used for image uploaded|
|mimeTypes|see code| list of allowed mimetypes|
|glue|`'_'`|  to be used when joining avatar name parts|
|adminPermission|`null`|  users with this permissions will be able to update avatars from other users.|
## Events

There are available some events.

| Event | Description |
|-------|-------------|
|`UploadEvent::EVENT_AFTER_UPLOAD`| Triggered just after saving original image. Use this event to generate thumbnails in other sizes.


## JqueryPlugin

This module includes a custom made jquery plugin to manage the upload process.
You can configure it via widget through `pluginOptions`

There are many events available in the plugin. All events must return a boolean
and have access to all the params of the parent function. See code to know more.

#### Available events in jQuery plugin
|Name|Description|
|----|-----------|
|beforeUpload|Triggered on the beforeSend event|
|afterUpload|Triggered when ajax response is full ok (status code and server response)|
|onFail|Triggered when status code is 200 but server response is not ok|
|onAjaxFail|Triggered when communication with server fails|

