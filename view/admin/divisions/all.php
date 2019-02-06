<div class="container box white z-depth-2">

    <div class="right-align">
        <a class="btn waves-effect waves-light" href="<?=$_DATA['new_href']?>"><?=$_LANG['divisions']['new']['title']?></a>
    </div>

    <? if (!empty($_DATA['divisions']) && is_array($_DATA['divisions'])) { ?>
        <div class="table">
            <div class="row title">
                <div class="col offset-s1 s11 m5"><?=$_LANG['divisions']['name']?></div>
                <div class="col offset-s2 s10 m7"><?=$_LANG['divisions']['description']?></div>
            </div>
            <? foreach ($_DATA['divisions'] as $division) { ?>
                <div class="row">
                    <a class="no-link" href="<?=$division['division_href']?>">
                        <div class="col offset-s1 s11 m5"><?=$division['division_name']?></div>
                        <div class="col offset-s2 s10 m7"><?=$division['division_description']?></div>
                    </a>
                </div>
            <? } ?>
        </div>
    <? } ?>

</div>