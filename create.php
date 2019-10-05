<?php
    class Profile {
        public $email;
        public $password;

        public function __construct($em, $psw) {
            $this->email = $em;
            $this->password = $psw;
        }
    }

    $psw_list = json_decode(file_get_contents('pass.json'));
    $mail_flag = 0;
    for ($i = 0; $i < count($psw_list->Users); $i++) {
        if($psw_list->Users[$i]->email == $_GET['email'])
            $mail_flag = 1;
    }
    if (!$mail_flag) {
        if ($_GET['password'] == $_GET['confirm']) {
            array_push($psw_list->Users, new Profile($_GET['email'], hash('md5', $_GET['password'])));
            file_put_contents('pass.json', json_encode($psw_list));
            require('congr.html');
        }
        else {
            ?>
            <script>alert("Not equal passwords")</script>
            <?php
            require('signup.html');
        }
    }
    else {
        ?>
        <script>alert("That email already exists")</script>
        <?php
        require('signup.html');
    }
?>