# yii2-avatar
**IMPORTANT, THIS IS WIP.**

Module to upload custom avatar picture

The intention of this library is add the ability to upload a profile picture via a simple widget.

It must not be dependent from another user management library.



## Usage


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

