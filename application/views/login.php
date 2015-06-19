<div class="row">
    <div class="col-xs-12" style="padding-left: 0px;padding-right: 0px">

        <h3 class="heading-desc"><?php echo isset($social_login_caption)? $social_login_caption : 'NULL'; ?></h3>
        <div class="social-box">
            <a class="btn btn-block btn-social btn-google-plus btn-lg" href="<?=$google_href?>?redirect_uri=<?=$google_redirect_uri?>&client_id=<?=$google_client_id?>&scope=<?=$google_scope?>">
                <i class="fa fa-google-plus"></i> Sign in with Google

            </a>
        </div>
        <div class="social-box">
            <a class="btn btn-block btn-social btn-facebook btn-lg" href="<?=$facebook_href?>">
                <i class="fa fa-facebook"></i> Sign in with Facebook

            </a>
        </div>
        <div class="social-box">
            <a class="btn btn-block btn-social btn-twitter btn-lg" href="<?=$twitter_href?>">
                <i class="fa fa-twitter"></i> Sign in with Twitter

            </a>
        </div>

    </div>
</div>