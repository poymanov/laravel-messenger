<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Chat;

class ChatBuilder
{
    /**
     * Создание сущности {@see Chat}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Chat
     */
    public function create(array $params = []): Chat
    {
        return Chat::factory()->createOne($params);
    }
}
