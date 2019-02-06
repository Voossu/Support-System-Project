<nav>
    <div class="container">
        <div class="nav-wrapper blue">
            <div class="brand-logo"><?=$_DATA['title']?></div>
            <a data-activates="mobile-menu" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <? if (!empty($_MENU)) {
                    foreach ($_MENU as $item) {
                        if ($item['select']) {
                            ?> <li><a class="blue darken-2" href="<?=$item['url']?>"><?=$item['title']?></a></li> <?
                        } else {
                            ?> <li><a href="<?=$item['url']?>"><?=$item['title']?></a></li> <?
                        }
                    }
                } ?>
            </ul>
            <ul class="side-nav" id="mobile-menu">
                <? if (!empty($_MENU)) {
                    foreach ($_MENU as $item) {
                        if ($item['select']) {
                            ?> <li><a class="grey lighten-3" href="<?=$item['url']?>"><?=$item['title']?></a></li> <?
                        } else {
                            ?> <li><a href="<?=$item['url']?>"><?=$item['title']?></a></li> <?
                        }
                    }
                } ?>
            </ul>
        </div>
    </div>
</nav>
<?=$_DATA['content']?>
<script>
    $( document ).ready(function(){
        $(".dropdown-button").dropdown();
        $(".button-collapse").sideNav();
    })
</script>
