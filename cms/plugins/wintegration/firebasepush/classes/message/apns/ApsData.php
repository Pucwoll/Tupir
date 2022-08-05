<?php namespace WIntegration\FirebasePush\Classes\Message\Apns;

use JsonSerializable;
use Plokko\Firebase\FCM\Message\Apns\ApnsAlert;

/**
 * Contains aps apple's reserved keywords for ApnsPayload
 * @package Plokko\Firebase\FCM\Message\Apns
 *
 * @see https://goo.gl/32Pl5W
 */
class ApsData implements JsonSerializable
{
    public
        /** @var ApnsAlert|string */
        $alert,
        /** @var int */
        $badge,
        /** @var string */
        $sound,
        /** @var int */
        $content_available,
        /** @var string */
        $category,
        /** @var string */
        $thread_id,
        /** @var int */
        $mutable_content;

    public function jsonSerialize()
    {
        return array_filter([
            'alert' => $this->alert,
            'badge' => $this->badge,
            'sound' => $this->sound,
            'content-available' => $this->content_available,
            'category' => $this->category,
            'thread-id' => $this->thread_id,
            'mutable-content' => $this->mutable_content
        ]);
    }
}
