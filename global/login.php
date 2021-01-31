<?php
    if($page === "logout") {
        $me->logout();

        header("location: /");
        die();
    }

    if(isset($_POST["login"])) {
        $mustdocaptcha = false;

        $temp = new User();
        $temp->getFromDB($_POST["username"], "username");
        if($temp->getLoginattempts() > 2) {
            $mustdocaptcha = true;
        }

        $validcaptcha = false;
        if(!empty($_POST["captcha"])) {
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfLmT8UAAAAAKS-WTg2LdD-OH9uCtz4BRwcLSVz&response=".$_POST["captcha"]."&remoteip=".getIP());
            $obj = json_decode($response);
            if($obj->success == true) {
                $validcaptcha = true;
            }

            if(!$validcaptcha && $mustdocaptcha) {
                die("Captcha not valid!");
            }
        } elseif($mustdocaptcha) {
            die("false1");
        }

        try {
            $user = new User();
            $user->setUsername($_POST["username"], true);
            $user->setPassword($_POST["password"]);

            if($user->login()) {
                die("true");
            }
        } catch (Exception $ex) {
            die($ex->getMessage());
        }

        die("Unknown error!");
    }
