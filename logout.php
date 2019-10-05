<?php
    $psw_list = json_decode(file_get_contents('pass.json'));
    for ($i = 0; $i < count($psw_list->Clients); $i++)
        if ($psw_list->Clients[$i]->email == $_GET['email'])
            for ($j = 0; $j < count($psw_list->Clients[$i]->token); $j++)
                if (isset($_COOKIE["token"]) && ($psw_list->Clients[$i]->token[$j] == $_COOKIE["token"])){
                    array_splice($psw_list->Clients[$i]->token, $j, 1);
                    setcookie("token", "", time()-3600);
                }
    file_put_contents('pass.json', json_encode($psw_list));
    require('auth.php');
?>