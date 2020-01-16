<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>ERP | Log in</title>
        <link rel="icon" type="img/ico" href="">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php if(!$this->isLocal){ ?>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <?php } else { ?>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <?php } ?>
        <!-- Theme style -->
        <link href="<?php echo BASE_PATH; ?>assets/AdminLTE/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="https://apis.google.com/js/client:platform.js" async defer></script>

        <meta name="google-signin-clientid" content="1084582480401-rrg6gbi8cd4110upci0vfvjlumh6vqid.apps.googleusercontent.com" />
        <meta name="google-signin-scope" content="https://www.googleapis.com/auth/plus.login" />
        <meta name="google-signin-requestvisibleactions" content="http://schema.org/AddAction" />
        <meta name="google-signin-cookiepolicy" content="single_host_origin" />
    </head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form action="" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="email" class="form-control" placeholder="Username" value="<?php echo (isset($email)) ? $email:'';?>" required email/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" required/>
                    </div>  
                    <!--
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                    -->
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    <!--
                    <p><a href="#">I forgot my password</a></p>
                    
                    <a href="register.html" class="text-center">Register a new membership</a>
                    -->
                </div>
            </form>
            <!--div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <!--fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                </fb:login-button--
                
                <a href="<?php echo base_url('hauth/login/Facebook'); ?>"><button class="btn bg-light-blue btn-circle" scope="public_profile,email" onlogin="FB.login();"><i class="fa fa-facebook"></i></button></a>
                <a href="<?php echo base_url('hauth/login/Google'); ?>"><button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button></a>
            </div-->
        </div>
        <?php if(!$this->isLocal){ ?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <?php } else { ?>
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/cdn/js/jquery.min.js"></script>
        <script src="<?php echo BASE_PATH; ?>assets/AdminLTE/cdn/js/bootstrap.min.js" type="text/javascript"></script>
        <?php } ?>
    </body>
</html>