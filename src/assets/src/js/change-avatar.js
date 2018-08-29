$(document).on('change', '#change-avatar', function (e) {
    var o = $(this),
        cont = $(".profile-avatar");

    var formData = new FormData();
    formData.append('avatar', o[0].files[0]);
    $.ajax({
        url: avatarUrl,
        data: formData,
        type: 'POST',
        contentType: false,
        processData: false,
        beforeSend: function () {
            cont.addClass('loading')
        }
    }).done(function (data) {
        if (data.success) {
            var img = $("#avatar-image"),
                src = img.attr('src'),
                newSrc = src.split("?")[0];

            img.attr('src', newSrc + '?' + Math.random())


        } else {
            alert(data.error);
        }
        cont.removeClass('loading');
    }).fail(function () {
        cont.removeClass('loading');
        alert('A problem ocurred updating your profile picture')
    });
});