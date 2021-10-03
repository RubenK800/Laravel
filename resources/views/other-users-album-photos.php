<body>
<div id="main-div">

</div>
<script>
    let photosDirectories = <?php echo json_encode($photosDirectories)?>;
    let mainDiv = document.getElementById('main-div');
    mainDiv.setAttribute('style','display:flex; flex-wrap: wrap; justify-content: center;')
    for (let i = 0; i<photosDirectories.length; i++) {
        let div = document.createElement('div');
        let photo = document.createElement('img');
        photo.setAttribute('src',photosDirectories[i]);
        photo.setAttribute('height','200px');
        div.appendChild(photo);
        div.setAttribute('style','margin:10px');
        mainDiv.appendChild(div);
    }

    //document.getElementById('main-div').innerHTML = photosDirectories[0];
</script>
</body>
<?php
