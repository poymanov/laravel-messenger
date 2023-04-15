<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\ChatMessage;

class ChatMessageBuilder
{
    /**
     * Создание сущности {@see ChatMessage}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ChatMessage
     */
    public function create(array $params = []): ChatMessage
    {
        return ChatMessage::factory()->createOne($params);
    }
}
