$(document).ready(function(){
    $(".nice-btn").on("click", function() {
        var $nice = $(this);
        var $niceLink = $(this).find('a');
        var $niceCnt = $(this).find('.nice-count');
        $.ajax({
            type: "post",
            url: $niceLink.data('url'),
            data: "_token=" + $("input[name='_token']").attr('value'),
            success: function() {
                var count = parseInt($niceCnt.text());
                $nice.empty().add('<span>').text('エロいいね済 '+(count + 1)+'人がエロイイネと言っています。').css('color', '#7f7f7f');
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
        var article = "#id" + id;
        var $replyArticle = $("#reply-article");
        $replyArticle.children().remove();
        $replyArticle.append($(article).clone());

        // hiddenのidを変更
        $("input[name='parent_id']").val(id);

        $('body, html').animate({ scrollTop: 0 }, 500);
        $('.post-title').text("返 信");
        $('.post-cancel-btn').show();
    });

    // キャンセルボタン押下
    $('.post-cancel-btn').on('click', function() {
        $('.post-title').text("新規投稿");
        // hiddenのidを変更
        $("input[name='parent_id']").val(0);
        var $replyArticle = $("#reply-article");
        $replyArticle.children().remove();
        $(this).hide();
    });

    // 添付画像サムネイル
    document.getElementById('file1').addEventListener('change', handleFileSelect1, false);
    document.getElementById('file2').addEventListener('change', handleFileSelect2, false);
});

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
