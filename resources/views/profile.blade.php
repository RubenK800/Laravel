<div class="container">
    <div class="row">
        <div class="col-12 col-sm8- offset-sm2 col-md-6 offset-md3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3><?= $user['firstname'].' '.$user['lastname'];?></h3>
                <hr>
                <?php if (session()->get('success')):?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success'); ?>
                    </div>
                <?php endif; ?>

                <?php $avatarID = session()->get('email');
                //https://overcoder.net/q/39935/%D0%BA%D0%B0%D0%BA-%D1%81%D0%BE%D1%85%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D1%8C-%D1%81%D0%BE%D0%BE%D1%82%D0%BD%D0%BE%D1%88%D0%B5%D0%BD%D0%B8%D0%B5-%D1%81%D1%82%D0%BE%D1%80%D0%BE%D0%BD-%D0%B8%D1%81%D0%BF%D0%BE%D0%BB%D1%8C%D0%B7%D1%83%D1%8F-html-img-%D1%82%D0%B5%D0%B3
                echo '<img src="/profile-pic/p.'.$avatarID.'.jpg" alt="Ehhh" height="200">'
                ?>

<!--                <img src="/profile-pic/p--><?php //session()->get('email')?><!--.jpg" alt="Ehhh">-->

                <form action="/upload-avatar" method="post"
                      enctype="multipart/form-data">Upload Image
                    @csrf
                    <input type="file" name="img">
                    <input type="submit" name="submit">
                </form>
                <form class="" action="/profile" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class = "form-group">
                                <label for="firstname">First Name</label>
                                <input type = "text" class="form-control" name="firstname" id="firstname"
                                       value="<?php echo session()->get('firstname');?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class = "form-group">
                                <label for="lastname">Last Name</label>
                                <input type = "text" class="form-control" name="lastname" id="lastname"
                                       value="<?php echo session()->get('lastname');?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class = "form-group">
                                <label for="email">Email address</label>
                                <input type = "text" class="form-control" readonly id="email" value="<?= $user['email'] ?>">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class = "form-group">
                                <label for="password">Password</label>
                                <input type = "password" class="form-control" name="password" id="password" value="">
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class = "form-group">
                                <label for="password_confirm">Confirm Password</label>
                                <input type = "password" class="form-control" name="password_confirm" id="password_confirm" value="">
                            </div>
                        </div>

                        <?php if (isset($validation)):?>
                            <div class="col-12">
                                <div class="alert alert-danger" role="alert">
                                    <?= $validation->listErrors(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
//echo "<div class='container'>
//    <div class='row'>
//        <div class='col-12 col-sm8- offset-sm2 col-md-6 offset-md3 mt-5 pt-3 pb-3 bg-white from-wrapper'>
//            <div class='container'>
//                <h3>Login</h3>
//                <hr>
//                <form class='' action='/' method='post'>
//                    <div class = 'form-group'>
//                        <label for='email'>Email address</label>
//                        <input type = 'text' class='form-control' name='email' id='email' value='set_value(email)'>
//                    </div>
//                    <div class = 'form-group'>
//                        <label for='password'>Password</label>
//                        <input type = 'text' class='form-control' name='password' id='password' value=''>
//                    </div>
//                    <div class='row'>
//                        <div class='col-12 col-sm-4'>
//                            <button type='submit' class='btn btn-primary'>Login</button>
//                        </div>
//                        <div class='col-12 col-sm-8 text-right'>
//                            <a href='/register'>Don't have an account yet?</a>
//                        </div>
//                    </div>
//                </form>
//            </div>
//        </div>
//    </div>
//</div>";

