<?php

namespace App\Services\ChatMessage\Formatters;

use App\Services\ChatMessage\Contracts\ChatMessageDtoFormatterContract;
use App\Services\ChatMessage\Dtos\ChatMessageDto;
use Carbon\Carbon;

class ChatMessageDtoFormatter implements ChatMessageDtoFormatterContract
{
    /**
     * @inheritDoc
     */
    public function toArray(ChatMessageDto $dto): array
    {
        return [
            'id'              => $dto->id->value(),
            'chat_id'         => $dto->chatId->value(),
            'sender_user_id'  => $dto->senderUserId,
            'text'            => $dto->text,
            'created_at'      => $dto->createdAt->format('Y-m-d H:i:s'),
            'created_at_time' => $dto->createdAt->format('H:i'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function toArrayByDate(ChatMessageDto $dto): array
    {
        $date      = $this->formatToDate($dto->createdAt);
        $dateTitle = $this->formatToDateTitle($dto->createdAt);

        return [
            'date'    => $date,
            'title'   => $dateTitle,
            'message' => $this->toArray($dto),
        ];
    }

    /**
     * @inheritDoc
     */
    public function fromArrayToArray(array $dtos): array
    {
        $messages = [];

        foreach ($dtos as $dto) {
            $date      = $this->formatToDate($dto->createdAt);
            $dateTitle = $this->formatToDateTitle($dto->createdAt);

            $messages[$date]['messages'][] = $this->toArray($dto);
            $messages[$date]['title']      = $dateTitle;
        }

        ksort($messages);

        return $messages;
    }

    /**
     * @param Carbon $date
     *
     * @return string
     */
    private function formatToDate(Carbon $date): string
    {
        return $date->format('Y-m-d');
    }

    /**
     * @param Carbon $date
     *
     * @return string
     */
    private function formatToDateTitle(Carbon $date): string
    {
        return $date->format('d F');
    }
}
