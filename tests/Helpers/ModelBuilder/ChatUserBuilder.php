<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\ChatUser;

class ChatUserBuilder
{
    /**
     * Создание сущности {@see ChatUser}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ChatUser
     */
    public function create(array $params = []): ChatUser
    {
        return ChatUser::factory()->createOne($params);
    }
}
