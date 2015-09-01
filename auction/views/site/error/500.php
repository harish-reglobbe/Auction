<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 1/9/15
 * Time: 5:20 PM
 */
use auction\components\Auction;
?>

<div class="error-page">
    <img src="<?= Auction::$app->request->baseUrl?>/images/500-error.jpg" alt="" />
    <h1>Oops, Something went wrong</h1>
    <p>The page you are looking for can’t be found.<br/>
        Go home by <a href="<?php echo Auction::createUrl('site/index')?>">clicking here!</a></p>
</div>