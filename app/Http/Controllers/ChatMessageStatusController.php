<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatMessageStatus\MakeChatReadRequest;
use App\Services\ChatMessageStatus\Contracts\ChatMessageStatusServiceContract;
use App\Services\ChatUser\Contracts\ChatUserServiceContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use MichaelRubel\ValueObjects\Collection\Complex\Uuid;
use Throwable;

class ChatMessageStatusController extends Controller
{
    public function __construct(
        private readonly ChatUserServiceContract $chatUserService,
        private readonly ChatMessageStatusServiceContract $chatMessageStatusService
    ) {
    }

    /**
     * @param MakeChatReadRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws Throwable
     */
    public function makeChatRead(MakeChatReadRequest $request)
    {
        $authUserId = $this->getAuthUserId($request);

        $chatId = Uuid::make($request->get('chat_id'));

        if (!$this->chatUserService->isChatMember($authUserId, $chatId)) {
            abort(Response::HTTP_FORBIDDEN);
        }

        try {
            $this->chatMessageStatusService->makeReadByChatIdAndUserId($chatId, $authUserId);

            return response()->json([]);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
