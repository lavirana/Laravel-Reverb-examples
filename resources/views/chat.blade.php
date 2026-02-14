<div class="chat-container">
    <h2>💬 Live Chat</h2>
    <div id="messages" style="height: 200px; overflow-y: auto; border: 1px solid #ddd; margin-bottom: 10px; padding: 10px;">
        </div>
    <input id="messageInput" placeholder="Type a message..." style="width: 70%;">
    <button id="sendBtn">Send</button>
</div>

<script>
    const sendMsg = () => {
        const input = document.getElementById('messageInput');
        if(!input.value) return;

        fetch('/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: input.value })
        });
        
        // Apni window mein message turant dikhane ke liye
        appendMessage(input.value);
        input.value = '';
    };

    document.getElementById('sendBtn').addEventListener('click', sendMsg);
    
    // Enter key support
    document.getElementById('messageInput').addEventListener('keypress', (e) => {
        if(e.key === 'Enter') sendMsg();
    });

    function appendMessage(msg) {
        let li = document.createElement('div');
        li.innerText = msg;
        li.style.padding = "5px";
        document.getElementById('messages').appendChild(li);
    }
</script>