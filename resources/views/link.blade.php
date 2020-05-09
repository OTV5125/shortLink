<html prefix="og: //ogp.me/ns#">
<head>
    @if(isset($meta))
        <title><?=$meta->title?></title>
        <meta property="og:title" content="<?=$meta->title?>" />
        <meta property="og:description" content="<?=$meta->description?>" />
        <meta property="og:url" content="<?=$meta->url?>" />
        <meta property="og:image" content="<?=asset('storage/'.$meta->image)?>" />
        <script>
                let link = '<?=$meta->url?>';
                let RegExp = /^((ftp|http|https):\/\/)/;
                if(!RegExp.test(link)){
                    link = '//'+link;
                }
            window.location.href = link;
        </script>
    @else
    Данная ссылка неизвестна
    @endif
</head>
</html>


