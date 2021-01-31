<?php
    if(isset($_POST["keeponline"])) {
        if($me->IsLoggedIn()) {
            try {
                $online = new Online();
                $online->getFromDB($me->getId());

                if ($online->getId()) {
                    $online->setKeeponline(time());
                    $online->setIp(getIP());
                    $online->update();
                } else {
                    $me->logout("Timeout");

                    die("true");
                }
            } catch (Exception $ex) { }
        }

        die();
    }
