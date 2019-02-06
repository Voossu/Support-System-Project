<!DOCTYPE html>
<html lang="<?=$_ROUTING['lang']?>">
<head>
    <meta charset="UTF-8">
    <title><?=$_DATA['title']?></title>
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="<?=RES_URL."css/style.css"?>" type="text/css" rel="stylesheet" media="screen,projection">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
    <?=$_DATA['content']?>
    <script src="<?=RES_URL."js/materialize.js"?>"></script>
</body>
</html>