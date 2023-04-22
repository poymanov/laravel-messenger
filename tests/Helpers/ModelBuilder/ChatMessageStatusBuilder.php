<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\ChatMessageStatus;

class ChatMessageStatusBuilder
{
    /**
     * Создание сущности {@see ChatMessageStatus}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ChatMessageStatus
     */
    public function create(array $params = []): ChatMessageStatus
    {
        return ChatMessageStatus::factory()->createOne($params);
    }
}
