<x-mail::message>
# メッセージが届きました

{{ $recipient->username ?? $recipient->email }} さん、こんにちは。

**{{ $message->sender->username ?? $message->sender->email }}** さんからメッセージが届きました。

---

{{ $message->body }}

---

<x-mail::button :url="route('messages.show', $thread)">
メッセージを確認する
</x-mail::button>

SceneMate
</x-mail::message>
