<div class="container box white z-depth-2">

    <? if (!empty($_DATA['all_users_url'])) { ?>
        <div class="right-align">
            <a class="btn waves-effect waves-light" href="<?=$_DATA['all_users_url']?>"><?=$_LANG['users']['users']['go_to_users']?></a>
        </div>
    <? } ?>

    <? if (!empty($_DATA['user'])) { ?>
        <div class="row title">
            <?=$_LANG['users']['users']['overall_title']?>
        </div>
        <div class="row">
            <div class="col s12 m4 l3"><?=$_LANG['users']['fullname_field']?></div>
            <div class="col offset-s2 s10 m8 l9"><?=empty($_DATA['user']['user_fullname']) ? "-" : $_DATA['user']['user_fullname']?></div>
        </div>
        <div class="row">
            <div class="col s12 m4 l3"><?=$_LANG['users']['work_field']?></div>
            <div class="col offset-s2 s10 m8 l9"><?=empty($_DATA['user']['user_work']) ? "-" : $_DATA['user']['user_work']?></div>
        </div>
        <div class="row">
            <div class="col s12 m4 l3"><?=$_LANG['users']['level_field']?></div>
            <div class="col offset-s2 s10 m8 l9"><?=empty($_DATA['user']['user_level']) ? "-" : $_DATA['user']['user_level']?></div>
        </div>

        <div class="row title">
            <?=$_LANG['users']['users']['contact_title']?>
        </div>
        <div class="row">
            <div class="col s12 m4 l3"><?=$_LANG['users']['email_field']?></div>
            <div class="col offset-s2 s10 m8 l9"><?=$_DATA['user']['user_email']?></div>
        </div>
        <div class="row">
            <div class="col s12 m4 l3"><?=$_LANG['users']['phone_field']?></div>
            <div class="col offset-s2 s10 m8 l9"><?=empty($_DATA['user']['user_phone']) ? "-" : $_DATA['user']['user_phone']?></div>
        </div>
    <? } else { ?>
        <div class="row title center-align"><?=$_LANG['users']['users']['users_not_exist']?></div>
    <? } ?>
</div>