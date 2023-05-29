<?php

namespace Tests\Helpers\RouteBuilder;

class ChatMessageStatusBuilder
{
    /**
     * @return string
     */
    public function makeChatRead(): string
    {
        return '/chat-message-statuses/make-chat-read';
    }
}
