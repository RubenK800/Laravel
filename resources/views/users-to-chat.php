<body>
<div id = "users">
</div>

<script>
    let usersFirstNames = <?php echo json_encode($userFirstNames) ?>;
    let usersLastNames = <?php echo json_encode($userLastNames) ?>;

    if (usersFirstNames.length === usersLastNames.length) {
        for (let i=0; i<usersLastNames.length; i++){
            let div = document.createElement('div');
            let userNameELement = document.createElement('a');
            userNameELement.innerHTML = usersFirstNames[i] + " " + usersLastNames[i];
            let str = usersFirstNames[i] + "|" + usersLastNames[i];
            userNameELement.setAttribute('href',"http://localhost/open-chat?q=\"" + str + "\"");
            let mainDiv = document.getElementById('users');
            div.append(userNameELement);
            div.append(document.createElement('br'));
            mainDiv.appendChild(div);
        }
    }

</script>
</body>
<?php
