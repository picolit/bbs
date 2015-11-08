
<!DOCTYPE html>
<html>
<!-- MEMO: update me with `git checkout gh-pages && git merge master && git push origin gh-pages` -->
<head>
    <meta charset="utf-8">
    <title>Bootstrap Material</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/roboto.min.css" rel="stylesheet">
    <link href="dist/css/material-fullpalette.min.css" rel="stylesheet">
    <link href="dist/css/ripples.min.css" rel="stylesheet">
    <link href="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.css" rel="stylesheet">

    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular-resource.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.1/angular-route.min.js"></script>
    <script src="{{env('SITE_URL')}}assets/js/angular/service/articleService.js"></script>
    <script src="{{env('SITE_URL')}}assets/js/angular/service/constant.js"></script>
    <script src="{{env('SITE_URL')}}assets/js/angular/controller/articleController.js"></script>
    <script src="{{env('SITE_URL')}}assets/js/angular/route/route.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body{padding-top:50px}#banner{border-bottom:none}.page-header h1{font-size:4em}.bs-docs-section{margin-top:8em}.bs-component{position:relative}.bs-component .modal{position:relative;top:auto;right:auto;left:auto;bottom:auto;z-index:1;display:block}.bs-component .modal-dialog{width:90%}.bs-component .popover{position:relative;display:inline-block;width:220px;margin:20px}#source-button{position:absolute;top:0;right:0;z-index:100;font-weight:bold;padding: 5px 10px;}.progress{margin-bottom:10px}footer{margin:5em 0}footer li{float:left;margin-right:1.5em;margin-bottom:1.5em}footer p{clear:left;margin-bottom:0}.splash{padding:4em 0 0;background-color:#141d27;color:#fff;text-align:center}.splash h1{font-size:4em}.splash #social{margin:2em 0}.splash .alert{margin:2em 0}.section-tout{padding:4em 0 3em;border-bottom:1px solid rgba(0,0,0,0.05);background-color:#eaf1f1}.section-tout .fa{margin-right:.5em}.section-tout p{margin-bottom:3em}.section-preview{padding:4em 0 4em}.section-preview .preview{margin-bottom:4em;background-color:#eaf1f1}.section-preview .preview .image{position:relative}.section-preview .preview .image:before{box-shadow:inset 0 0 0 1px rgba(0,0,0,0.1);position:absolute;top:0;left:0;width:100%;height:100%;content:"";pointer-events:none}.section-preview .preview .options{padding:1em 2em 2em;border:1px solid rgba(0,0,0,0.05);border-top:none;text-align:center}.section-preview .preview .options p{margin-bottom:2em}.section-preview .dropdown-menu{text-align:left}.section-preview .lead{margin-bottom:2em}@media (max-width:767px){.section-preview .image img{width:100%}}.sponsor{text-align:center}.sponsor a:hover{text-decoration:none}@media (max-width:767px){#banner{margin-bottom:2em;text-align:center}}
        .infobox .btn-sup { color: rgba(0,0,0,0.5); font-weight: bold; font-size: 15px; line-height: 30px; }
        .infobox .btn-sup img { opacity: 0.5; height: 30px;}
        .infobox .btn-sup span { padding-left: 10px; position: relative; top: 2px; }
        .icons-material .row { margin-bottom: 20px; }
        .icons-material .col-xs-2 { text-align: center; }
        .icons-material i { font-size: 34pt; }

        .icon-preview {
            display: inline-block;
            padding: 10px;
            margin: 10px;
            background: #D5D5D5;
            border-radius: 3px;
            cursor: pointer;
        }
        .icon-preview span {
            display: none;
            position: absolute;
            background: black;
            color: #EEE;
            padding: 5px 8px;
            font-size: 15px;
            font-family: Roboto;
            border-radius: 2px;
            z-index: 10;
        }
        .icon-preview:hover i { color: #4285f4; }
        .icon-preview:hover span { display: block; cursor: text; }

    </style>
</head>
<body>

<div class="container">

    {{-- 解説: 'app/views/partials/footer.blade.php' の内容をこの箇所に展開します。 --}}
    {{--@include ('partials.footer') --}}
    {{-- left content --}}
    {{--@include('parts/header')--}}
    @yield ('content')
    {{--@include('parts/footer')--}}

</div>
<br>

<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script>
    (function(){

        var $button = $("<div id='source-button' class='btn btn-primary btn-xs'>&lt; &gt;</div>").click(function(){
            var index =  $('.bs-component').index( $(this).parent() );
            $.get(window.location.href, function(data){
                var html = $(data).find('.bs-component').eq(index).html();
                html = cleanSource(html);
                $("#source-modal pre").text(html);
                $("#source-modal").modal();
            })

        });

        $('.bs-component [data-toggle="popover"]').popover();
        $('.bs-component [data-toggle="tooltip"]').tooltip();

        $(".bs-component").hover(function(){
            $(this).append($button);
            $button.show();
        }, function(){
            $button.hide();
        });

        function cleanSource(html) {
            var lines = html.split(/\n/);

            lines.shift();
            lines.splice(-1, 1);

            var indentSize = lines[0].length - lines[0].trim().length,
                    re = new RegExp(" {" + indentSize + "}");

            lines = lines.map(function(line){
                if (line.match(re)) {
                    line = line.substring(indentSize);
                }

                return line;
            });

            lines = lines.join("\n");

            return lines;
        }

        $(".icons-material .icon").each(function() {
            $(this).after("<br><br><code>" + $(this).attr("class").replace("icon ", "") + "</code>");
        });

    })();

</script>
<script src="dist/js/ripples.min.js"></script>
<script src="dist/js/material.min.js"></script>
<script src="//fezvrasta.github.io/snackbarjs/dist/snackbar.min.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/noUiSlider/6.2.0/jquery.nouislider.min.js"></script>
<script>
    $(function() {
        $.material.init();
        $(".shor").noUiSlider({
            start: 40,
            connect: "lower",
            range: {
                min: 0,
                max: 100
            }
        });

        $(".svert").noUiSlider({
            orientation: "vertical",
            start: 40,
            connect: "lower",
            range: {
                min: 0,
                max: 100
            }
        });
    });
</script>
</body>
</html>
