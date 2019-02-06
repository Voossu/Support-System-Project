<div class="container box white z-depth-2">

    <div class="row right-align">
        <a class="btn waves-effect waves-light" href="<?=$_DATA['all']['href']?>"><?=$_DATA['all']['title']?></a>
    </div>

    <form class="row valign-wrapper" action="<?=$_DATA['new_action']?>" method="<?=$_DATA['new_method']?>">
        <div class="input-field col s7 m10">
            <input type="number" id="<?=$_DATA['fields']['count']['name']?>" name="<?=$_DATA['fields']['count']['name']?>"
                   min="1" value="<?=$_DATA['fields']['count']['value']?>" autocomplete="off" required>
            <label for="login"><?=$_LANG['invites']['new']['count']?></label>
        </div>
        <button type="submit" class="btn col s5 m2 waves-effect waves-light"><?=$_LANG['invites']['new']['submit_btn']?></button>
    </form>

    <? if (!empty($_DATA['new_invites']) && is_array($_DATA['new_invites'])) { ?>
        <div class="row title"><?=$_LANG['invites']['new']['created_invites']?></div>
            <? foreach ($_DATA['new_invites'] as $invite) { ?>
                <div class="row">
                    <?=$invite?>
                </div>
            <? } ?>
    <? } ?>

</div>