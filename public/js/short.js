(function () {

    var Short = function (classNode) {
        this.block = $(classNode);
        this.url = this.block.find('.url__js');
        this.title = this.block.find('.title__js');
        this.description= this.block.find('.description__js');
        this.image = this.block.find('.image__js');
        this.save = this.block.find('.save__js');
        this.ajax = new Ajax();
        this.init();
    };

    Short.prototype = {


        init: function () {
            this.save.on('click', this.btnSave.bind(this));
        },

        btnSave: function(){
            let validate = this.validate();

            if(validate){
                let fd = new FormData();
                let files = this.image[0].files[0];
                fd.append('_token', $('meta[name="csrf-token"]').attr('content'));
                fd.append('image',files);
                fd.append('url', this.url.val());
                fd.append('title', this.title.val());
                fd.append('description', this.description.val());
                this.ajax.post('addUrl', fd, function (result) {
                    if(result.status === 'success'){
                        this.createLinkBlock(result.code);
                        this.url.val();
                        this.title.val();
                        this.description.val();
                        this.image.val();
                    }else{
                        console.log(result)
                        let str = '';
                        $.each(result, function( key, value ) {
                            str += value+'<br>';
                        });
                        this.sendError(this.save, str);
                    }
                }.bind(this));
            }
        },

        createLinkBlock: function(code){
            let block =  $('.before-link').first();
            let count = $('.block-before-links').children().length;
            let urlCode = window.location.href + code;
            let RegExp = /^((ftp|http|https):\/\/)/;
            let link = '';
            if(RegExp.test(this.url.val())){
                link = this.url.val();
            }else{
                link = '//'+this.url.val();
            }
            count = count - 1;
            block = block.clone().appendTo('.block-before-links');
            block.find('.links-title__js').text(this.title.val()+' №'+count);
            block.find('.links-url__js').html('<a href="'+link+'">'+this.url.val()+'</a>');
            block.find('.links-code__js').html('<a href="'+urlCode+'">'+urlCode+'</a>');
        },

        validate: function () {
            var RegExp = /^((ftp|http|https):\/\/)?(www\.)?([A-Za-zА-Яа-я0-9]{1}[A-Za-zА-Яа-я0-9\-]*\.?)*\.{1}[A-Za-zА-Яа-я0-9-]{2,8}(\/([\w#!:.?+=&%@!\-\/])*)?/;
            if(RegExp.test(this.url.val())) this.sendError(this.url, false);
            else this.sendError(this.url, 'неправильно введена ссылка');

            if(this.title.val() !== "") this.sendError(this.title, false);
            else this.sendError(this.title, 'не введен заголовок');

            if(this.description.val() !== "") this.sendError(this.description, false);
            else this.sendError(this.description, 'не введено описание');

            let img = this.image.val();
            let extension = img.split('.').pop().toUpperCase();

            if(img.length < 1) {
                this.sendError(this.image, 'не найдено изображение');
            }
            else if (extension!="PNG" && extension!="JPG" && extension!="GIF" && extension!="JPEG"){
                this.sendError(this.image, 'расширение должно быть "png, jpg, gif, jpeg, bpm"');
            }
            else {
                this.sendError(this.image, false);
            }

            this.sendError(this.save, false);
            return (this.block.find('.error').length>0)?false:true;
        },

        sendError: function (node, text) {
            if(text === false) node.parent().css('color', '').find('.error').remove();
            else{
                if(node.parent().find('.error').length === 0){
                    node.parent().append('<span class="error">'+text+'</span>').css('color', 'red');
                }
            }
        }
    }

    if (!window.Short) window.Short = Short;
})();