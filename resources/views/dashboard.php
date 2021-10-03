<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>
                Hello, <?= session()->get('firstname') ?>
            </h1>
        </div>

        <div>
            <a href="http://localhost/albums">
                Albums
            </a>
        </div>

        <div>
            <a href="http://localhost/other-users-albums">
                Other Users Albums
            </a>
        </div>

        <div>
            <a href="http://localhost/users-to-chat">
                Messenger
            </a>
        </div>

    </div>
</div>
<script>
</script>
</body>
<?php
