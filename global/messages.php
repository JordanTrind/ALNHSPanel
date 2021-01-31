<?php
    if(isset($_POST["send_message"])) {
        if($me->IsLoggedIn()) {
            $group = $_POST["group"];
            $userid = $_POST["userid"];
            $subject = $_POST["subject"];
            $content = $_POST["content"];

            $to = "";
            if($group === "specific_user") {
                $to = $userid;
            } elseif($group === "everyone") {
                $users = new User();
                $result = $users->getFromDB(null, null, "result");
                if($result->num_rows > 0) {
                    while($row = $result->fetch_object()) {
                        $user = new User($row);

                        $hide = array(
                            "1",
                            "6",
                            "3",
                            "5",
                            "67",
                            "66"
                        );

                        if(!in_array($user->getId(), $hide)) {
                            $to .= $user->getId().",";
                        }
                    }
                }
            } else {
                $users = new User();
                $result = $users->getFromDB(null, null, "result");
                if($result->num_rows > 0) {
                    while($row = $result->fetch_object()) {
                        $user = new User($row);

                        $hide = array(
                            "1",
                            "6",
                            "3",
                            "5",
                            "67",
                            "66"
                        );

                        if($user->hasPermission($group) && !in_array($user->getId(), $hide)) {
                            $to .= $user->getId().",";
                        }
                    }
                }
            }

            $to = trim($to, ",");

            if($to !== "") {
                $message = new Message();
                $message->setSender($me->getId());
                $message->setReceiver($to);
                $message->setSubject($subject);
                $message->setContent($content);
                $message->setSent(time());
                if($message->insert()) {
                    die("true");
                }
            }
        }

        die("false");
    }
