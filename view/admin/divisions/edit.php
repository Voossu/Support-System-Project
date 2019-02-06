<div class="container box white z-depth-2">


    <? if (empty($_DATA['division'])) { ?>
        <div class="row title center-align"><?=$_LANG['divisions']['edit']['no_exist']?></div>
    <? } else { ?>
        <form action="<?=$_DATA['edit_action']?>" method="<?=$_DATA['edit_method']?>" novalidate>

            <div class="right-align">
                <a class="btn waves-effect waves-light" href="<?=$_DATA['all_divisions_href']?>"><?=$_LANG['divisions']['all_divisions']?></a>
                <a class="btn waves-effect waves-light" href="<?=$_DATA['delete_division']?>"><?=$_LANG['divisions']['delete_division']?></a>
                <button type="submit" class="btn waves-effect waves-light"><?=$_LANG['divisions']['edit']['submit_btn']?></button>
            </div>


            <? if(!empty($_DATA['edit_errors']) && is_array($_DATA['edit_errors'])) { ?>
                <div class="errors">
                    <? foreach ($_DATA['edit_errors'] as $error) { ?>
                        <li><?=$error?></li>
                    <? } ?>
                </div>
            <? } ?>

            <div class="row">
                <div class="input-field col s12">
                    <input type="text" id="<?=$_DATA['fields']['name']['name']?>" name="<?=$_DATA['fields']['name']['name']?>"
                           maxlength="<?=$_DATA['fields']['name']['length']?>" length="<?=$_DATA['fields']['name']['length']?>"
                           value="<?=$_DATA['fields']['name']['value']?>" autocomplete="off" required>
                    <label for="login"><?=$_LANG['divisions']['name']?></label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <textarea class="materialize-textarea" id="<?=$_DATA['fields']['description']['name']?>" name="<?=$_DATA['fields']['description']['name']?>"
                           maxlength="<?=$_DATA['fields']['description']['length']?>" length="<?=$_DATA['fields']['description']['length']?>"><?=$_DATA['fields']['description']['value']?></textarea>
                    <label for="<?=$_DATA['fields']['description']['name']?>"><?=$_LANG['divisions']['description']?></label>
                </div>
            </div>


        </form>
    <? } ?>
</div>