(function ($) {

    jQuery.fn.yii2avatar = function (options) {

        let defaults = {
            url: '/',
            attributeName: 'avatar',
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
                return $this._el.find(query);
            },
            trigger: function (event, ...params) {
                if (typeof settings[event] === "function") {
                    return settings[event].apply(params);
                }
                return true;
            },
            attachEvents: function () {
                let self = this;
                let input = this.get('input[type="file"]');
                $(document).on('change', input, function (e) {
                    let o = $(this);
                    let formData = new FormData();
                    formData.append(settings.attributeName, o[0].files[0]);
                    $.ajax({
                        url: settings.url,
                        data: formData,
                        type: 'POST',
                        contentType: false,
                        processData: false,
                        beforeSend: function beforeSend(jqXHR, settings) {
                            self.el.addClass('loading');
                            return self.trigger(BEFORE_UPLOAD);

                        }
                    }).done(function (data, textStatus, jqXHR) {
                        if (data.success) {
                            if (self.trigger(AFTER_UPLOAD, data, textStatus, jqXHR)) {
                                let img = $("#avatar-image"),
                                    src = img.attr('src'),
                                    newSrc = src.split("?")[0];
                                img.attr('src', newSrc + '?' + Math.random());
                            }


                        } else {
                            if (self.trigger(FAIL, data, textStatus, jqXHR)) {
                                alert(data.error);
                            }
                        }
                        self.el.removeClass('loading');
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        if (self.trigger(AJAX_FAIL, jqXHR, textStatus, errorThrown)) {
                            self.el.removeClass('loading');
                            alert('A problem ocurred updating your profile picture');
                        }
                    });
                });
            }
        };

        avatar.init(this);
        return this;

    };

}(jQuery));