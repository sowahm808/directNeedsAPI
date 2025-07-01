<?php

namespace App\Services;

use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Contract\Storage;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;

class FirebaseService
{
    protected Auth $auth;
    protected Storage $storage;
    protected Messaging $messaging;

    public function __construct()
    {
        $this->auth = Firebase::auth();
        $this->storage = Firebase::storage();
        $this->messaging = Firebase::messaging();
    }

    public function verifyIdToken(string $idToken)
    {
        try {
            return $this->auth->verifyIdToken($idToken);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function upload(string $fileName, $content)
    {
        $bucket = $this->storage->getBucket();
        $object = $bucket->upload($content, ['name' => $fileName]);
        return $object->signedUrl(new \DateTime('+1 hour'));
    }

    public function sendPush(array $tokens, string $title, string $body)
    {
        $message = CloudMessage::new()->withNotification(["title" => $title, "body" => $body]);
        $this->messaging->sendMulticast($message, $tokens);
    }
}
