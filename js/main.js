/**
 * Created by anikulchin on 3/18/15.
 */
oFReader = new FileReader();

var menu = [{
    name: 'delete',
    //img: 'images/create.png',
    title: 'delete image',
    fun: function () {
        console.log(target);
        var src = target.src;
        target.src = 'ico/undo.png';
        target.parentNode.onclick = function () {
            target.src = src;
            $.ajax({
                url: "ajax/undelete/" + id,
                type: "GET"
            });
            return false;
        };

        $.ajax({
            url: "ajax/delete/" + id,
            type: "GET"
        });

        setTimeout(function () {
                if (target.src != src)
                    target.remove();
            },
            3000);
    }
},
    {
        name: 'update',
        //img: 'images/update.png',
        title: 'update button',
        fun: function () {
            alert('i am update button')
        }
    }];
var id = null;
var target = null;
//Calling context menu
console.log("Loading menu\n");
$('.dashboard').contextMenu(menu,{  triggerOn:'contextmenu',
                                    onOpen: function(data,event)
                                            {
                                                id = event.target.id;
                                                target = event.target;
                                            }
                                    }
                            );

$(function() {
    $("#fileToUpload").change(function (){
    //$('input[type=file]').change(function (){
        console.log("Starting form POST...\n");
        var form = this.form;
        var form_name = ($(form).attr('name'));
        if (form_name == "file")
            var fd = new FormData($('form')[0]);
        else
            var fd = new FormData($('form')[1]);

        //console.log($('form[name="camera"]'));
        //console.log($('form'[0]) );
        //var fd = new FormData($("#camera"));
        //console.log(fd);
        console.log(form_name);
        fd.append("label", "WEBUPLOAD");
        $.ajax({
            url: "ajax/upload",
            type: "POST",
            data: fd,
            enctype: 'multipart/form-data',
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            dataType: "json"
        }).done(function( data ) {
            console.log("PHP Output:");
            console.log( data );
            console.log(data.path);
            var f = $('.dashboard').children().last().clone();
            f.attr("href",data.path);
            f.show();
            var img = f.children().first();
            img.attr("src",data.thumbnail);
            img.attr("id",data.imageId);
            $('.dashboard').prepend(f);
        });
    });

    $("#f2").change(function (){
        var $this = $(this);
        if (typeof this.files[0] === 'undefined') {return false; }

        jQuery.each($("#f2")[0].files, function(i, file) {
                var fd = new FormData();
                fd.append('fileToUpload',file);
                fd.append("label", "WEBUPLOAD");
            $.ajax({
                url: "ajax/upload",
                type: "POST",
                data: fd,
                enctype: 'multipart/form-data',
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                dataType: "json"
            }).done(function( data ) {
                console.log("PHP Output:");
                console.log( data );
                var f = $('.dashboard').children().first().clone();
                f.attr("href",data.path);
                f.show();
                var img = f.children().last();
                img.attr("src",data.thumbnail);
                img.attr("id",data.imageId);
                $('.dashboard').prepend(f);
            });
        });
    });
});