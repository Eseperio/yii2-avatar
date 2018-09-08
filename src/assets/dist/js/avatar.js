'use strict';

(function ($) {

    jQuery.fn.yii2avatar = function (options) {

        var defaults = {
            url: '/',
            attributeName: 'avatar',
            i18n: {
                deleteMsg: 'Are you sure you want to remove the avatar?'
            }
        };

        var settings = $.extend({}, defaults, options);

        var BEFORE_UPLOAD = "beforeUpload";
        var AFTER_UPLOAD = "afterUpload";
        var FAIL = "onFail";
        var AJAX_FAIL = 'onAjaxFail';
        /**
         *  Main Xenon Gantt class
         */
        var avatar = {
            _el: null,
            init: function init(el) {
                this._el = el;
                this.attachEvents();
            },
            get: function get(query) {
                return this._el.find(query);
            },
            trigger: function trigger(event) {
                if (typeof settings[event] === "function") {
                    for (var _len = arguments.length, params = Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                        params[_key - 1] = arguments[_key];
                    }

                    return settings[event].apply(params);
                }
                return true;
            },
            attachEvents: function attachEvents() {
                var self = this;

                this._el.on('change', 'input[type="file"]', function (e) {
                    self.callback(e, 'update');
                });
                this._el.on('click', '.remove-avatar', function (e) {
                    if (confirm(settings.i18n.deleteMsg)) self.callback(e, 'delete');
                });
            },
            callback: function callback(e, action) {
                console.log(this);
                var self = this;
                var o = $(e.currentTarget);
                console.log(o);
                var formData = new FormData();
                if (action == 'update') {
                    formData.append(settings.attributeName, o[0].files[0]);
                }
                if (settings.avatarId) {
                    formData.append("avatarId", settings.avatarId);
                }

                $.ajax({
                    url: settings[action],
                    data: formData,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    beforeSend: function beforeSend(jqXHR, settings) {
                        self._el.addClass('loading');
                        return self.trigger(BEFORE_UPLOAD);
                    }
                }).done(function (data, textStatus, jqXHR) {
                    if (data.success) {
                        if (self.trigger(AFTER_UPLOAD, data, textStatus, jqXHR)) {
                            var img = self.get('.avatar-image'),
                                src = img.attr('src');
                            var glue = "?";
                            if (src.indexOf('?')) {
                                glue = "&";
                            }
                            var newSrc = src + glue + Math.random();

                            img.attr('src', newSrc + '?' + Math.random());
                        }
                    } else {
                        if (self.trigger(FAIL, data, textStatus, jqXHR)) {
                            alert(data.error);
                        }
                    }
                    self._el.removeClass('loading');
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    if (self.trigger(AJAX_FAIL, jqXHR, textStatus, errorThrown)) {
                        self._el.removeClass('loading');
                        alert('A problem ocurred updating your profile picture');
                    }
                });
            }
        };

        avatar.init(this);
        return this;
    };
})(jQuery);