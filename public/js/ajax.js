(function () {

    var Ajax = function () {

    };

    Ajax.prototype = {


        init: function () {

        },


        post: function (url, data, callback) {
            $.ajax({
                type: 'post',
                url: url,
                data: data,
                dataType: 'html',
                contentType: false,
                processData: false,
                success: function (response) {
                    callback(response);
                }
            });
        },
    }

    if (!window.Ajax) window.Ajax = Ajax;
})();