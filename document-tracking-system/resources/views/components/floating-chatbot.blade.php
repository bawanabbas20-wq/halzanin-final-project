@props([
    'endpoint' => request()->getBaseUrl() . '/chatbot/chat',
    'welcome' => "Slaw! I'm your Halzanin Assistant. Ask me anything about your documents or application process!",
])

<div id="chatbot-wrapper" style="position:fixed;bottom:88px;right:20px;z-index:10000;display:flex;flex-direction:column;align-items:flex-end;gap:12px;">
    <div id="chatbot-window" style="display:none;width:340px;max-width:90vw;height:480px;background:#ffffff;border-radius:16px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);flex-direction:column;overflow:hidden;border:1px solid rgba(0,0,0,0.06);" class="dark:[background:#1e293b] animate-fade-in">
        <div style="background:linear-gradient(135deg,#4338ca 0%,#3730a3 100%);padding:14px 16px;display:flex;align-items:center;gap:10px;flex-shrink:0;">
            <div style="width:36px;height:36px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">AI</div>
            <div style="flex:1;min-width:0;">
                <p style="color:#fff;font-weight:700;font-size:14px;margin:0;font-family:Outfit,sans-serif;">Halzanin Assistant</p>
                <div style="display:flex;align-items:center;gap:5px;margin-top:2px;">
                    <div style="width:7px;height:7px;background:#34d399;border-radius:50%;"></div>
                    <span style="color:rgba(255,255,255,0.8);font-size:11px;font-weight:600;">Online</span>
                </div>
            </div>
            <button id="chatbot-close" type="button" style="background:rgba(255,255,255,0.15);border:none;width:28px;height:28px;border-radius:50%;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:background 0.2s;">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div id="chatbot-messages" style="flex:1;overflow-y:auto;padding:16px;display:flex;flex-direction:column;gap:10px;background:inherit;"></div>

        <div style="padding:12px;border-top:1px solid rgba(0,0,0,0.07);background:inherit;flex-shrink:0;">
            @php($chatQuickQuestions = config('chatbot.quick_questions', []))
            <div id="chatbot-quick-questions" style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:10px;">
                @foreach($chatQuickQuestions as $question)
                    <button
                        type="button"
                        class="chat-quick-btn"
                        data-en="{{ $question['en'] ?? '' }}"
                        data-ku="{{ $question['ku'] ?? '' }}"
                    ></button>
                @endforeach
            </div>
            <div style="display:flex;gap:8px;align-items:flex-end;">
                <textarea
                    id="chatbot-input"
                    placeholder="Ask me anything..."
                    rows="1"
                    style="flex:1;resize:none;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 12px;font-size:13px;font-family:Outfit,sans-serif;outline:none;background:#f8fafc;color:#1e293b;max-height:88px;line-height:1.4;transition:border-color 0.2s;"
                ></textarea>
                <button
                    id="chatbot-send"
                    type="button"
                    style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#4338ca,#3730a3);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;flex-shrink:0;transition:transform 0.15s,opacity 0.15s;"
                >
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div style="position:relative;">
        <div id="chatbot-pulse" style="position:absolute;inset:-6px;border-radius:50%;background:rgba(67,56,202,0.3);animation:chatPulse 2s ease-in-out infinite;pointer-events:none;"></div>
        <button id="chatbot-btn" type="button" style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#4338ca,#6366f1);border:none;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 10px 25px -5px rgba(67,56,202,0.5);transition:transform 0.2s,box-shadow 0.2s;position:relative;z-index:1;">
            <svg id="chatbot-icon-open" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            <svg id="chatbot-icon-close" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
            <div id="chatbot-badge" style="position:absolute;top:-2px;right:-2px;width:14px;height:14px;background:#ef4444;border-radius:50%;border:2px solid #fff;display:none;"></div>
        </button>
    </div>
</div>

<style>
    @keyframes chatPulse {
        0%, 100% { transform: scale(1); opacity: 0.7; }
        50% { transform: scale(1.3); opacity: 0; }
    }

    #chatbot-messages::-webkit-scrollbar { width: 4px; }
    #chatbot-messages::-webkit-scrollbar-track { background: transparent; }
    #chatbot-messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    @media (min-width: 1024px) { #chatbot-wrapper { bottom: 24px !important; } }

    .chat-msg-user {
        align-self: flex-end;
        background: linear-gradient(135deg,#4338ca,#6366f1);
        color: #fff;
        padding: 9px 13px;
        border-radius: 14px 14px 4px 14px;
        font-size: 13px;
        max-width: 80%;
        line-height: 1.5;
        word-wrap: break-word;
        font-family: Outfit, sans-serif;
    }

    .chat-msg-ai {
        align-self: flex-start;
        background: #f1f5f9;
        color: #1e293b;
        padding: 9px 13px;
        border-radius: 14px 14px 14px 4px;
        font-size: 13px;
        max-width: 85%;
        line-height: 1.5;
        word-wrap: break-word;
        font-family: Outfit, sans-serif;
    }

    .chat-quick-btn {
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        color: #334155;
        border-radius: 9999px;
        padding: 6px 10px;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.2;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .chat-quick-btn:hover {
        border-color: #818cf8;
        color: #312e81;
        background: #eef2ff;
    }

    html.dark .chat-msg-ai { background: #334155; color: #f1f5f9; }
    html.dark #chatbot-window { background: #1e293b !important; }
    html.dark #chatbot-input { background: #0f172a !important; border-color: #334155 !important; color: #f1f5f9 !important; }
    html.dark .chat-quick-btn { background: #0f172a; border-color: #334155; color: #cbd5e1; }
    html.dark .chat-quick-btn:hover { background: #1e293b; border-color: #6366f1; color: #eef2ff; }

    .typing-dot {
        width: 7px;
        height: 7px;
        background: #94a3b8;
        border-radius: 50%;
        display: inline-block;
        animation: typingBounce 1.2s infinite ease-in-out;
    }

    .typing-dot:nth-child(2) { animation-delay: 0.2s; }
    .typing-dot:nth-child(3) { animation-delay: 0.4s; }

    @keyframes typingBounce {
        0%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-6px); }
    }
</style>

<script>
    (() => {
        if (window.__halzaninChatbotInit) {
            return;
        }
        window.__halzaninChatbotInit = true;

        let chatOpened = false;
        const welcomeMessage = @json($welcome);
        const endpoint = @json($endpoint);

        const byId = (id) => document.getElementById(id);

        const getCurrentUiLang = () => document.documentElement.lang === 'ku' ? 'ku' : 'en';

        window.updateChatQuickPrompts = function(lang = getCurrentUiLang()) {
            document.querySelectorAll('#chatbot-quick-questions .chat-quick-btn').forEach((button) => {
                button.textContent = lang === 'ku' ? button.dataset.ku : button.dataset.en;
            });
        };

        window.appendMsg = function(role, text) {
            const messages = byId('chatbot-messages');
            if (!messages) {
                return null;
            }

            const element = document.createElement('div');
            element.className = role === 'user' ? 'chat-msg-user' : 'chat-msg-ai';
            element.textContent = text;
            messages.appendChild(element);
            messages.scrollTop = messages.scrollHeight;
            return element;
        };

        window.showTyping = function() {
            const messages = byId('chatbot-messages');
            if (!messages || byId('chatbot-typing')) {
                return;
            }

            const element = document.createElement('div');
            element.className = 'chat-msg-ai';
            element.id = 'chatbot-typing';
            element.style.display = 'flex';
            element.style.gap = '4px';
            element.style.alignItems = 'center';
            element.style.padding = '10px 14px';
            element.innerHTML = '<span class="typing-dot"></span><span class="typing-dot"></span><span class="typing-dot"></span>';
            messages.appendChild(element);
            messages.scrollTop = messages.scrollHeight;
        };

        window.removeTyping = function() {
            const element = byId('chatbot-typing');
            if (element) {
                element.remove();
            }
        };

        window.toggleChat = function(forceState = null) {
            const win = byId('chatbot-window');
            const iconOpen = byId('chatbot-icon-open');
            const iconClose = byId('chatbot-icon-close');
            const badge = byId('chatbot-badge');
            const pulse = byId('chatbot-pulse');
            const input = byId('chatbot-input');
            const messages = byId('chatbot-messages');

            if (!win || !iconOpen || !iconClose || !pulse) {
                return;
            }

            chatOpened = typeof forceState === 'boolean' ? forceState : !chatOpened;

            if (chatOpened) {
                win.style.display = 'flex';
                iconOpen.style.display = 'none';
                iconClose.style.display = 'block';
                if (badge) {
                    badge.style.display = 'none';
                }
                pulse.style.animation = 'none';

                if (messages && messages.children.length === 0) {
                    window.appendMsg('ai', welcomeMessage);
                }

                window.updateChatQuickPrompts(getCurrentUiLang());
                window.setTimeout(() => {
                    if (input) {
                        input.focus();
                    }
                }, 100);
            } else {
                win.style.display = 'none';
                iconOpen.style.display = 'block';
                iconClose.style.display = 'none';
                pulse.style.animation = 'chatPulse 2s ease-in-out infinite';
            }
        };

        window.sendQuickQuestion = function(button) {
            if (!button) {
                return;
            }

            const input = byId('chatbot-input');
            if (!input) {
                return;
            }

            const lang = getCurrentUiLang();
            const question = lang === 'ku' ? button.dataset.ku : button.dataset.en;
            if (!question) {
                return;
            }

            input.value = question;
            input.dispatchEvent(new Event('input'));
            window.sendChatMessage();
        };

        window.sendChatMessage = async function() {
            const input = byId('chatbot-input');
            const sendButton = byId('chatbot-send');
            const badge = byId('chatbot-badge');
            const csrf = document.querySelector('meta[name="csrf-token"]');

            if (!input || !sendButton || !csrf) {
                return;
            }

            const message = input.value.trim();
            if (!message) {
                return;
            }

            input.value = '';
            input.style.height = 'auto';
            window.appendMsg('user', message);
            window.showTyping();

            sendButton.disabled = true;
            sendButton.style.opacity = '0.5';

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf.getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                window.removeTyping();
                window.appendMsg('ai', data.reply || 'Sorry, something went wrong.');

                if (!chatOpened && badge) {
                    badge.style.display = 'block';
                }
            } catch (error) {
                window.removeTyping();
                window.appendMsg('ai', 'Connection error. Please try again.');
            } finally {
                sendButton.disabled = false;
                sendButton.style.opacity = '1';
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            const openButton = byId('chatbot-btn');
            const closeButton = byId('chatbot-close');
            const sendButton = byId('chatbot-send');
            const input = byId('chatbot-input');

            if (openButton) {
                openButton.addEventListener('click', () => window.toggleChat());
            }

            if (closeButton) {
                closeButton.addEventListener('click', () => window.toggleChat(false));
            }

            document.querySelectorAll('#chatbot-quick-questions .chat-quick-btn').forEach((button) => {
                button.addEventListener('click', () => window.sendQuickQuestion(button));
            });

            if (sendButton) {
                sendButton.addEventListener('click', () => window.sendChatMessage());
            }

            if (input) {
                input.addEventListener('focus', () => {
                    input.style.borderColor = '#4338ca';
                });

                input.addEventListener('blur', () => {
                    input.style.borderColor = '#e2e8f0';
                });

                input.addEventListener('input', () => {
                    input.style.height = 'auto';
                    input.style.height = Math.min(input.scrollHeight, 88) + 'px';
                });

                input.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' && !event.shiftKey) {
                        event.preventDefault();
                        window.sendChatMessage();
                    }
                });
            }

            window.updateChatQuickPrompts(getCurrentUiLang());
        });
    })();
</script>
