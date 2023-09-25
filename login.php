<?php require_once('auth.php') ?>
<?php require_once('vendor/autoload.php') ?>
<?php
$clientID = "1016063083561-lfbtqcer7846qdatpuvcggs934f0aut9.apps.googleusercontent.com";
$secret = "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";

// Google API Client
$gclient = new Google_Client();

$gclient->setClientId($clientID);
$gclient->setClientSecret($secret);
$gclient->setRedirectUri('https://login.megatirfan.com/login.php');


$gclient->addScope('email');
$gclient->addScope('profile');

if(isset($_GET['code'])){
    // Get Token
    $token = $gclient->fetchAccessTokenWithAuthCode($_GET['code']);

    // Check if fetching token did not return any errors
    if(!isset($token['error'])){
        // Setting Access token
        $gclient->setAccessToken($token['access_token']);

        // store access token
        $_SESSION['access_token'] = $token['access_token'];

        // Get Account Profile using Google Service
        $gservice = new Google_Service_Oauth2($gclient);

        // Get User Data
        $udata = $gservice->userinfo->get();
        foreach($udata as $k => $v){
            $_SESSION['login_'.$k] = $v;
        }
        $_SESSION['ucode'] = $_GET['code'];

        header('location: ./');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</head>
<body>
   
    </nav>
    <div class="container my-5">
        <div class="row">
            <div class="col-auto mx-auto">
                <a href="<?= $gclient->createAuthUrl() ?>" class="btn btn btn-danger btn-flat rounded-0">Login with Google</a>
            </div>
        </div>
    </div>
</body>
</html>