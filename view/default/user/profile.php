<div class="container box white z-depth-2">

    <? if (!empty($_DATA['menu'])) { ?>
        <div class="menu tabs">
        <? foreach ($_DATA['menu'] as $item) {
            if ($item['select']) { ?>
                <a class="tab col s3 select" href=""><?=$item['title']?></a>
            <? } else { ?>
                <a class="tab col s3" href="<?=$item['url']?>"><?=$item['title']?></a>
            <? }
        } ?>
        </div>
    <? } ?>

    <? if(!empty($_DATA['profile_errors']) && is_array($_DATA['profile_errors'])) { ?>
        <div class="errors">
            <? foreach ($_DATA['profile_errors'] as $error) { ?>
                <li><?=$error?></li>
            <? } ?>
        </div>
    <? } ?>

    <form action="<?=$_DATA['profile_action']?>" method="<?=$_DATA['profile_method']?>" novalidate>

        <div class="row title"><?=$_LANG['users']['profile']['personal_title']?></div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="text" id="<?=$_DATA['fields']['firstname']['name']?>" name="<?=$_DATA['fields']['firstname']['name']?>"
                       maxlength="<?=$_DATA['fields']['firstname']['length']?>" length="<?=$_DATA['fields']['firstname']['length']?>"
                       value="<?=$_DATA['user']['user_firstname']?>" autocomplete="off">
                <label for="<?=$_DATA['fields']['firstname']['name']?>"><?=$_LANG['users']['firstname_field']?></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="text" id="<?=$_DATA['fields']['secondname']['name']?>" name="<?=$_DATA['fields']['secondname']['name']?>"
                       maxlength="<?=$_DATA['fields']['secondname']['length']?>" length="<?=$_DATA['fields']['secondname']['length']?>"
                       value="<?=$_DATA['user']['user_secondname']?>" autocomplete="off">
                <label for="<?=$_DATA['fields']['secondname']['name']?>"><?=$_LANG['users']['secondname_field']?></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="text" id="<?=$_DATA['fields']['lastname']['name']?>" name="<?=$_DATA['fields']['lastname']['name']?>"
                       maxlength="<?=$_DATA['fields']['lastname']['length']?>" length="<?=$_DATA['fields']['lastname']['length']?>"
                       value="<?=$_DATA['user']['user_lastname']?>" autocomplete="off">
                <label for="<?=$_DATA['fields']['lastname']['name']?>"><?=$_LANG['users']['lastname_field']?></label>
            </div>
        </div>

        <div class="row title"><?=$_LANG['users']['profile']['work_title']?></div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="text" id="<?=$_DATA['fields']['post']['name']?>" name="<?=$_DATA['fields']['post']['name']?>"
                       maxlength="<?=$_DATA['fields']['post']['length']?>" length="<?=$_DATA['fields']['post']['length']?>"
                       value="<?=$_DATA['user']['user_post']?>" autocomplete="off">
                <label for="<?=$_DATA['fields']['post']['name']?>"><?=$_LANG['users']['post_field']?></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <select name="<?=$_DATA['fields']['division']['name']?>">
                    <? if (empty($_DATA['user']['user_division'])) { ?>
                        <option value="<?=$_DATA['fields']['division']['empty']?>" selected></option>
                    <? } else { ?>
                        <option value="<?=$_DATA['fields']['division']['empty']?>"></option>
                    <? } ?>

                    <? if(!empty($_DATA['fields']['division']['list'])) {
                        foreach ($_DATA['fields']['division']['list'] as $division) {
                            if ($_DATA['user']['user_division'] === $division['division_id']) { ?>
                                <option value="<?=$division['division_id']?>" selected><?=$division['division_name']?></option>
                            <? } else { ?>
                                <option value="<?=$division['division_id']?>"><?=$division['division_name']?></option>
                            <? }
                        }
                    }?>
                </select>
                <label><?=$_LANG['users']['division_field']?></label>
            </div>
        </div>

        <div class="row title"><?=$_LANG['users']['profile']['contact_title']?></div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="email" id="<?=$_DATA['fields']['email']['name']?>" value="<?=$_DATA['user']['user_email']?>" pattern="<?=$_CONFIG['regexp']['email']?>" disabled>
                <label for="<?=$_DATA['fields']['email']['name']?>"><?=$_LANG['users']['email_field']?></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="text" id="<?=$_DATA['fields']['phone']['name']?>" name="<?=$_DATA['fields']['phone']['name']?>"
                       maxlength="<?=$_DATA['fields']['phone']['length']?>" length="<?=$_DATA['fields']['phone']['length']?>"
                       value="<?=$_DATA['user']['user_phone']?>" autocomplete="off">
                <label for="<?=$_DATA['fields']['phone']['name']?>"><?=$_LANG['users']['phone_field']?></label>
            </div>
        </div>

        <div class="row title"><?=$_LANG['users']['profile']['pass_title']?></div>
        <div class="row help col s12 m6">
            <?=$_LANG['users']['profile']['pass_help']?>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="password" id="<?=$_DATA['fields']['pass']['name']?>" name="<?=$_DATA['fields']['pass']['name']?>"
                       maxlength="<?=$_DATA['fields']['pass']['length']?>" length="<?=$_DATA['fields']['pass']['length']?>"
                       value="<?=$_DATA['fields']['pass']['value']?>" pattern="<?=$_CONFIG['regexp']['pass']?>" autocomplete="off">
                <label for="<?=$_DATA['fields']['pass']['name']?>"><?=$_LANG['users']['pass_field']?></label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input type="password" id="<?=$_DATA['fields']['newpass']['name']?>" name="<?=$_DATA['fields']['newpass']['name']?>"
                       maxlength="<?=$_DATA['fields']['newpass']['length']?>" length="<?=$_DATA['fields']['newpass']['length']?>"
                       value="<?=$_DATA['fields']['newpass']['value']?>"  pattern="<?=$_CONFIG['regexp']['pass']?>" autocomplete="off">
                <label for="<?=$_DATA['fields']['newpass']['name']?>"><?=$_LANG['users']['newpass_field']?></label>
            </div>
        </div>

        <div class="row activities">
            <button type="submit" class="btn waves-effect waves-light"><?=$_LANG['users']['profile']['submit_btn']?></button>
            <button type="reset" class="btn waves-effect waves-light"><?=$_LANG['users']['profile']['reset_btn']?></button>
        </div>
    </form>

</div>

<script>
    $(document).ready(function() {
        $('select').material_select();
    });
</script>