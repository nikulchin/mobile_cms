<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 6/19/15
 * Time: 3:57 PM
 */?>

    <div class="row">
        <div class="col-xs-12" style="padding-left: 0px;padding-right: 0px">
            <div class="dashboard" id="img-dashboard">
                <a href="images/a6/1c/a61cd5dab648b600eeac620324ca7ca8.1907530.jpg" style="display:none"><img src="" id="215" alt="Фотография 1"></a>
                <?php foreach($images as $image): ?><a href="<?=URL::base().$image['path']; ?>"><img src="<?=URL::base().$image['thumbnail']?>" id="<?=$image['id']?>" alt="<?=$image['label']?>"></a><?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="navbar-fixed-bottom row" align="center">
        <div class="col-xs-3"></div>
        <div class="col-xs-3">
            <form enctype="multipart/form-data" name="file">
                    <span class="btn btn-success btn-file btn-folder">
                        <i class="ico-moon-plus"> </i><span></span>
                        <input id="f2" type="file"  multiple name="fileToUpload" accept="image/*">
                    </span>
            </form>
        </div>
        <div class="col-xs-3">
            <form enctype="multipart/form-data" name="camera">
                    <span class="btn btn-success btn-file btn-photo">
                        <i class="ico-moon-plus"> </i><span></span>
                        <input id="fileToUpload" type="file"  name="fileToUpload" accept="image/*" capture>
                    </span>
            </form>
        </div>
        <div class="col-xs-3"></div>
    </div>
</div>