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

    <div class="legends center-align">
        <div class="legend">
            <div class="mark green accent-3"></div>
            <div class="label"><?=$_LANG['users']['sessions']['active']?></div>
        </div>
        <div class="legend">
            <div class="mark grey lighten-2"></div>
            <div class="label"><?=$_LANG['users']['sessions']['timeout']?></div>
        </div>
        <div class="legend">
            <div class="mark yellow accent-2"></div>
            <div class="label"><?=$_LANG['users']['sessions']['disabled']?></div>
        </div>
    </div>

    <div class="table">
        <div class="title row">
            <div class="col s12 m4 center-align"><?=$_LANG['users']['sessions']['number']?> </div>
            <div class="col s12 m4 center-align"><?=$_LANG['users']['sessions']['start']?> </div>
            <div class="col s12 m4 center-align"><?=$_LANG['users']['sessions']['end']?> </div>
        </div>
        <? if (!empty($_DATA['sessions']) && is_array($_DATA['sessions'])) {
            foreach ($_DATA['sessions'] as $session) { ?>
                <div class="row <?=$session['session_disabled'] ? "yellow accent-2" : ($session['session_timeout'] ? "grey lighten-2" : "green accent-3")?>">
                    <div class="col s12 m4 center-align"><?=$session['session_id']?> </div>
                    <div class="col s12 m4 center-align"><?=$session['session_start']?> </div>
                    <div class="col s12 m4 center-align"><?=$session['session_end']?> </div>
                </div>
            <?  }
        } ?>
    </div>

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