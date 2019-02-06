<div class="container box white z-depth-2">

    <? if(!empty($_DATA['new_errors']) && is_array($_DATA['new_errors'])) { ?>
        <div class="errors">
            <? foreach ($_DATA['new_errors'] as $error) { ?>
                <li><?=$error?></li>
            <? } ?>
        </div>
    <? } ?>

    <form action="<?=$_DATA['new_action']?>" method="<?=$_DATA['new_method']?>" novalidate>

        <div class="row">
            <div class="input-field col s12">
                <input type="text" id="<?=$_DATA['fields']['title']['name']?>" name="<?=$_DATA['fields']['title']['name']?>"
                       maxlength="<?=$_DATA['fields']['title']['length']?>" length="<?=$_DATA['fields']['title']['length']?>"
                       value="<?=$_DATA['fields']['title']['value']?>" autocomplete="off" required>
                <label for="<?=$_DATA['fields']['title']['name']?>"><?=$_LANG['requests']['title']?></label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                    <textarea class="materialize-textarea" id="<?=$_DATA['fields']['description']['name']?>" name="<?=$_DATA['fields']['description']['name']?>"
                              maxlength="<?=$_DATA['fields']['description']['length']?>" length="<?=$_DATA['fields']['description']['length']?>"><?=$_DATA['fields']['description']['value']?></textarea>
                <label for="<?=$_DATA['fields']['description']['name']?>"><?=$_LANG['requests']['description']?></label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <select id="<?=$_DATA['fields']['division']['name']?>" name="<?=$_DATA['fields']['division']['name']?>" required>
                    <option value="" selected disabled></option>
                    <? if(!empty($_DATA['fields']['division']['values'])) {
                        foreach ($_DATA['fields']['division']['values'] as $division) {
                            if ($_DATA['fields']['division']['value'] === $division['division_id']) { ?>
                                <option value="<?=$division['division_id']?>" selected><?=$division['division_name']?></option>
                            <? } else { ?>
                                <option value="<?=$division['division_id']?>"><?=$division['division_name']?></option>
                            <? }
                        }
                    }?>
                </select>
                <label for="<?=$_DATA['fields']['division']['name']?>"><?=$_LANG['requests']['for_division']?></label>
            </div>
        </div>

        <button type="submit" class="btn waves-effect waves-light"><?=$_LANG['requests']['new']['submit_btn']?></button>

    </form>

</div>

<script>
    $(document).ready(function() {
        $('select').material_select();
    });
</script>