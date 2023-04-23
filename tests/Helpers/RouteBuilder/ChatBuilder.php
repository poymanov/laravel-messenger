<?php

namespace Tests\Helpers\RouteBuilder;

class ChatBuilder
{
    /**
     * @return string
     */
    public function create(): string
    {
        return '/chats';
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function show(string $id): string
    {
        return '/chats/' . $id;
    }

    /**
     * @param string $id
     *
     * @return string
     */
    public function delete(string $id): string
    {
        return '/chats/' . $id;
    }
}
