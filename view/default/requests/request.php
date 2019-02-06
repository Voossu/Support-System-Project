<div class="container box white z-depth-2">

    <? if (empty($_DATA['request'])) { ?>
        <div class="row title center-align"><?=$_LANG['requests']['request']['deny_access']?></div>
    <? } else { ?>

        <div class="request">
            <div class="row title"><?=$_DATA['request']['request_title']?></div>

            <div class="content"><?=$_DATA['request']['request_description']?></div>
        </div>

        <? if (!empty($_DATA['status_form']['fields']['activity']['activates'])) { ?>
            <div class="row title"><?=$_LANG['requests']['request']['set_status']?></div>
            <form class="valign-wrapper row" action="<?=$_DATA['status_form']['handler']?>" method="<?=$_DATA['status_form']['method']?>">
                <div class="input-field valign col s8">
                    <select name="<?=$_DATA['status_form']['fields']['activity']['name']?>">
                        <option value="" disabled selected></option>
                        <? foreach ($_DATA['status_form']['fields']['activity']['activates'] as $item) { ?>
                            <option value="<?=$item['value']?>"><?=$item['title']?></option>
                        <? } ?>
                    </select>
                </div>
                <button class="btn col s4" type="submit">
                    <span class="hide-on-small-only"><?=$_LANG['requests']['request']['set_status']?></span><span class="hide-on-med-and-up material-icons">done</span>
                </button>
            </form>
        <? } ?>

        <div class="row title"><?=$_LANG['requests']['request_info']?></div>
        <div class="row">
            <div class="col s10 offset-s1 m4 l3 right-align hide-on-small-only">
                <?=$_LANG['requests']['create_date']?>
            </div>
            <div class="col s12 m4 l3 hide-on-med-and-up">
                <?=$_LANG['requests']['create_date']?>
            </div>
            <div class="col offset-s1 s11 m8 l9">
                <?=$_DATA['request']['request_create']?>
            </div>
        </div>
        <div class="row">
            <div class="col s10 offset-s1 m4 l3 right-align hide-on-small-only">
                <?=$_LANG['requests']['for_division']?>
            </div>
            <div class="col s12 m4 l3 hide-on-med-and-up">
                <?=$_LANG['requests']['for_division']?>
            </div>
            <div class="col offset-s1 s11 m8 l9">
                <?=$_DATA['division']['division_name']?>
            </div>
        </div>
        <div class="row">
            <div class="col s10 offset-s1 m4 l3 right-align hide-on-small-only">
                <?=$_LANG['requests']['update_date']?>
            </div>
            <div class="col s12 m4 l3 hide-on-med-and-up">
                <?=$_LANG['requests']['update_date']?>
            </div>
            <div class="col offset-s1 s11 m8 l9">
                <?=$_DATA['request']['request_update'] ?? "-"?>
            </div>
        </div>
        <div class="row">
            <div class="col s10 offset-s1 m4 l3 right-align hide-on-small-only">
                <?=$_LANG['requests']['status']?>
            </div>
            <div class="col s12 m4 l3 hide-on-med-and-up">
                <?=$_LANG['requests']['status']?>
            </div>
            <div class="col offset-s1 s11 m8 l9">
                <?=$_LANG['requests']['statuses'][$_DATA['request']['request_status']] ?? $_LANG['requests']['statuses'][0]?>
            </div>
        </div>


        <div class="col s12 m6">
            <div class="row title"><?=$_LANG['requests']['user_info']?></div>
            <div class="row">
                <div class="col s10 offset-s1 m4 l3 right-align hide-on-small-only">
                    <?=$_LANG['users']['fullname_field']?>
                </div>
                <div class="col s12 m4 l3 hide-on-med-and-up">
                    <?=$_LANG['users']['fullname_field']?>
                </div>
                <div class="col offset-s1 s11 m8 l9">
                    <?=$_DATA['user']['user_fullname']?>
                </div>
            </div>

            <div class="row">
                <div class="col s10 offset-s1 m4 l3 right-align hide-on-small-only">
                    <?=$_LANG['users']['email_field']?>
                </div>
                <div class="col s12 m4 l3 hide-on-med-and-up">
                    <?=$_LANG['users']['email_field']?>
                </div>
                <div class="col offset-s1 s11 m8 l9">
                    <?=$_DATA['user']['user_email']?>
                </div>
            </div>
            <div class="row">
                <div class="col s10 offset-s1 m4 l3 right-align hide-on-small-only">
                    <?=$_LANG['users']['phone_field']?>
                </div>
                <div class="col s12 m4 l3 hide-on-med-and-up">
                    <?=$_LANG['users']['phone_field']?>
                </div>
                <div class="col offset-s1 s11 m8 l9">
                    <?=$_DATA['user']['user_phone']?>
                </div>
            </div>
        </div>

        <? if (!empty($_DATA['statuses']) && is_array($_DATA['statuses'])) { ?>
            <div class="row title"><?=$_LANG['requests']['statuses_info']?></div>
            <div class="table">
                <div class="title row">
                    <div class="col s12 m3 hide-on-small-only"><?=$_LANG['requests']['meta']['status_set']?></div>
                    <div class="col s12 m3"><?=$_LANG['requests']['status']?></div>
                    <div class="col s12 m3 hide-on-med-and-up"><?=$_LANG['requests']['meta']['status_set']?></div>
                    <div class="col s12 m6"><?=$_LANG['requests']['user_set']?></div>
                </div>
                <? foreach ($_DATA['statuses'] as $status) { ?>
                    <div class="row">
                        <div class="col s12 m3 hide-on-small-only"><?=$status['request_date']?></div>
                        <div class="col s12 m3"><?=$_LANG['requests']['statuses'][$status['request_status']] ?? $_LANG['requests']['statuses'][0]?></div>
                        <div class="col s12 m3 hide-on-med-and-up"><?=$status['request_date']?></div>
                        <div class="col s12 m6"><a href="<?=$status['status_set_user']['href']?>"><?=$status['status_set_user']['title']?></a></div>
                    </div>
                <? } ?>
            </div>
        <? } ?>
    <? } ?>


</div>

<script>
    $(document).ready(function() {
        $('select').material_select();
    });
</script>