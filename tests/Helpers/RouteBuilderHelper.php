<?php

namespace Tests\Helpers;

use Tests\Helpers\RouteBuilder\AuthBuilder;
use Tests\Helpers\RouteBuilder\ChatBuilder;
use Tests\Helpers\RouteBuilder\ChatMessageBuilder;
use Tests\Helpers\RouteBuilder\ChatMessageStatusBuilder;
use Tests\Helpers\RouteBuilder\CommonBuilder;
use Tests\Helpers\RouteBuilder\UserBuilder;

class RouteBuilderHelper
{
    private static ?RouteBuilderHelper $instance = null;

    public UserBuilder $user;

    public AuthBuilder $auth;

    public CommonBuilder $common;

    public ChatBuilder $chat;

    public ChatMessageBuilder $chatMessage;

    public ChatMessageStatusBuilder $chatMessageStatus;

    public function __construct()
    {
        $this->user              = new UserBuilder();
        $this->auth              = new AuthBuilder();
        $this->common            = new CommonBuilder();
        $this->chat              = new ChatBuilder();
        $this->chatMessage       = new ChatMessageBuilder();
        $this->chatMessageStatus = new ChatMessageStatusBuilder();
    }

    public static function getInstance(): RouteBuilderHelper
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
