$(document).ready(function(){

    var replyId = $("input[name='parent_id']").val();
    if (replyId !== '0') {
        replyArticleShow(replyId);
    }

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
        $("#myForm").submit();
    });

    // 返信ボタン押下時
    $('.reply>a').on('click', function() {
        // 返信記事をトップへ表示
        var id = $(this).data("id");
        replyArticleShow(id);
    });

    // キャンセルボタン押下
    $('.post-cancel-btn').on('click', function() {
        //$('.post-title').text("新規投稿");
        //// hiddenのidを変更
        //$("input[name='parent_id']").val(0);
        //var $replyArticle = $("#reply-article");
        //$replyArticle.children().remove();
        //$(this).hide();
        window.location = '/';
    });

    // 添付画像サムネイル
    document.getElementById('file1').addEventListener('change', handleFileSelect1, false);
    document.getElementById('file2').addEventListener('change', handleFileSelect2, false);
});

function replyArticleShow(id) {
    var article = "#id" + id;
    var $replyArticle = $("#reply-article");
    $replyArticle.children().remove();
    $replyArticle.append($(article).clone());

    // hiddenのidを変更
    $("input[name='parent_id']").val(id);

    $('body, html').animate({ scrollTop: 0 }, 500);
    $('.post-title').text("返 信");
    $('.post-cancel-btn').show();
}

function handleFileSelect1(evt) {
    var f = evt.target.files[0]; // FileList object
        // Only process image files.
        if (!f.type.match('image.*')) {
            return
        }

        var reader = new FileReader();
        // Closure to capture the file information.
        reader.onload = (function(theFile) {
            return function(e) {
                // Render thumbnail.
                var span = document.createElement('span');
                span.innerHTML = ['<img class="thumb" src="', e.target.result,
                    '" title="', escape(theFile.name), '"/>'].join('');
                document.getElementById('thumbnail1').insertBefore(span, null);
            };
        })(f);

        // Read in the image file as a data URL.
        reader.readAsDataURL(f);
}
function handleFileSelect2(evt) {
    var f = evt.target.files[0]; // FileList object
    // Only process image files.
    if (!f.type.match('image.*')) {
        return
    }

    var reader = new FileReader();
    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {
            // Render thumbnail.
            var span = document.createElement('span');
            span.innerHTML = ['<img class="thumb" src="', e.target.result,
                '" title="', escape(theFile.name), '"/>'].join('');
            document.getElementById('thumbnail2').insertBefore(span, null);
        };
    })(f);

    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
}

function articleDelete(id) {
    var password = prompt("パスワードを入力してください。", "");

    if (password) {
        location.href = 'delete/'+id+'/'+password
    }
}