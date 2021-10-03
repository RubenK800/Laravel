<div class="container">
    <div class="row">
        <div class="col-12 col-sm8- offset-sm2 col-md-6 offset-md3 mt-5 pt-3 pb-3 bg-white from-wrapper">
            <div class="container">
                <h3>Login</h3>
                <hr>
                <?php if (session()->get('success')):?>
                    <div class="alert alert-success" role="alert">
                        <?= session()->get('success');?>
                    </div>
                <?php endif; ?>
                <form class="" action="/" method="post">
                    {{--https://stackoverflow.com/questions/44037689/laravel-5-4-csrf-field-not-working--}}
                    <!--@csrf--> {{ csrf_field() }}
                    <div class = "form-group">
                        <label for="email">Email address</label>
                        <input type = "text" class="form-control" name="email" id="email"> <!--value="--><?/*= set_value('email') */?><!--"-->
                    </div>
                    <div class = "form-group">
                        <label for="password">Password</label>
                        <input type = "password" class="form-control" name="password" id="password" value="">
                    </div>
                    <?php if (isset($validation)):?>
                        <div class="col-12">
                            <div class="alert alert-danger" role="alert">
                                <?= $validation->listErrors(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                        <div class="col-12 col-sm-8 text-right">
                            <a href="/register">Don't have an account yet?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php

