<div class="card center short">
    <div class="card-head">
        <div class="card-title"></div>
    </div>
    <? if(!empty($_DATA['restore_errors']) && is_array($_DATA['restore_errors'])) { ?>
        <div class="card-errors">
            <? foreach ($_DATA['restore_errors'] as $error) { ?>
                <li><?=$error?></li>
            <? } ?>
        </div>
    <? } ?>
    <form action="<?=$_DATA['restore_action']?>" method="<?=$_DATA['restore_method']?>" novalidate>
        <div class="card-content">
            <div class="row">
                <div class="input-field col s12">
                    <input type="email" id="<?=$_DATA['fields']['email']['name']?>" name="<?=$_DATA['fields']['email']['name']?>"
                           maxlength="<?=$_DATA['fields']['email']['length']?>" length="<?=$_DATA['fields']['email']['length']?>"
                           value="<?=$_DATA['fields']['email']['value']?>" pattern="<?=$_CONFIG['regexp']['email']?>" autocomplete="off" required>
                    <label for="login"><?=$_LANG['users']['email_field']?></label>
                </div>
            </div>
        </div>
        <div class="card-action">
            <button type="submit" class="col s12 btn waves-effect waves-light"><?=$_LANG['users']['restore']['submit_btn']?></button>
            <a class="btn waves-effect waves-light blue-grey lighten-2" href="<?=HOME_URL."user/login/"?>"><?=$_LANG['users']['login']['title']?></a>
            <a class="btn waves-effect waves-light blue-grey lighten-2" href="<?=HOME_URL."user/register/"?>"><?=$_LANG['users']['register']['title']?></a>
        </div>
    </form>
</div>