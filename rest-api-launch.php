<?php
/*
Plugin Name: REST API Launch
Description: Launch REST API
*/
require 'modules/user/user.php';
require 'modules/properity/properity.php';
require 'vendor/autoload.php';
require 'includes/activate.php';

use Firebase\JWT\JWT;

register_activation_hook(__FILE__, 'rest_api_launch_activation');
class REST_API_Launch
{
    function __construct()
    {
        add_action('admin_menu', array($this, 'addToMenu'));
    }

    function addToMenu()
    {
        add_menu_page('Launch REST API', 'Launch REST API', 'manage_options', 'launch-rest-api', array($this, 'launchPage'), 'dashicons-external', 10);
    }

    function launchPage()
    {
        echo '<h1>Launch REST API</h1>';
?>
        <div>
            <input type="text" name="username" id="username" placeholder="Enter Username Here">
            <input type="text" name="password" id="password" placeholder="Enter Password Here">
            <button id="login">LOGIN</button>
        </div>
        <script>
            let loginBtn = document.getElementById('login');
            loginBtn.addEventListener('click', () => {
                let username = document.getElementById('username').value;
                let password = document.getElementById('password').value;
                let data = {
                    username: username,
                    password: password
                }
                if (username == '' || password == '') {
                    alert("Please enter username and password");
                } else {
                    jQuery.post(
                        "https://toyagator.com/en/wp-json/alkamal/v0/user/login",
                        data,
                        function(response, status) {
                            console.log(response.data);
                        }
                    )
                }
            })
        </script>
<?php
    }
}
new REST_API_Launch();
