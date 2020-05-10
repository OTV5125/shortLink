<html prefix="og: //ogp.me/ns#">
<head>
    @if(isset($meta))
        <title><?=$meta['title']?></title>
        @foreach($meta AS $i => $item)
        <meta property="og:<?=$i?>" content="<?=$item?>" />
        @endforeach
        <script>
                let link = '<?=$meta['url']?>';
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


