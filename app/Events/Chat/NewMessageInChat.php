<?php

namespace App\Events\Chat;

use App\Services\ChatMessage\Contracts\ChatMessageDtoFormatterContract;
use App\Services\ChatMessage\Contracts\ChatMessageServiceContract;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;

class NewMessageInChat implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    private readonly Uuid $chatId;

    private readonly Uuid $messageId;

    /**
     * Create a new event instance.
     */
    public function __construct(Uuid $chatId, Uuid $messageId)
    {
        $this->chatId = $chatId;
        $this->messageId = $messageId;
    }

    public function broadcastAs(): string
    {
        return 'new-message';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->chatId->value()),
        ];
    }

    public function broadcastWith(): array
    {
        $chatMessageService = app()->make(ChatMessageServiceContract::class);
        $chatMessageDtoFormatter = app()->make(ChatMessageDtoFormatterContract::class);

        $message = $chatMessageService->getOneById($this->messageId);

        return $chatMessageDtoFormatter->toArrayCreated($message);
    }
}
