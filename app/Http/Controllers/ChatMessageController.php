<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessage\StoreRequest;
use App\Services\ChatMessage\Contracts\ChatMessageServiceContract;
use App\Services\ChatMessage\Exceptions\ChatMessageChatNotFoundByIdException;
use App\Services\ChatMessage\Factories\ChatMessageCreateDtoFactory;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ChatMessageController extends Controller
{
    public function __construct(
        private readonly ChatUserServiceContract $chatUserService,
        private readonly ChatMessageCreateDtoFactory $chatMessageCreateDtoFactory,
        private readonly ChatMessageServiceContract $chatMessageService
    ) {
    }

    /**
     * @param StoreRequest $request
     *
     * @return Response
     * @throws ChatMessageChatNotFoundByIdException
     * @throws Throwable
     */
    public function store(StoreRequest $request)
    {
        $authUserId = $this->getAuthUserId($request);

        $chatId = Uuid::make($request->get('chat_id'));

        if (!$this->chatUserService->isChatMember($authUserId, $chatId)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $text = $request->get('text');

        try {
            $dto = $this->chatMessageCreateDtoFactory->createFromParams($authUserId, $chatId, $text);
            $this->chatMessageService->create($dto);

            return response()->noContent();
        } catch (ChatMessageChatNotFoundByIdException) {
            throw new NotFoundHttpException();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
