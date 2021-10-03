<body>
<div style="width:100%;height:100%">
    <div id="chatDiv" style="overflow:scroll; height:600px;">

    </div>
    <div>
        <form>
            <label>
                <input id="message" type="text" style="text">
            </label>
        </form>
    </div>
    <div>
        <button id = 'sentMessage'>send message</button>
    </div>
</div>
<script>
    let userFirstName = "<?php echo $userFirstName?>";
    let userLastName = "<?php echo $userLastName?>";
    let arrayAlter = <?php echo json_encode($arrayAlter)?>;

    let ids = [];
    for (let i=0; i<arrayAlter.length; i++){
        let array = [];
        array.push(arrayAlter[i].split('|')[0]);
        let answerMessage = array[0];

        let chat = document.getElementById('chatDiv');
        let answerMessageElement = document.createElement('div');
        answerMessageElement.innerHTML = answerMessage;
        chat.appendChild(answerMessageElement);
    }


    let button = document.getElementById('sentMessage');
    button.addEventListener('click',function (){
        let message = document.getElementById('message').value;
        //alert ("your message is: " + message);
        let chat = document.getElementById('chatDiv');
        let sentMessage = document.createElement('div');
        let div = document.createElement('div');
        sentMessage.innerHTML = "You: " + message;
        sentMessage.setAttribute("style","white-space: pre-wrap;");
        div.appendChild(sentMessage);
        chat.appendChild(div);

        const xHttp = new XMLHttpRequest();

        xHttp.open("Get", "./store-ms-db?q=" + message+"&fname="+userFirstName+"&lname="+userLastName);
        xHttp.onload = function() {
            let responseText = xHttp.responseText;
            alert(responseText);
        }

        xHttp.send();
    });


</script>
</body>
<?php
