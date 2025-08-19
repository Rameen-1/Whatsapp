<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WhatsApp Clone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 
    <div id="contacts"></div>
 
    <div id="chat">
        <div id="chat-header">Select a contact</div>
        <div id="chat-box"></div>
        <div class="chat-input-container">
            <input type="text" id="message-input" placeholder="Type a message...">
            <button id="send-btn">Send</button>
        </div>
    </div>
 
    <script>
        let currentChatUserId = null;
 
        function loadContacts() {
            fetch('ajax/get_users.php')
                .then(res => res.json())
                .then(data => {
                    const contactList = document.getElementById('contacts');
                    contactList.innerHTML = '<strong>Contacts</strong>';
                    data.forEach(user => {
                        const div = document.createElement('div');
                        div.innerText = user.username;
                        div.onclick = () => startChat(user.id, user.username);
                        contactList.appendChild(div);
                    });
                });
        }
 
        function startChat(userId, username) {
            currentChatUserId = userId;
            document.getElementById('chat-header').innerText = `Chat with ${username}`;
            loadMessages();
        }
 
        function loadMessages() {
            if (!currentChatUserId) return;
 
            fetch(`ajax/fetch_messages.php?receiver_id=${currentChatUserId}`)
                .then(res => res.json())
                .then(data => {
                    const chatBox = document.getElementById('chat-box');
                    chatBox.innerHTML = '';
                    data.forEach(msg => {
                        const div = document.createElement('div');
                        div.className = (msg.sender_id == <?php echo $_SESSION['user_id']; ?>) ? 'you' : 'them';
                        div.innerText = msg.message;
                        chatBox.appendChild(div);
                    });
                    // Scroll to bottom
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        }
 
        document.getElementById('send-btn').onclick = function () {
            const msg = document.getElementById('message-input').value;
            if (!msg || !currentChatUserId) return;
 
            fetch('ajax/send_message.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `receiver_id=${currentChatUserId}&message=${encodeURIComponent(msg)}`
            }).then(() => {
                document.getElementById('message-input').value = '';
                loadMessages();
            });
        };
 
        // Auto-refresh every 2 seconds
        setInterval(() => {
            if (currentChatUserId) loadMessages();
        }, 2000);
 
        // Initial load
        loadContacts();
    </script>
</body>
</html>
 
 
