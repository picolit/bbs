$(document).ready(function(){

    window.onerror = errorHandler();

    setConditionSelector();

    var replyId = $("input[name='parent_id']").val();
    if (replyId !== '0') {
        replyArticleShow(replyId);
    }

    // エロイネ押下時
    $(".nice-btn").on("click", function() {
        var $niceLink = $(this).find('a');
        var id = $(this).data('id');
        var $article =  $('#id' + id);
        var $articleFooter = $article.find('.article-footer');
        var $niceBtn = $articleFooter.find('.nice-btn');
        var $niceCount = $articleFooter.find('.nice-count span');

        $niceBtn.text('エロイイネ済');
        $niceCount.text(parseInt($niceCount.text()) + 1);

        $.ajax({
            type: "post",
            url: $niceLink.data('url'),
            data: "_token=" + $("input[name='_token']").attr('value'),
            success: function() {
                // ignore
            }
        })
    });

    // 投稿ボタン押下時
    $('#post').on('click', function() {
        $(this).hide();
        //$("#myForm").submit();
        postSubmit();
    });

    // 返信ボタン押下時
    $('.reply>a').on('click', function() {
        // 返信記事をトップへ表示
        var id = $(this).data("id");
        replyArticleShow(id);
    });

    // キャンセルボタン押下
    $('.post-cancel-btn').on('click', function() {
        window.location = '/';
    });
});

/**
 * 返信ボタン押下
 * @param id 親id
 */
function replyArticleShow(id) {
    var article = "#id" + id;
    var $replyArticle = $("#reply-article");
    $replyArticle.children().remove();
    $replyArticle.append($(article).clone());

    // タイトル設定
    var replayTitle = "Re: " + ($(article).find('.article-title').text());
    $(".post-form").find("input[name=title]").val(replayTitle);

    // hiddenのidを変更
    $("input[name='parent_id']").val(id);

    $('body, html').animate({ scrollTop: 0 }, 500);
    $('.post-title').text("返 信");
    $('.post-cancel-btn').show();
}

/**
 * サムネイル生成
 * @param form
 * @param canvas
 * @param num
 * @returns {Function}
 */
function thumbnailCreate(form, canvas, num) {
    return function(ev) {
        var file = form.files[0];
        var image = new Image();
        var reader = new FileReader();
        var minSize = 1024;

        if (file.type.match(/image.*/)) {
            reader.onloadend = function() {
                image.onload = function() { // 画像が読み込めた時の処理
                    var ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    var size = 100;
                    if (minSize <= image.width) {
                        size = parseInt(image.width / minSize);
                    }

                    var w = parseInt(image.width / size);
                    var h = parseInt(image.height / size);

                    console.log("元々のサイズ:" + image.width + "×" + image.height);
                    console.log("縮小後のサイズ:" + w + "×" + h);

                    canvas.width = w;
                    canvas.height = h;
                    ctx.drawImage(image, 0, 0, w, h);

                    // 縮小画像を表示
                    var img = document.createElement('img');
                    img.src = canvas.toDataURL();
                    img.width = 200;
                    document.querySelector('#thumbnail' + num).appendChild(img);
                }
                image.src = reader.result;
            }
            reader.readAsDataURL(file);
        }
    }
};

var captureForm1 = document.querySelector('#file1');
var canvas1 = document.querySelector('#canvas1');
canvas1.width = canvas1.height = 0;
captureForm1.addEventListener('change', thumbnailCreate(captureForm1, canvas1, 1), true);

var captureForm2 = document.querySelector('#file2');
var canvas2 = document.querySelector('#canvas2');
canvas2.width = canvas2.height = 0;
captureForm2.addEventListener('change', thumbnailCreate(captureForm2, canvas2, 2), true);

/**
 * article削除
 * @param id
 */
function articleDelete(id) {
    var password = prompt("パスワードを入力してください。", "");

    if (password) {
        location.href = 'delete/'+id+'/'+password
    }
}

function setConditionSelector()
{
    var vars = [], max = 0, hash = "", array = "";
    var url = window.location.search;

    //?を取り除くため、1から始める。複数のクエリ文字列に対応するため、&で区切る
    hash  = url.slice(1).split('&');
    max = hash.length;
    for (var i = 0; i < max; i++) {
        array = hash[i].split('=');    //keyと値に分割。
//        console.log(array[0], array[1]);

        if ('sex_s' === array[0] || 'age_s' === array[0] || 'prefectures_s' === array[0] || 'area_s' === array[0]) {
            $('select[name=' + array[0] + ']').val(array[1]);
        }

    }
}

/**
 * 投稿submit
 */
function postSubmit() {
    var blob1 = base64ToBlob(canvas1.toDataURL());
    var blob2 = base64ToBlob(canvas2.toDataURL());
    sendImageBinary(blob1, blob2);
}

/**
 * サーバへpost
 * @param blob1
 * @param blob2
 * @return void
 */
var sendImageBinary = function(blob1, blob2) {
    var formData = new FormData();
    formData.append('parent_id', document.querySelector('input[name="parent_id"]').value);
    formData.append('name', document.querySelector('input[name="name"]').value);
    formData.append('title', document.querySelector('input[name="title"]').value);
    formData.append('body', document.querySelector('#body').value);
    formData.append('sex', document.querySelector('#sex').value);
    formData.append('age', document.querySelector('#age').value);
    formData.append('prefectures', document.querySelector('#prefectures').value);
    formData.append('mail', document.querySelector('input[name="mail"]').value);
    formData.append('password', document.querySelector('input[name="password"]').value);
    $.each($('.interests-parts input[type="checkbox"]'), function() {
        if ($(this).prop('checked')) {
            formData.append($(this).attr('id'), $(this).val());
        }
    });

    if (0 < blob1.size) {
        formData.append('file1', blob1);
    }
    if (0 < blob2.size) {
        formData.append('file2', blob2);
    }

    formData.append('_token', document.querySelector('input[name="_token"]').value)
    $.ajax({
        type: 'POST',
        url: '/',
        data: formData,
        contentType: false,
        processData: false,
        success:function(date, dataType){
            location.href = '/';
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            //console.log(JSON.parse(XMLHttpRequest.responseText));
            $('.input').each(function(idx, val) {
                $(this).removeClass(('error'));
            });

            $.each(JSON.parse(XMLHttpRequest.responseText), function(key, val) {
                //console.log(key, val);
                $('#' + key).addClass('error');
            })

            $('#post').show();
        }
    });
};

/**
 * 引数のBase64の文字列をBlob形式にしている
 * @param base64
 * @returns {Blob|*}
 */
var base64ToBlob = function(base64){
    var base64Data = base64.split(',')[1], // Data URLからBase64のデータ部分のみを取得
        data = window.atob(base64Data), // base64形式の文字列をデコード
        buff = new ArrayBuffer(data.length),
        arr = new Uint8Array(buff),
        blob, i, dataLen;

    // blobの生成
    for( i = 0, dataLen = data.length; i < dataLen; i++){
        arr[i] = data.charCodeAt(i);
    }
    blob = new Blob([arr], {type: 'image/png'});
    return blob;
}

/**
 * errorHandler
 * @returns {Function}
 */
function errorHandler () {
    return function(msg, url, line, col, error) {
        var formData = new FormData();
        formData.append('msg', msg);
        formData.append('url', url);
        formData.append('line', line);
        formData.append('col', col);
        // formData.append('error', error);
        formData.append('_token', document.querySelector('input[name="_token"]').value)

        $.ajax({
            type: "post",
            url: '/error',
            data: formData,
            contentType: false,
            processData: false,
            success: function() {
                // ignore
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(XMLHttpRequest);
            }
        });
    }
}