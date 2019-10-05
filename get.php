<?php
    $psw_list = json_decode(file_get_contents('pass.json'));
    for ($i = 0; $i < count($psw_list->Clients); $i++)
            if ($psw_list->Clients[$i]->email == $_GET['email'])
                for ($j = 0; $j < count($psw_list->Clients[$i]->token); $j++)
                    if (isset($_COOKIE["token"]) && ($psw_list->Clients[$i]->token[$j] == $_COOKIE["token"])){
                        require('account.php');
                        exit();
                    }

    class Client {
            public $email;
            public $token;
            public function __construct($em, $tk) {
                $this->email = $em;
                $this->token = array($tk);
            }
    }

    function check_psw($psw_list, $i) {
        if ($psw_list->Users[$i]->password == hash('md5', $_GET['password'])) {
            return 1;
        }
        return 0;
    }

    function make_cookie($token, $psw_list){
        if (count($psw_list->Clients) == 0){
            $psw_list->Clients = array(new Client($_GET['email'], $token));
            setcookie("token", $token, time()+3600);
        }
        else {
            for ($i = 0; $i < count($psw_list->Clients); $i++){
                if ($psw_list->Clients[$i]->email == $_GET['email']){
                   array_push($psw_list->Clients[$i]->token, $token);
                   setcookie("token", $token, time()+3600);
                   break;
                }
                if ($i+1 == count($psw_list->Clients)){
                   array_push($psw_list->Clients, new Client($_GET['email'], $token));
                   setcookie("token", $token, time()+3600);
                   break;
                }
            }
        }
        file_put_contents('pass.json', json_encode($psw_list));
    }

	$alert_flag = 0;
    for ($i = 0; $i < count($psw_list->Users); $i++) {
    		if($psw_list->Users[$i]->email == $_GET['email']) {
    		    if(!check_psw($psw_list, $i))
    		        $alert_flag = 1;
    		    else
    		        $alert_flag = 0;
    		    break;
    		}
    		else {
    		    $alert_flag = 1;
            }
    }
    if ($alert_flag) {
        ?>
        <script>alert("Incorrect mail or/and password")</script>
        <?php
        require('auth.php');
    }
    else {
        make_cookie(bin2hex(random_bytes(32)), $psw_list);
        require('account.php');
    }
?>

