<div class="container box white z-depth-2">

    <? if (!empty($_DATA['menu'])) {
        ?><div class="menu tabs"><?
        foreach ($_DATA['menu'] as $item) {
            if ($item['select']) {
                ?><a class="tab col s3 select" href=""><?=$item['title']?></a><?
            } else {
                ?><a class="tab col s3" href="<?=$item['url']?>"><?=$item['title']?></a><?
            }
        }
        ?></div><?
    } ?>

    <div class="row title">
        <?=$_LANG['users']['details']['user_info']?>
    </div>
    <div class="row">
        <div class="col s12 m4 l3"><?=$_LANG['users']['register_field']?></div>
        <div class="col offset-s2 s10 m8 l9"><?=$_DATA['user']['user_register']?></div>
    </div>
    <div class="row">
        <div class="col s12 m4 l3"><?=$_LANG['users']['update_field']?></div>
        <div class="col offset-s2 s10 m8 l9"><?=$_DATA['user']['user_update']?></div>
    </div>
    <div class="row">
        <div class="col s12 m4 l3"><?=$_LANG['users']['level_field']?></div>
        <div class="col offset-s2 s10 m8 l9"><?=$_LANG['users']['levels'][$_DATA['user']['user_level']-1]?></div>
    </div>

    <div class="row title">
        <?=$_LANG['users']['details']['invite_info']?>
    </div>
    <? if (empty($_DATA['invite'])) { ?>
        <?=$_LANG['users']['details']['invite_not_found']?>
    <? } else { ?>
        <div class="row">
            <div class="col s12 m4 l3"><?=$_LANG['users']['details']['invite_issued_user']?></div>
            <div class="col offset-s2 s10 m8 l9"><?=$_DATA['invite']['get_user']?></div>
        </div>
        <div class="row">
            <div class="col s12 m4 l3"><?=$_LANG['users']['details']['invite_issued_date']?></div>
            <div class="col offset-s2 s10 m8 l9"><?=$_DATA['invite']['date']?></div>
        </div>
    <? } ?>

</div>