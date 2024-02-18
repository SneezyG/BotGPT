
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bot Service</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="title">
          <span class="title-txt"> Sneezy Bot</span>
          <br>
          <img class="loader" src="static.svg" />
        </div>
        <div class="form">
            <div class="bot-inbox inbox">
                <div class="icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="msg-header">
                    <p>Hello there, how can I help you?</p>
                </div>
            </div>
        </div>
        <div class="typing-field">
            <div class="input-data">
                <input id="data" type="text" placeholder="Type something here.." required>
                <button id="send-btn">Send</button>
            </div>
        </div>
    </div>

    <script>
    
    $OPENAI_API_KEY = "xxxxx";
    
    $lastPrompt = "";
    $lastReply = "";
    
    $(document).ready(function(){
        $("#send-btn").on("click", function(){
            $userPrompt = $("#data").val();
            $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>'+ $userPrompt +'</p></div></div>';
            $(".form").append($msg);
            $("#data").val('');
            
            setTimeout(() => {
              $(".loader").attr("src", "loader.svg");
            }, 500)
            
            $botReply = "";
            
            $.ajax({
              url: "https://api.openai.com/v1/chat/completions",
              type: "POST",
              headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${$OPENAI_API_KEY}`,
              },
              data: JSON.stringify({
                'model': 'gpt-3.5-turbo',
                'messages': [
                  {
                   'role': "user",
                   'content': $lastPrompt
                  },
                  {
                   'role': "assistant",
                   'content': $lastReply
                  },
                  {
                   'role': "user",
                   'content': $userPrompt
                  }
                 ]
              }),
              success: function(data) {
               $botReply = data['choices'][0]['message']['content'];
               $reply = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ $botReply +'</p></div></div>';
                console.log("Success:", data);
              },
              error: function(xhr, status, error) {
                $reply = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>'+ 'bot cannot process your prompt now' +'</p></div></div>';
                console.log("Failed to generate response")
                console.error("Error:", status, error);
              },
              complete: function() {
                $(".form").append($reply);
                $(".form").scrollTop($(".form")[0].scrollHeight);
            
                // persist data in front-end
                $lastPrompt = $userPrompt;
                $lastReply = $botReply;
                
                setTimeout(() => {
                 $(".loader").attr("src", "static.svg");
                }, 500);
                
                console.log($userPrompt, $botReply);
            
                // start ajax code
                $.ajax({
                  url: 'message.php',
                  type: 'POST',
                  data: {
                    query: $userPrompt,
                    reply: $botReply
                  },
                  success: function(){
                    console.log('Data persisted successfully');
                 }
                });

                console.log("Request complete.");
              }
            });
            
                        
        });
    });
    </script>
    
</body>
</html>
