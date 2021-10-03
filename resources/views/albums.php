<body>
<form id="addNewAlbum">
    <div>
        <label>
            <input type="text" name="newAlbumName" id = "addName">
        </label>
    </div>
</form>

<div id="newAlbum">
    <button id="addNewAlbumBtn">Add New Album</button>
</div>

<br>

<button id="delete-button" style="display: block; margin: auto; height: 50px; color: black; border-color: black; background-color: white">
    Delete all selected albums
</button>

<div id="response">
    <div id="albums">
<!--        --><?php //include('display_db_data.php');?>
    </div>
</div>

<script>
    function loadAlbums(){
        const xHttp = new XMLHttpRequest();
        let request = "getAlbums"
        xHttp.open("Get", "./albums-get?q=" + request);
        xHttp.onload = function() {
            let responseText = /*JSON.parse(*/xHttp.response/*)*/;
            let jsonParse = JSON.parse(responseText);
            let div = document.getElementById('albums');
            // "id":"34","album_name":"oops","user_email":"kubalyan-ruben@mail.ru","album_directory":".\/pic-albums\/oops_kubalyan-ruben@mail.ru"
            let responseArray = [];
            let responseArrayArray = [];
            for (let i=0; i<jsonParse.length; i++){
                responseArrayArray.push(jsonParse[i].id, jsonParse[i].album_name, jsonParse[i].user_email, jsonParse[i].album_directory)
                responseArray.push(responseArrayArray);
                responseArrayArray = [];
            }

            for (let i=0; i<responseArray.length; i++){
                let input = document.createElement('input');
                input.setAttribute('type', 'checkbox');
                input.setAttribute('id', 'input'+i);
                let newAlbumElement = document.getElementById('albums');
                //newAlbumElement.append(input);
                let div = document.createElement('div');


                let albumElement = document.createElement('a');
                albumElement.appendChild(document.createTextNode((i+1)+") "+responseArray[i][1]));
                //let directory = responseArray[i][3].replace(responseArray[i][3].charAt(0),'');
                albumElement.setAttribute('href',"http://localhost/get-photos?q=\""+responseArray[i][1]+"\"");
                //console.log("responseArray[i][1] = "+responseArray[i][1]);
                albumElement.setAttribute('id','album'+i);
                let br = document.createElement('br');
                //let newAlbumElement = document.getElementById('albums');
                newAlbumElement.append(br);
                newAlbumElement.append(albumElement);

                div.append(input);
                div.append(albumElement);
                newAlbumElement.setAttribute('style', 'display:grid; grid-gap: 1px; grid-template-columns: repeat(3, 1fr); ');
                newAlbumElement.append(div);

                let button = document.getElementById('delete-button');
                //вместо button.addEventListener, ранее был input.addEventListener
                button.addEventListener('click', function () {
                    if (input.checked === true) {
                        const xHttp = new XMLHttpRequest();

                        xHttp.open("Get", "./delete-albums?q=" + document.getElementById('album'+i).getAttribute('href'));
                        xHttp.onload = function() {
                            let responseText = xHttp.responseText;
                            //console.log(responseText);
                        }

                        xHttp.send();
                        document.getElementById('album'+i).remove();
                        //alert(document.getElementById('album'+i).getAttribute('href'));
                    }
                });
            }
        }
        xHttp.send();
    }
    loadAlbums();

    document.getElementById('addNewAlbumBtn').addEventListener("click", function (){
        let newAlbumName = document.getElementById('addName').value;
        const xHttp = new XMLHttpRequest();
        xHttp.open("Get", "./album-directory?q=" + newAlbumName);
        xHttp.onload = function() {
            let responseText = xHttp.responseText;
            let responseTextFiltered = responseText.split("|")[0];
            console.log(responseText);
            //document.getElementById("response").innerText = responseTextFiltered;
            if (responseTextFiltered === 'OK'){
                let albumElement = document.createElement('a');
                albumElement.appendChild(document.createTextNode(newAlbumName));
                let directory = responseText.split("|")[1].replace(responseText.split("|")[1].charAt(0),'');
                //"/pic-albums/".$dataFromClientSide."_".session()->get('email');
                //albumElement.setAttribute('href',"http://localhost/albums"/*".."+directory*//*'http://images6.fanpop.com/image/photos/42900000/Rea-l-mayer-ergo-proxy-42997029-850-1100.jpg'*//*"*/<?php /*echo base_url('/profile-pic/p.kubalyan-ruben@mail.ru.jpg')*/?>///*"*//*directory*/);
                let br = document.createElement('br');
                let newAlbumElement = document.getElementById('newAlbum');
                newAlbumElement.append(br);
                newAlbumElement.append(albumElement);
                //alert(directory);
            } else if (responseText==='NO'){
                alert("Album with that name already exists! Please try another name");
            }
            //alert(xHttp.response);
            loadAlbums();
        }
        xHttp.send();
    });

</script>
</body>

<?php
