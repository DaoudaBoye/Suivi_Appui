<!DOCTYPE html>
<html>
<head>
    <title>Chat Example</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #chat {
            max-width: 500px;
            margin: auto;
        }
        .message {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }
        .message p {
            padding: 10px;
            border-radius: 15px;
            max-width: 70%;
            word-wrap: break-word;
        }
        .user-message p {
            background-color: #DCF8C6;
            align-self: flex-end;
            color: #000
        }
        .other-message p {
            background-color: #ECE5DD;
            align-self: flex-start;
        }
        .replyBtn {
            background-color: #0084ff;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card mt-4">
            <div class="card-body" id="chat">
                <?php
                if(!empty($_SESSION['chat'])){
                    foreach($_SESSION['chat'] as $unique_id => $data){
                        echo "<div class='message " . ($data['user'] === 'User' ? 'user-message' : 'other-message') . "' data-id='" . $unique_id . "'><p><strong>" . $data['user'] . ":</strong> " . $data['message'] . " <button class='replyBtn' data-reply='" . $unique_id . "'>Reply</button></p></div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8">
                <input type="text" id="message" class="form-control" placeholder="Type your message here">
            </div>
            <div class="col-md-4">
                <button id="send" class="btn btn-primary btn-block">Send</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      
        $(document).ready(function(){
            $("#send").click(function(){
                var message = $("#message").val().trim();
                if (message !== '') {
                    $.ajax({
                        url: "",
                        method: "POST",
                        data: {msg: message},
                        success: function(response){
                            $("#chat").append(response);
                            $("#message").val('');
                        }
                    });
                }
            });

            $("#chat").on("click", ".replyBtn", function(){
                var replyToId = $(this).attr('data-reply');
                var replyMessage = prompt("Reply to this message:");
                if(replyMessage !== null && replyMessage.trim() !== '') {
                    $.ajax({
                        url: "",
                        method: "POST",
                        data: {msg_reply: replyMessage, reply_id: replyToId},
                        success: function(){
                            var replyMessageHtml = "<div class='reply'><strong>User:</strong> " + replyMessage + "</div>";
                            $("#chat").find("[data-id='" + replyToId + "']").append(replyMessageHtml);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
