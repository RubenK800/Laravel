<body>
<div id="albumNames">

</div>
<script>
let albumNames = <?php echo json_encode($albumNames)?>;
let albumDirectories = <?php echo json_encode($albumDirectories)?>;

let userFirstName = "<?php echo $userFirstName?>";
let userLastName = "<?php echo $userLastName?>";

for (let i=0; i<albumNames.length; i++){
    let a = document.createElement('a');
    a.innerHTML = albumNames[i];
    a.setAttribute('style', 'margin:10px');
    a.setAttribute('href',"http://localhost/load-other-user-photos?q=\""+albumNames[i]+"\"&fname=\""+userFirstName+"\"&lname=\""+userLastName+"\"");
    let div = document.createElement('div');
    div.appendChild(a);
    let mainDiv = document.getElementById('albumNames');
    mainDiv.appendChild(div);
    mainDiv.setAttribute('style','display:grid; grid-gap: 1px; grid-template-columns: repeat(3, 1fr); margin-left: 150px;');
}



//const xHttp = new XMLHttpRequest();

// xHttp.open("Get", "./delete-photos?q=" + query[i].picture_directory);
// xHttp.onload = function() {
//     let responseText = xHttp.responseText;
//     console.log(responseText);
// }
// xHttp.send();
//alert(userFirstName+" "+userLastName);


</script>
</body>
<?php
