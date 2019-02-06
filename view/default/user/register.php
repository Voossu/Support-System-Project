<div class="card center short">
    <div class="card-head">
        <div class="card-title"></div>
    </div>
    <? if(!empty($_DATA['register_errors']) && is_array($_DATA['register_errors'])) { ?>
        <div class="card-errors">
            <? foreach ($_DATA['register_errors'] as $error) { ?>
                <li><?=$error?></li>
            <? } ?>
        </div>
    <? } ?>
    <form action="<?=$_DATA['register_action']?>" method="<?=$_DATA['register_method']?>" novalidate>
        <div class="card-content">
            <div class="row">
                <div class="input-field col s12">
                    <input type="email" id="<?=$_DATA['fields']['email']['name']?>" name="<?=$_DATA['fields']['email']['name']?>"
                           maxlength="<?=$_DATA['fields']['email']['length']?>" length="<?=$_DATA['fields']['email']['length']?>"
                           value="<?=$_DATA['fields']['email']['value']?>" pattern="<?=$_CONFIG['regexp']['email']?>" autocomplete="off" required>
                    <label for="login"><?=$_LANG['users']['email_field']?></label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" id="<?=$_DATA['fields']['invite']['name']?>" name="<?=$_DATA['fields']['invite']['name']?>"
                           maxlength="<?=$_DATA['fields']['invite']['length']?>" length="<?=$_DATA['fields']['invite']['length']?>"
                           value="<?=$_DATA['fields']['invite']['value']?>" pattern="<?=$_CONFIG['regexp']['invite']?>" autocomplete="off" required>
                    <label for="password"><?=$_LANG['users']['invite_field']?></label>
                </div>
            </div>
        </div>
        <div class="card-action">
            <button type="submit" class="col s12 btn waves-effect waves-light"><?=$_LANG['users']['register']['submit_btn']?></button>
            <a class="btn waves-effect waves-light blue-grey lighten-2" href="<?=HOME_URL."user/login/"?>"><?=$_LANG['users']['login']['title']?></a>
            <a class="btn waves-effect waves-light blue-grey lighten-2" href="<?=HOME_URL."user/restore/"?>"><?=$_LANG['users']['restore']['title']?></a>
        </div>
    </form>
</div>