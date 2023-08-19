<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
    <style>
        /* Add your CSS styles here */
        .chat-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        
        .friends-list {
            width: 20%;
            background-color: #f0f0f0;
            border-right: 1px solid #ccc;
            padding: 20px;
        }
        
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .message-list {
            flex: 1;
            overflow-y: scroll;
            padding: 20px;
        }
        
        .message-input {
            display: flex;
            align-items: center;
            padding: 10px;
            border-top: 1px solid #ccc;
        }
        
        .message-input input[type="text"] {
            flex: 1;
            padding: 5px;
        }
        
        .message-input button {
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="friends-list">
            <!-- List of friends -->
            <ul>
                <li>Friend 1</li>
                <li>Friend 2</li>
                <li>Friend 3</li>
                <!-- Add more friends here -->
            </ul>
        </div>
        <div class="chat-area">
            <div class="message-list">
                <!-- Messages between you and the selected friend -->
            </div>
            <div class="message-input">
                <input type="text" placeholder="Type your message...">
                <button>Send</button>
            </div>
        </div>
    </div>
    <script>
        // Add your JavaScript code here
        const friendsList = document.querySelectorAll('.friends-list li');
        const messageList = document.querySelector('.message-list');
        const messageInput = document.querySelector('.message-input input[type="text"]');
        const sendButton = document.querySelector('.message-input button');

        // Initialize chat with the first friend
        friendsList[0].classList.add('active');
        // You can load the chat history for the first friend here

        // Switch chat when clicking on a friend
        friendsList.forEach(friend => {
            friend.addEventListener('click', () => {
                friendsList.forEach(f => f.classList.remove('active'));
                friend.classList.add('active');
                messageList.innerHTML = ''; // Clear previous chat messages
                // Load the chat history for the selected friend here
            });
        });

        // Send message when clicking the send button
        sendButton.addEventListener('click', () => {
            const messageText = messageInput.value.trim();
            if (messageText !== '') {
                // Add the message to the message list
                messageList.innerHTML += `<div class="message">${messageText}</div>`;
                messageInput.value = ''; // Clear the input
                // Send the message to the recipient (you can implement this part)
            }
        });
    </script>
</body>
</html>
