(function ($) {

    jQuery.fn.yii2avatar = function (options) {

        let defaults = {
            url: '/',
            attributeName: 'avatar',
            i18n: {
                deleteMsg: 'Are you sure you want to remove the avatar?'
            }
        };

        let settings = $.extend({}, defaults, options);

        const BEFORE_UPLOAD = "beforeUpload";
        const AFTER_UPLOAD = "afterUpload";
        const FAIL = "onFail";
        const AJAX_FAIL = 'onAjaxFail';
        /**
         *  Main Xenon Gantt class
         */
        let avatar = {
            _el: null,
            init: function (el) {
                this._el = el;
                this.attachEvents();
            },
            get: function (query) {
                return this._el.find(query);
            },
            trigger: function (event, ...params) {
                if (typeof settings[event] === "function") {
                    return settings[event].apply(params);
                }
                return true;
            },
            attachEvents: function () {
                let self = this;

                this._el.on('change', 'input[type="file"]', function (e) {
                    self.callback(e, 'update')
                });
                this._el.on('click', '.remove-avatar', function (e) {
                    if (confirm(settings.i18n.deleteMsg))
                        self.callback(e, 'delete')
                });


            },
            callback: function (e, action) {
                console.log(this);
                let self = this;
                let o = $(e.currentTarget);
                console.log(o);
                let formData = new FormData();
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
                            let img = self.get('.avatar-image'),
                                src = img.attr('src');
                            let glue = "?";
                            if (src.indexOf('?')) {
                                glue = "&";
                            }
                            let newSrc = src + glue + Math.random();

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

}(jQuery));