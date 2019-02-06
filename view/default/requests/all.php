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

    <form class="valign-wrapper row" action="<?=$_DATA['activity_form']['handler']?>" method="<?=$_DATA['activity_form']['method']?>">
        <div class="div valign col s8">
            <div class="input-field">
                <select name="<?=$_DATA['activity_form']['fields']['division']['name']?>">
                    <? if ($_DATA['activity_form']['fields']['division']['value'] === 0) { ?>
                        <option value="" selected></option>
                        <? foreach ($_DATA['activity_form']['fields']['division']['values'] as $item) { ?>
                            <option value="<?=$item['division_id']?>"><?=$item['division_name']?></option>
                        <? } ?>
                    <? } else { ?>
                        <option value=""></option>
                        <? foreach ($_DATA['activity_form']['fields']['division']['values'] as $item) { ?>
                            <? if ($item['division_id'] === $_DATA['activity_form']['fields']['division']['value']) { ?>
                                <option value="<?=$item['division_id']?>" selected><?=$item['division_name']?></option>
                            <? } else { ?>
                                <option value="<?=$item['division_id']?>"><?=$item['division_name']?></option>
                            <? } ?>
                        <? } ?>
                    <? } ?>
                </select>
            </div>
            <div class="input-field">
                <select name="<?=$_DATA['activity_form']['fields']['activities']['name']?>">
                    <? foreach ($_DATA['activity_form']['fields']['activities']['values'] as $item) { ?>
                        <? if ($item['select']) { ?>
                            <option value="<?=$item['value']?>" selected><?=$item['title']?></option>
                        <? } else { ?>
                            <option value="<?=$item['value']?>"><?=$item['title']?></option>
                        <? } ?>
                    <? } ?>
                </select>
            </div>
        </div>

        <button class="btn col s4" type="submit">
            <span class="hide-on-small-only"><?=$_LANG['requests']['division']['submit_btn']?></span><span class="hide-on-med-and-up material-icons">done</span>
        </button>
    </form>

    <div class="table">
        <div class="title row valign-wrapper">
            <div class="col s12 m12 l5 center-align"><?=$_LANG['requests']['title']?> </div>
            <div class="col s12 m4 l3 center-align"><?=$_LANG['requests']['for_division']?> </div>
            <div class="col s12 m4 l2 center-align"><?=$_LANG['requests']['update_date']?> </div>
            <div class="col s12 m4 l2 center-align"><?=$_LANG['requests']['status']?> </div>
        </div>
        <? if (!empty($_DATA['requests']) && is_array($_DATA['requests'])) {
            foreach ($_DATA['requests'] as $request) { ?>
                <a href="<?=$request['href']?>">
                    <div class="row">
                        <div class="col offset-s1 s10 offset-m1 m12 l5 hide-on-small-only"><?=$request['request_title']?></div>
                        <div class="col offset-s1 s10 offset-m1 m12 l5 hide-on-med-and-up bold"><?=$request['request_title']?></div>
                        <div class="col s12 m4 l3 center-align"><?=$request['request_division']?> </div>
                        <div class="col s12 m4 l2 center-align"><?=$request['request_update'] ?? $request['request_create']?> </div>
                        <div class="col s12 m4 l2 center-align"><?=$_LANG['requests']['statuses'][$request['request_status']] ?? $_LANG['requests']['statuses'][0]?></div>
                    </div>
                </a>
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

<script>
    $(document).ready(function() {
        $('select').material_select();
    });
</script>