<div class="container box white z-depth-2">

    <form class="row valign-wrapper" action="<?=$_DATA['search']['handler']?>" method="<?=$_DATA['search']['method']?>">
        <div class="input-field col s10 offset-m7 m4">
            <input type="text" id="<?=$_DATA['search']['field']?>" name="<?=$_DATA['search']['field']?>" autocomplete="off">
            <label for="<?=$_DATA['search']['field']?>"><?=$_LANG['users']['users']['search']?></label>
        </div>
        <button type="submit" class="col s2 m1 btn waves-effect waves-light">
            <i class="material-icons prefix">search</i>
        </button>
    </form>

    <? if (!empty($_DATA['users']) && is_array($_DATA['users'])) { ?>
        <div class="table">
            <div class="row title">
                <div class="col s12 m3"><?=$_LANG['users']['email_field']?></div>
                <div class="col offset-s2 s10 m4"><?=$_LANG['users']['fullname_field']?></div>
                <div class="col offset-s2 s10 m2"><?=$_LANG['users']['level_field']?></div>
                <div class="col offset-s2 s10 m3"><?=$_LANG['users']['post_field']?></div>
            </div>
            <? foreach ($_DATA['users'] as $user) { ?>
                <div class="row">
                    <a class="no-link" href="<?=$user['user_profile_href']?>">
                    <div class="col s12 m3">&lt;<?=$user['user_email']??"-"?>&gt;</div>
                    <div class="col offset-s2 s10 m4"><?=empty($user['user_fullname']) ? "-" : $user['user_fullname']?></div>
                    <div class="col offset-s2 s10 m2"><?=empty($user['user_level']) ? "-" : $user['user_level']?></div>
                    <div class="col offset-s2 s10 m3"><?=empty($user['user_work']) ? "-" : $user['user_work']?></div>
                    </a>
                </div>
            <? } ?>
        </div>
    <? } ?>

    <? if (!empty($_DATA['pages'])) { ?>
        <ul class="row pagination center-align">
            <? if ($_DATA['pages']['left']['disabled']) { ?>
                <a><li class="disabled"><i class="material-icons">chevron_left</i></li></a>
            <? } else { ?>
                <a href="<?=$_DATA['pages']['left']['href']?>"><li class="waves-effect waves-blue"><i class="material-icons">chevron_left</i></li></a>
            <? } ?>
            <? foreach ($_DATA['pages']['list'] as $page) { ?>
                <? if ($page['active']) { ?>
                    <a><li class="active blue"><?=$page['number']?></li></a>
                <? } else { ?>
                    <a href="<?=$page['href']?>"><li class="waves-effect waves-blue"><?=$page['number']?></li></a>
                <? } ?>
            <? } ?>
            <? if ($_DATA['pages']['right']['disabled']) { ?>
                <a><li class="disabled"><i class="material-icons">chevron_right</i></li></a>
            <? } else { ?>
                <a href="<?=$_DATA['pages']['right']['href']?>"><li class="waves-effect waves-blue"><i class="material-icons">chevron_right</i></li></a>
            <? } ?>
        </ul>
    <? } ?>

</div>