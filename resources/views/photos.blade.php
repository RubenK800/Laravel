<body>
<form id="upload" enctype="multipart/form-data" action="http://localhost/upload-new-album-image?q=<?php echo $_SERVER['REQUEST_URI']?>" method="post">
@csrf {{--    @csrf--}}
    <input id="img" type="file" name="img[]" multiple>
{{--    <input type="hidden" name="_token" value="{{ csrf_token() }}" />--}}
    <input type="submit" name="submit" value="Upload">
{{----    <input type="hidden" name="q" value="<?php echo $_SERVER['REQUEST_URI']?>">--}}
</form>
<?php
////https://websolutionstuff.com/post/laravel-8-form-class-not-found
//echo Form::open(array('url' => '/uploadfile', 'files' => 'true'));
//echo 'Select the file to upload.';
//echo Form::file('image');
//echo Form::submit('Upload File');
//echo Form::close();
//?>

{{--<button id="add-photo-btn">Upload</button>--}}

<?php //echo $_SERVER['REQUEST_URI']?>

<div id="ohh">

</div>
<br>

<div id="delete-button-div">
    <button id="delete-button" style="display: block; margin: auto; height: 50px; color: black; border-color: black; background-color: white">
        Delete all selected pictures from server and database
    </button>
</div>

<script>
    //this value we got from the controller which opened this view
    let query = <?php echo json_encode($query); ?>;
    let albumName = <?php echo $albumName; ?>;
    let sessionEmail = "<?php echo $session_email; ?>";
       // alert(sessionEmail);
    let array = JSON.stringify(query);
    //albumName =

    let formData = new FormData();

    // <input type="checkbox" id="myCheckbox1" />
    // <label for="myCheckbox1"><img src="http://someurl" /></label>

    //alert("DB:"+query[1].album_name+" ,but we choosed this album:" + albumName);
    for (let i=0; i<query.length; i++) {
        if (query[i].album_name === albumName && query[i].email === sessionEmail) {
            let input = document.createElement('input');
            input.setAttribute('type', 'checkbox');
            input.setAttribute('id', 'input'+i);
            document.getElementById('ohh').append(input);

            let img = document.createElement('img');
            img.setAttribute('src', query[i].picture_directory);
            img.setAttribute('width', "266px");
            img.setAttribute('height','266px');
            img.setAttribute('id', 'image'+i);
//document.getElementById('ohh').append(img);

            let label = document.createElement('label');
            label.setAttribute('for', 'input');
            label.appendChild(img);

            let div = document.createElement('div');
            //div.setAttribute('id','check');

            div.appendChild(input);
            div.appendChild(label);
            let mainDiv = document.getElementById('ohh');
            mainDiv.setAttribute('style', 'display:flex; flex-wrap: wrap; justify-content: center;');
            mainDiv.append(div);
            //document.getElementById('ohh').append(label);

            let button = document.getElementById('delete-button');
            //вместо button.addEventListener, ранее был input.addEventListener
            button.addEventListener('click', function () {
                if (input.checked === true) {
                    const xHttp = new XMLHttpRequest();
                    // console.log("dirname = " + input.id);
                    // console.log("image directory = " + query[i].picture_directory);

                    xHttp.open("Get", "./delete-photos?q=" + query[i].picture_directory);
                    xHttp.onload = function() {
                        let responseText = xHttp.responseText;
                        console.log(responseText);
                    }
                    xHttp.send();
                    document.getElementById('image'+i).remove();
                    //alert("I DON'T BELIEVE THIS!!!");
                }
            });
        }
    }

/*document.getElementById('ponch').addEventListener('click',function (){
    document.getElementById('ponch').remove();
})*/


</script>
</body>
<?php

//https://stackoverflow.com/questions/30663562/use-images-like-checkboxes/30663705
