<div class="container box white z-depth-2">

    <div class="right-align">
        <a class="btn waves-effect waves-light" href="<?=$_DATA['new']['href']?>"><?=$_DATA['new']['title']?></a>
    </div>

    <? if (!empty($_DATA['invites']) && is_array($_DATA['invites'])) { ?>
        <div class="table">
            <div class="row title">
                <div class="col offset-s1 s12 m4 l3"><?=$_LANG['invites']['code']?></div>
                <div class="col offset-s2 s10 m4 l3"><?=$_LANG['invites']['date']?></div>
                <div class="col offset-s2 s10 m4 l6"><?=$_LANG['invites']['details']?></div>
            </div>
            <? foreach ($_DATA['invites'] as $invite) { ?>
                <? if (empty($invite['register_user'])) { ?>
                    <? if ($invite['invite_disabled']) { ?>
                        <div class="row red accent-1">
                            <div class="col offset-s1 s12 m4 l3"><?=$invite['invite_code']?></div>
                            <div class="col offset-s2 s10 m4 l3"><?=$invite['invite_date']?></div>
                            <div class="col offset-s2 s10 m4 l4">
                                <a href="<?=$invite['enable_url']?>">
                                    <?=$_LANG['invites']['enable']?>
                                </a>
                            </div>
                        </div>
                    <? } else { ?>
                        <div class="row amber accent-3">
                            <div class="col offset-s1 s12 m4 l3"><?=$invite['invite_code']?></div>
                            <div class="col offset-s2 s10 m4 l3"><?=$invite['invite_date']?></div>
                            <div class="col offset-s2 s10 m4 l4">
                                <a href="<?=$invite['disable_url']?>">
                                    <?=$_LANG['invites']['disable']?>
                                </a>
                            </div>
                        </div>
                    <? } ?>
                <? } else { ?>
                    <div class="row green accent-3">
                        <div class="col offset-s1 s12 m4 l3"><?=$invite['invite_code']?></div>
                        <div class="col offset-s2 s10 m4 l3"><?=$invite['invite_date']?></div>
                        <div class="col offset-s2 s10 m4 l4">
                            <a href="<?=$invite['register_user']['user_url']?>">
                                <?=$invite['register_user']['info']?>
                            </a>
                        </div>
                    </div>
                <? } ?>
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