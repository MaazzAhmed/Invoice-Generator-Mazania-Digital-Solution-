<?
// Check if the user is logged in

if (isset($_POST['logout_user'])) {

    session_start();
    
    $access_token_own = "123";
    
    $access_token = $_POST['access_token'];
    
    if ($access_token === $access_token_own) {
        
        
        session_unset();
            session_destroy();



    }

    header('Location: login'); // Replace 'login.php' with your login page URL
    exit;

}