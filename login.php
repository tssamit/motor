<?php
session_start();
require_once 'config/config.php';
//require_once 'config/helper.php';
require_once 'config/chkLogin.php';
?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta name="description" content="Transport Management">
        <meta name="keywords" content="Transport Management, transport, vehicle">

        <?php require_once 'header.php'; ?>
    </head>


    <body data-theme="light" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
        <main class="d-flex w-100 h-100">
            <div class="container d-flex flex-column">
                <div class="row vh-100">
                    <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-75">
                        <div class="d-table-cell align-middle">

                            <!--                            <div class="text-center mt-4">
                                                            <h1 class="h2">Welcome back, Charles</h1>
                                                            <p class="lead">
                                                                Sign in to your account to continue
                                                            </p>
                                                        </div>-->

                            <div class="card">
                                <div class="card-body">
                                    <?php include_once 'errormsg.php'; ?>
                                    <div class="m-sm-4">
                                        <div class="text-center">
                                            <img src="img/logo.png" alt="Charles Hall" class="img-fluid" style=" max-height: 180px;" />
                                        </div>

                                        <form method="post" action="pages/loginvalidate.php" enctype="multipart/form-data" class="needs-validation" novalidate>
                                            <div class="mb-3">
                                                <label class="form-label">User ID</label>
                                                <input class="form-control form-control-lg" type="email" name="username" placeholder="User ID" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Password</label>
                                                <input class="form-control form-control-lg" type="password" name="passwword" placeholder="Enter your password" required />
<!--                                                <small>
                                                    <a href="reset-password">Forgot password?</a>
                                                </small>-->
                                            </div>
                                            <div>
                                                <!--                                                <label class="form-check">
                                                                                                    <input class="form-check-input" type="checkbox" value="remember-me" name="remember-me" checked>
                                                                                                    <span class="form-check-label">
                                                                                                        Remember me next time
                                                                                                    </span>
                                                                                                </label>-->
                                            </div>
                                            <div class="text-center mt-3">
                                                <!--                                                <a href="index.html" class="btn btn-lg btn-primary">Sign in</a>-->
                                                <!-- <button type="submit" class="btn btn-lg btn-primary">Sign in</button> -->
                                                <button class="btn btn-primary " type="submit">Login</button>
                                                <input type="hidden" name="submit" value="login">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>




    </body>


</html>