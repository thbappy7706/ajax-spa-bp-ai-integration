@extends('layouts.app')


@push('styles')
<style>
    .chat-wrapper {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 140px);
        max-width: 860px;
        margin: 0 auto;
        background: var(--surface);
        border: 1px solid var(--gb);
        border-radius: 14px;
        overflow: hidden;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        scroll-behavior: smooth;
    }

    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 3px;
    }

    .chat-empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        padding: 40px 20px;
    }

    .chat-message {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        animation: msgIn 0.3s ease;
    }

    .chat-message.user {
        flex-direction: row-reverse;
    }

    .chat-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 12px;
        font-weight: 600;
    }

    .chat-message.user .chat-avatar {
        background: var(--primary);
        color: var(--primary-foreground);
    }

    .chat-message.ai .chat-avatar {
        background: rgba(34,211,238,.12);
        color: #22d3ee;
    }

    .chat-bubble {
        max-width: 72%;
        padding: 12px 16px;
        border-radius: 14px;
        font-size: 13.5px;
        line-height: 1.55;
        word-wrap: break-word;
    }

    .chat-message.user .chat-bubble {
        background: var(--accent);
        color: var(--accent-foreground);
        border-bottom-right-radius: 4px;
    }

    .chat-message.ai .chat-bubble {
        background: var(--accent-2);
        color: var(--foreground);
        border-bottom-left-radius: 4px;
    }

    .chat-bubble pre {
        background: rgba(0,0,0,.25);
        padding: 10px 14px;
        border-radius: 8px;
        overflow-x: auto;
        font-size: 12px;
        line-height: 1.5;
        margin: 8px 0;
    }

    .chat-bubble code {
        font-family: 'IBM Plex Mono', monospace;
        font-size: 12px;
    }

    .chat-input-wrap {
        padding: 12px 16px 14px;
        border-top: 1px solid var(--border);
        background: var(--surface);
    }

    .chat-input-container {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        background: var(--accent-2);
        border: 1px solid var(--gb);
        border-radius: 12px;
        padding: 6px 6px 6px 14px;
        transition: border-color .2s;
    }

    .chat-input-container:focus-within {
        border-color: var(--primary);
    }

    .chat-input-container textarea {
        flex: 1;
        background: none;
        border: none;
        color: var(--foreground);
        font-size: 14px;
        font-family: inherit;
        padding: 8px 0;
        outline: none;
        max-height: 120px;
        line-height: 1.5;
    }

    .chat-input-container textarea::placeholder {
        color: var(--muted-foreground);
    }

    .chat-send-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: var(--primary);
        color: var(--primary-foreground);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: opacity .2s, transform .15s;
    }

    .chat-send-btn:hover {
        opacity: .85;
    }

    .chat-send-btn:active {
        transform: scale(.95);
    }

    .chat-typing {
        padding: 4px 20px 0;
        font-size: 12px;
        color: var(--muted-foreground);
        display: flex;
        align-items: center;
        gap: 4px;
        min-height: 28px;
    }

    @keyframes msgIn {
        from { opacity: 0; transform: translateY(8px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes typing1 {
        0%, 60%, 100% { opacity: .3; }
        30% { opacity: 1; }
    }

    @keyframes typing2 {
        0%, 40%, 100% { opacity: .3; }
        50% { opacity: 1; }
    }

    @keyframes typing3 {
        0%, 100% { opacity: .3; }
        70% { opacity: 1; }
    }
</style>
@endpush

@section('title', 'Chat Assistant')

@section('content')
<div class="topbar fi">
    <div>
        <h1 class="ptitle">Chat Assistant</h1>
        <div class="psub">Ask questions and get AI-powered responses with conversation memory.</div>
    </div>
    <div>
        <button class="btn p" id="clear-chat-btn" style="font-size:12px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
            Clear Chat
        </button>
    </div>
</div>

{{-- ════ CHAT CONTAINER ════ --}}
<div class="chat-wrapper fi" id="chat-wrapper">
    <div class="chat-messages" id="chat-messages">
        <div class="chat-empty-state" id="chat-empty">
            <div style="width:56px;height:56px;border-radius:50%;background:rgba(34,211,238,.08);display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#22d3ee" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 12h0"/><path d="M12 12h0"/><path d="M16 12h0"/><path d="M21 12c0 4.4-3.4 8-7.6 8-1.5 0-2.9-.3-4.2-.8"/><path d="M3 12C3 7.6 6.4 4 10.6 4c1.5 0 2.9.3 4.2.8"/><path d="M3 12c0 4.4 3.4 8 7.6 8"/><path d="M21 12c0-4.4-3.4-8-7.6-8"/></svg>
            </div>
            <div style="font-size:15px;font-weight:600;color:var(--muted-foreground);margin-bottom:4px;">Start a conversation</div>
            <div style="font-size:12px;color:var(--muted-foreground);">Ask anything and the AI assistant will help you.</div>
        </div>
    </div>

    {{-- ════ TYPING INDICATOR ════ --}}
    <div class="chat-typing" id="chat-typing" style="display:none;">
        <div style="display:flex;align-items:center;gap:6px;">
            <div style="width:8px;height:8px;border-radius:50%;background:var(--accent);animation:typing1 1.2s infinite;"></div>
            <div style="width:8px;height:8px;border-radius:50%;background:var(--accent);animation:typing2 1.2s infinite 0.2s;"></div>
            <div style="width:8px;height:8px;border-radius:50%;background:var(--accent);animation:typing3 1.2s infinite 0.4s;"></div>
            <span style="font-size:11px;color:var(--muted-foreground);margin-left:4px;">Thinking...</span>
        </div>
    </div>

    {{-- ════ INPUT AREA ════ --}}
    <div class="chat-input-wrap">
        <form id="chat-form">
            <div class="chat-input-container">
                <textarea
                    id="chat-input"
                    name="message"
                    placeholder="Type your message here…"
                    rows="1"
                    required
                    style="resize:none;"
                ></textarea>
                <button type="submit" class="chat-send-btn" id="chat-send-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </div>
        </form>
        <div style="font-size:10px;color:var(--muted-foreground);text-align:center;margin-top:6px;">
            Powered by Laravel AI SDK
        </div>
    </div>
</div>



@push('scripts')
<script>
(function() {
    const messagesContainer = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const chatForm = document.getElementById('chat-form');
    const chatTyping = document.getElementById('chat-typing');
    const chatEmpty = document.getElementById('chat-empty');
    const sendBtn = document.getElementById('chat-send-btn');
    const clearBtn = document.getElementById('clear-chat-btn');

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function addMessage(role, content) {
        chatEmpty.style.display = 'none';

        const messageDiv = document.createElement('div');
        messageDiv.className = 'chat-message ' + (role === 'user' ? 'user' : 'ai');

        const avatar = document.createElement('div');
        avatar.className = 'chat-avatar';
        avatar.textContent = role === 'user' ? 'U' : 'AI';

        const bubble = document.createElement('div');
        bubble.className = 'chat-bubble';
        bubble.innerHTML = content;

        messageDiv.appendChild(avatar);
        messageDiv.appendChild(bubble);
        messagesContainer.appendChild(messageDiv);

        scrollToBottom();
    }

    function formatResponse(text) {
        let html = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        html = html.replace(/\n/g, '<br>');

        html = html.replace(/```([\s\S]*?)```/g, function(match, code) {
            return '<pre><code>' + code.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</code></pre>';
        });

        html = html.replace(/`([^`]+)`/g, '<code>$1</code>');
        html = html.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');
        html = html.replace(/\*([^*]+)\*/g, '<em>$1</em>');

        return html;
    }

    function sendMessage(e) {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        addMessage('user', message);

        chatInput.value = '';
        chatInput.style.height = 'auto';

        chatTyping.style.display = 'block';
        sendBtn.disabled = true;
        scrollToBottom();

        fetch('{{ route("chat.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(res => {
            return res.json().then(data => {
                if (!res.ok) {
                    throw new Error(data.error || 'Request failed');
                }
                return data;
            });
        })
        .then(data => {
            addMessage('ai', formatResponse(data.response));
        })
        .catch(err => {
            addMessage('ai', '<span style="color:var(--destructive);">' + (err.message || 'Sorry, something went wrong.') + '</span>');
        })
        .finally(() => {
            chatTyping.style.display = 'none';
            sendBtn.disabled = false;
            scrollToBottom();
        });
    }

    function autoGrow(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 120) + 'px';
    }

    function clearChat() {
        const messages = messagesContainer.querySelectorAll('.chat-message');
        messages.forEach(m => m.remove());
        chatEmpty.style.display = '';
    }

    chatForm.addEventListener('submit', sendMessage);
    chatInput.addEventListener('input', function() { autoGrow(this); });
    chatInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit', { cancelable: true }));
        }
    });
    clearBtn.addEventListener('click', clearChat);

    chatInput.focus();
})();
</script>
@endpush
@endsection