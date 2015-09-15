<?php
/**
 * Created by PhpStorm.
 * User: reglobbe
 * Date: 12/8/15
 * Time: 7:08 PM
 */

namespace auction\components;

use yii\base\Event;

class Events extends Event{

    const REGISTRATION='registration';

    const CREATE_COMPANY='create_company';

    const USER_LOGIN='user_login';

    const SAVE_UPLOAD_THUMB = 'upload_thumb';

    const UPLOAD_IMAGE = 'upload_image';

    const TOKEN_INVALID = 'token_invalid';

    const SEND_RESET_TOKEN = 'send-reset-token';

    const UPDATE_AUCTION = 'update_auction';

}