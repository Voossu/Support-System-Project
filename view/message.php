<div class="card center short">
    <div class="card-head">
        <div class="card-title"><?=$_DATA['title']?></div>
    </div>
    <form action="<?=$_DATA['restore_action']?>" method="<?=$_DATA['restore_method']?>" novalidate>
        <div class="card-content">
            <?=$_DATA['content']?>
        </div>
        <div class="card-action">
        </div>
    </form>
</div>
