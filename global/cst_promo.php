<?php
    function show_cst_promo($showall = false) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.roleplay.co.uk/v1/factions/nhs/playtime",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $results = curl_exec($curl);
        curl_close($curl);

        $online_times = (array)json_decode($results);

        $curl2 = curl_init();
        curl_setopt_array($curl2, array(
            CURLOPT_URL => "https://api.roleplay.co.uk/v1/factions/nhs/lastlogin",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $results2 = curl_exec($curl2);
        curl_close($curl2);

        $lastlogin_times = (array)json_decode($results2);

        $sorted_players = array();
        $ordered_players_login = array();
        $ordered_players_rank = array();
        $ordered_players_department = array();

        $players = new Playerdata();
        $result = $players->getFromDB(NULL, NULL, "result");
        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $player = new Playerdata($row);

                if(strtolower($player->getActivityStatus()) === "active" && ($player->getDepartment() == "November" || $player->getDepartment() == "Training" || $player->getDepartment() == "Hector" || $player->getDepartment() == "Sierra" || $player->getDepartment() == "Seniors" || $player->getDepartment() == "Consultants")) {
                    //$login_datetime = DateTime::createFromFormat('d/m/Y H:i:s', $player->getLogin());
                    $login_datetime = false;
                    foreach($lastlogin_times as $data) {
                        if($data->steamid === trim($player->getSteamID64(), '"')) {
                            $login_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $data->nhslastlogin);
                            break;
                        }
                    }

                    $show = $showall;

                    $login_timestamp = 0;
                    if($login_datetime) {
                        $login_timestamp = $login_datetime->getTimestamp();

                        $now = new DateTime();
                        $diff = $login_datetime->diff($now)->format("%a");

                        if($diff <= 14) {
                            $show = true;
                        }
                    }

                    if($show) {
                        $sorted_players[] = array(
                            "login_timestamp" => $login_timestamp,
                            "player" => $player
                        );
                    }
                }
            }
        }

        usort($sorted_players, function($a, $b) {
            return($b['login_timestamp'] - $a['login_timestamp']);
        });

        $department_order = array(
            "Training",
            "November",
            "Hector",
            "Sierra",
            "Seniors",
            "Consultants"
        );

        $rank_order = array(
            "STU",
            "FA",
            "PAR",
            "SUR",
            "DR",
            "CST"
        );

        foreach($rank_order as $rank) {
            foreach($sorted_players as $data) {
                $player = $data["player"];

                if($player->getRank() === $rank) {
                    $ordered_players_login[] = $player;
                }
            }
        }

        foreach($rank_order as $rank) {
            foreach($ordered_players_login as $player) {
                if($player->getRank() === $rank) {
                    $ordered_players_rank[] = $player;
                }
            }
        }

        foreach($department_order as $department) {
            foreach($ordered_players_rank as $player) {
                if($player->getDepartment() === $department) {
                    $ordered_players_department[] = $player;
                }
            }
        }

        foreach($ordered_players_department as $player) {
            $class = "";
            if($player->getDepartment() == "Training") {
                $class = " class='success'";
            } else if($player->getDepartment() == "November") {
                $class = " class='info'";
            } else if($player->getDepartment() == "Hector") {
                $class = " class='pink'";
            } else if($player->getDepartment() == "Sierra") {
                $class = " class='purple'";
            } else if($player->getDepartment() == "Seniors") {
                $class = " class='orange'";
            } else if($player->getDepartment() == "Consultants") {
                $class = " class='danger'";
            }

            $now = new DateTime();

            $login_datetime = false;
            foreach($lastlogin_times as $data) {
                if($data->steamid === trim($player->getSteamID64(), '"')) {
                    $login_datetime = DateTime::createFromFormat('Y-m-d H:i:s', $data->nhslastlogin);
                    break;
                }
            }

            $login_class = "";
            if($login_datetime) {
                $diffsincelastlogin = $now->diff($login_datetime);
                if($diffsincelastlogin->days <= 6) {
                    $login_class = " class='dark_blue'";
                }
            }

            $join_class = "";
            if($player->getRank() === "STU") {
                $join_datetime = DateTime::createFromFormat('d/m/Y', $player->getJoinDate());
                if($join_datetime) {
                    $diffsincejoin = $now->diff($join_datetime);
                    if($diffsincejoin->days <= 3) {
                        $join_class = " class='danger'";
                    }
                }
            }

            $promo_class = "";
            $promo_datetime = DateTime::createFromFormat('d/m/Y', $player->getPromo());
            if($promo_datetime) {
                $diffsincepromo = $now->diff($promo_datetime);
                if($player->getRank() === "FA") {
                    if($diffsincepromo->days <= 6) {
                        $promo_class = " class='danger'";
                    }
                }
                if($player->getRank() === "PAR") {
                    if($diffsincepromo->days <= 30) {
                        $promo_class = " class='danger'";
                    }
                }
                if($player->getRank() === "SUR") {
                    if($diffsincepromo->days <= 60) {
                        $promo_class = " class='danger'";
                    }
                }
            }

            echo "<tr class='narrow'>";
                echo "<td".$class.">".$player->getDepartment()."</td>";
                echo "<td>".$player->getName()."</td>";
                echo "<td>".$player->getRank()."</td>";
                echo "<td>".$player->getSteamID64()."</td>";
                echo "<td".$join_class.">".$player->getJoinDate()."</td>";
                echo "<td".$promo_class.">".$player->getPromo()."</td>";


                if($login_datetime) {
                    $lastlogin = $login_datetime->format("d/m/Y");
                } else {
                      $lastlogin = "NONE";
                }

                echo "<td".$login_class.">".$lastlogin."</td>";

                $cleandatetime = new Datetime("@0");

                $total_time_interval = false;
                $total_time = $online_times[trim($player->getSteamID64(), '"')]->total;
                if($total_time) {
                    $online_datetime = new DateTime("@".$total_time);
                    $total_time_interval = $online_datetime->diff($cleandatetime);
                }
                $thirtyDays_time_interval = false;
                $thirtyDays_time = $online_times[trim($player->getSteamID64(), '"')]->thirtyDays;
                if($thirtyDays_time) {
                    $online_datetime = new DateTime("@".$thirtyDays_time);
                    $thirtyDays_time_interval = $online_datetime->diff($cleandatetime);
                }
                $sevenDays_time_interval = false;
                $sevenDays_time = $online_times[trim($player->getSteamID64(), '"')]->sevenDays;
                if($sevenDays_time) {
                    $online_datetime = new DateTime("@".$sevenDays_time);
                    $sevenDays_time_interval = $online_datetime->diff($cleandatetime);
                }

                $time_total = "None";
                $time_thirtyDays = "None";
                $time_sevenDays = "None";

                $time_class_total = "";
                $time_class_thirtyDays = "";
                $time_class_sevenDays = "";
                if(isset($online_times[trim($player->getSteamID64(), '"')])) {
                    $time_total = DiffString($total_time_interval, "Under 3 minutes", true);
                    if($time_total === "Under 3 minutes") {
                        $time_class_total = " class='danger'";
                    }
                    $time_thirtyDays = DiffString($thirtyDays_time_interval, "Under 3 minutes", true);
                    if($time_thirtyDays === "Under 3 minutes") {
                        $time_class_thirtyDays = " class='danger'";
                    }
                    $time_sevenDays = DiffString($sevenDays_time_interval, "Under 3 minutes", true);
                    if($time_sevenDays === "Under 3 minutes") {
                        $time_class_sevenDays = " class='danger'";
                    }
                    if(strpos($time_sevenDays,'hours') !== false) {
                        $time_class_sevenDays = " class='success'";
                    }
                }

                //echo "<td".$time_class_total.">".$time_total."</td>";
                echo "<td".$time_class_thirtyDays.">".$time_thirtyDays."</td>";
                echo "<td".$time_class_sevenDays.">".$time_sevenDays."</td>";
            echo "</tr>";
        }
    }

    if(isset($_POST["cst_promo"])) {
        show_cst_promo($_POST["cst_promo"] === 'true' ? true : false);

        die("");
    }
