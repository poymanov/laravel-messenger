<?php

namespace Tests\Helpers;

use Tests\Helpers\ModelBuilder\ChatBuilder;
use Tests\Helpers\ModelBuilder\ChatMessageBuilder;
use Tests\Helpers\ModelBuilder\ChatMessageStatusBuilder;
use Tests\Helpers\ModelBuilder\ChatUserBuilder;
use Tests\Helpers\ModelBuilder\UserBuilder;

class ModelBuilderHelper
{
    private static ?ModelBuilderHelper $instance = null;

    public UserBuilder $user;

    public ChatBuilder $chat;

    public ChatUserBuilder $chatUser;

    public ChatMessageBuilder $chatMessage;

    public ChatMessageStatusBuilder $chatMessageStatus;

    public function __construct()
    {
        $this->user              = new UserBuilder();
        $this->chat              = new ChatBuilder();
        $this->chatUser          = new ChatUserBuilder();
        $this->chatMessage       = new ChatMessageBuilder();
        $this->chatMessageStatus = new ChatMessageStatusBuilder();
    }

    /**
     * @return ModelBuilderHelper
     */
    public static function getInstance(): ModelBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

}
