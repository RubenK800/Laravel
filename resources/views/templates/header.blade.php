<!DOCTYPE html>
<html lang='en' dir='ltr'>
<head>
    <meta charset='utf-8'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css' rel='stylesheet'
          integrity='sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We' crossorigin='anonymous'>
    <link href='/assets/css/style.css' rel='stylesheet'>
    <title></title>
    <meta name="csrf-token" content="{{csrf_token()}}">
</head>
<body>
<?php $uri = request();?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/">Ci4 Login</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <?php if (session()->get('isLoggedIn')): ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?= ($uri->segment(1) === 'dashboard' ? 'active':null); ?>">
                    <a class="nav-link active" aria-current="page" href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item" <?= ($uri->segment(1) === 'profile' ? 'active':null); ?>">
                    <a class="nav-link" href="/profile">Profile</a>
                </li>
            </ul>
            <ul class="navbar-nav my-2 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Logout</a>
                </li>
            </ul>
        <?php else: ?>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item" <?= ($uri->segment(1) == '' ? 'active':null); ?>">
                    <a class="nav-link active" aria-current="page" href="#">Login</a>
                </li>
                <li class="nav-item" <?= ($uri->segment(1) == 'register' ? 'active':null); ?>">
                    <a class="nav-link" href="/register">Register</a>
                </li>
            </ul>
        </div>

        <?php endif; ?>
    </div>
</nav>
<!--</body>-->
<!--</html>-->
<?php

