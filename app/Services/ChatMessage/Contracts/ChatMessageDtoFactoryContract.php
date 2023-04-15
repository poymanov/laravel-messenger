<?php

namespace App\Services\ChatMessage\Contracts;

use App\Models\ChatMessage;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use Illuminate\Database\Eloquent\Collection;

interface ChatMessageDtoFactoryContract
{
    /**
     * @param ChatMessage $chatMessage
     *
     * @return ChatMessageDto
     */
    public function createFromModel(ChatMessage $chatMessage): ChatMessageDto;

    /**
     * @param Collection $models
     *
     * @return ChatMessageDto[]
     */
    public function createFromModels(Collection $models): array;
}
