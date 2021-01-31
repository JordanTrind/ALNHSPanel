<?php
    if(isset($_POST["search_timesheet"])) {

        $timesheets = new Timesheet();
        $sql = "SELECT * FROM timesheet";

        $value = $timesheets->DBClear(trim($_POST["search_timesheet"]));

        if($value !== "") {
            $sql .= " WHERE trainee1id LIKE '%".$value."%' OR trainee2id LIKE '%".$value."%' OR trainee3id LIKE '%".$value."%'";
        }

        $sql .= " ORDER BY timestamp DESC";

        $result = $timesheets->runSQL($sql, "result");

        if($result->num_rows > 0) {
            $totalinterval = 0;
            $totalinterval_30days = 0;
            $totalinterval_7days = 0;

            $total_count = 0;

            while($row = $result->fetch_object()) {
                $timesheet = new Timesheet($row);

                echo "<tr>";
                    $timestampstring = substr($timesheet->getTimestamp(),0,-9);
                    echo "<td>".$timestampstring."</td>";
                    echo "<td>".$timesheet->getMTO()."</td>";
                    echo "<td>".$timesheet->getStarttime()."</td>";
                    echo "<td>".$timesheet->getEndtime()."</td>";
                    echo "<td>".$timesheet->getDuration()."</td>";
                    echo "<td>".$timesheet->getTrainees()."</td>";
                    echo "<td>".$timesheet->getMTONotes()."</td>";

                    $now = new DateTime();
                    $diffsincestart = $now->diff(DateTime::createFromFormat('Y-m-d', $timestampstring))->days;

                    $data = explode(":", $timesheet->getDuration());
                    if($data[0] > 1) {
                        for($i=1;$i<=$data[0];$i++) {
                            $totalinterval += 60;
                            if($diffsincestart <= 30) {
                                $totalinterval_30days += 60;
                            }
                            if($diffsincestart <= 7) {
                                $totalinterval_7days += 60;
                            }
                        }
                    }
                    $totalinterval += $data[1];
                    if($diffsincestart <= 30) {
                        $totalinterval_30days += $data[1];
                    }
                    if($diffsincestart <= 7) {
                        $totalinterval_7days += $data[1];
                    }
                    $total_count++;
                echo "</tr>";
            };

            $average_interval = floor($totalinterval / $total_count);

            $m = ($totalinterval - (60 * floor($totalinterval / 60)));
            if($m < 0) { $m=$average_interval; }
            $totalinterval = sprintf("%02d", floor($totalinterval / 60)).":".sprintf("%02d", $m).":00";

            $m = ($totalinterval_30days - (60 * floor($totalinterval_30days / 60)));
            if($m < 0) { $m=$average_interval; }
            $totalinterval_30days = sprintf("%02d", floor($totalinterval_30days / 60)).":".sprintf("%02d", $m).":00";

            $m = ($totalinterval_7days - (60 * floor($totalinterval_7days / 60)));
            if($m < 0) { $m=$average_interval; }
            $totalinterval_7days = sprintf("%02d", floor($totalinterval_7days / 60)).":".sprintf("%02d", $m).":00";

            $m = ($average_interval - (60 * floor($average_interval / 60)));
            if($m < 0) { $m=$average_interval; }
            $average_interval = sprintf("%02d", floor($average_interval / 60)).":".sprintf("%02d", $m).":00";

            echo "<tr id='total_duration'><td>".$totalinterval."</td></tr>";
            echo "<tr id='total_duration_30days'><td>".$totalinterval_30days."</td></tr>";
            echo "<tr id='total_duration_7days'><td>".$totalinterval_7days."</td></tr>";
            echo "<tr id='total_duration_average'><td>".$average_interval."</td></tr>";
        } else {
            echo "false";
        }


        die();
    }

    if(isset($_POST["search_ar"])) {

        $ars = new AR();
        $sql = "SELECT * FROM ar";

        $value = $ars->DBClear(trim($_POST["search_ar"]));

        if($value !== "") {
            $sql .= " WHERE pilotsteamid LIKE '%".$value."%' OR passenger1id LIKE '%".$value."%' OR passenger2id LIKE '%".$value."%' OR passenger3id LIKE '%".$value."%'";
        }

        $sql .= " ORDER BY timestamp DESC";

        $result = $ars->runSQL($sql, "result");

        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $ar = new AR($row);


                if($ar->getCrashed() == "No") {
                    $crashedclass = " class='success'";
                } elseif($ar->getCrashed() == "Yes") {
                    $crashedclass = " class='danger'";
                }

                echo "<tr>";
                    echo "<td>".substr($ar->getTimestamp(),0,-8)."</td>";
                    echo "<td>".$ar->getPilot()."</td>";
                    echo "<td>".$ar->getVehicle()."</td>";
                    echo "<td>".$ar->getStarttime()."</td>";
                    echo "<td>".$ar->getEndtime()."</td>";
                    echo "<td>".$ar->getDuration()."</td>";
                    echo "<td>".$ar->getPassenger1()."</td>";
                    echo "<td>".$ar->getPassenger2()."</td>";
                    echo "<td>".$ar->getPassenger3()."</td>";
                    echo "<td".$crashedclass.">".$ar->getCrashed()."</td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }


        die();
    }

    if(isset($_POST["search_rir"])) {

        $rirs = new RIR();
        $sql = "SELECT * FROM rir";

        $value = $rirs->DBClear(trim($_POST["search_rir"]));

        if($value !== "") {
            $sql .= " WHERE driversteamid LIKE '%".$value."%' OR passenger1id LIKE '%".$value."%' OR passenger2id LIKE '%".$value."%' OR passenger3id LIKE '%".$value."%'";
        }

        $sql .= " ORDER BY timestamp DESC";

        $result = $rirs->runSQL($sql, "result");

        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $rir = new RIR($row);

                echo "<tr>";
                    echo "<td>".substr($rir->getTimestamp(),0,-8)."</td>";
                    echo "<td>".$rir->getDriver()."</td>";
                    echo "<td>".$rir->getVehicle()."</td>";
                    echo "<td>".$rir->getStarttime()."</td>";
                    echo "<td>".$rir->getEndtime()."</td>";
                    echo "<td>".$rir->getDuration()."</td>";
                    echo "<td>".$rir->getPassenger1()."</td>";
                    echo "<td>".$rir->getPassenger2()."</td>";
                    echo "<td>".$rir->getPassenger3()."</td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }


        die();
    }

    if(isset($_POST["search_timesheet_mto"])) {

        $timesheets = new Timesheet();
        $sql = "SELECT * FROM timesheet";

        $value = $timesheets->DBClear(trim($_POST["search_timesheet_mto"]));

        if($value !== "") {
            $sql .= " WHERE mtosteamid LIKE '%".$value."%'";
        }

        $sql .= " ORDER BY timestamp DESC";

        $result = $timesheets->runSQL($sql, "result");

        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $timesheet = new Timesheet($row);

                echo "<tr>";
                    $timestampstring = substr($timesheet->getTimestamp(),0,-9);
                    echo "<td>".$timestampstring."</td>";
                    echo "<td>".$timesheet->getMTO()."</td>";
                    echo "<td>".$timesheet->getStarttime()."</td>";
                    echo "<td>".$timesheet->getEndtime()."</td>";
                    echo "<td>".$timesheet->getDuration()."</td>";
                    echo "<td>".$timesheet->getTrainees()."</td>";
                    echo "<td>".$timesheet->getMTONotes()."</td>";

                    $now = new DateTime();
                    $diffsincestart = $now->diff(DateTime::createFromFormat('Y-m-d', $timestampstring))->days;

                    $data = explode(":", $timesheet->getDuration());
                    if($data[0] > 1) {
                        for($i=1;$i<=$data[0];$i++) {
                            $totalinterval += 60;
                            if($diffsincestart <= 31) {
                                $totalinterval_30days += 60;
                            }
                            if($diffsincestart <= 8) {
                                $totalinterval_7days += 60;
                            }
                        }
                    }
                    $totalinterval += $data[1];
                    if($diffsincestart <= 31) {
                        $totalinterval_30days += $data[1];
                    }
                    if($diffsincestart <= 8) {
                        $totalinterval_7days += $data[1];
                    }
                    $total_count++;
                echo "</tr>";
            };

            $average_interval = floor($totalinterval / $total_count);

            $m = ($totalinterval - (60 * floor($totalinterval / 60)));
            if($m < 0) { $m=$average_interval; }
            $totalinterval = sprintf("%02d", floor($totalinterval / 60)).":".sprintf("%02d", $m).":00";

            $m = ($totalinterval_30days - (60 * floor($totalinterval_30days / 60)));
            if($m < 0) { $m=$average_interval; }
            $totalinterval_30days = sprintf("%02d", floor($totalinterval_30days / 60)).":".sprintf("%02d", $m).":00";

            $m = ($totalinterval_7days - (60 * floor($totalinterval_7days / 60)));
            if($m < 0) { $m=$average_interval; }
            $totalinterval_7days = sprintf("%02d", floor($totalinterval_7days / 60)).":".sprintf("%02d", $m).":00";

            $m = ($average_interval - (60 * floor($average_interval / 60)));
            if($m < 0) { $m=$average_interval; }
            $average_interval = sprintf("%02d", floor($average_interval / 60)).":".sprintf("%02d", $m).":00";

            echo "<tr id='total_duration'><td>".$totalinterval."</td></tr>";
            echo "<tr id='total_duration_30days'><td>".$totalinterval_30days."</td></tr>";
            echo "<tr id='total_duration_7days'><td>".$totalinterval_7days."</td></tr>";
            echo "<tr id='total_duration_average'><td>".$average_interval."</td></tr>";

        } else {
            echo "false";
        }


        die();
    }

    if(isset($_POST["medic_search_steamid2"])) {
        $steamid = trim($_POST["medic_search_steamid2"], '"');

        $playerdatas = new Playerdata();
        $result = $playerdatas->getFromDB('"'.$steamid.'"', "steamid64", "result");
        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $playerdata = new Playerdata($row);

                if($playerdata->getDepartment() == "Command") {
                    $deptclass = " class='danger'";
                } elseif($playerdata->getDepartment() == "Consultants") {
                    $deptclass = " class='danger'";
                } elseif($playerdata->getDepartment() == "Training") {
                    $deptclass = " class='success'";
                } elseif($playerdata->getDepartment() == "November") {
                    $deptclass = " class='info'";
                } elseif($playerdata->getDepartment() == "Hector") {
                    $deptclass = " class='pink'";
                } elseif($playerdata->getDepartment() == "Sierra") {
                    $deptclass = " class='purple'";
                } elseif($playerdata->getDepartment() == "Seniors") {
                    $deptclass = " class='orange'";
                }

                if($playerdata->getActivityStatus() == "Active") {
                    $statusclass = " class='success'";
                } elseif($playerdata->getActivityStatus() == "Inactive" || $playerdata->getActivityStatus() == "Left" || $playerdata->getActivityStatus() == "Removed") {
                    $statusclass = " class='danger'";
                } elseif($playerdata->getActivityStatus() == "Absent") {
                    $statusclass = " class='purple'";
                } elseif($playerdata->getActivityStatus() == "Suspended") {
                    $statusclass = " class='info'";
                }

                if($playerdata->getRank() == "CMO" || $playerdata->getRank() == "CST" || $playerdata->getRank() == "NHS") {
                    $rankclass = " class='danger'";
                } elseif($playerdata->getRank() == "DR" || $playerdata->getRank() == "SUR" || $playerdata->getRank() == "PAR") {
                    $rankclass = " class='info'";
                } elseif($playerdata->getRank() == "STU" || $playerdata->getRank() == "FA") {
                    $rankclass = " class='success'";
                }

                echo "<tr>";
                    echo "<td>Name</td>";
                    echo "<td>".$playerdata->getName()."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Steam ID</td>";
                    echo "<td>".$playerdata->getSteamID64()."</td>";
                echo "</tr>";
                echo "<tr ".$statusclass.">";
                    echo "<td>Activity</td>";
                    echo "<td>".$playerdata->getActivityStatus()."</td>";
                echo "</tr>";
                echo "<tr ".$rankclass.">";
                    echo "<td>Rank</td>";
                    echo "<td>".$playerdata->getRank()."</td>";
                echo "</tr>";
                echo "<tr ".$deptclass.">";
                    echo "<td>Department</td>";
                    echo "<td>".$playerdata->getDepartment()."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Forum</td>";
                    echo "<td><a href='".$playerdata->getForum()."' target='_blank'>".$playerdata->getForum()."</a></td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Stats</td>";
                    echo "<td><a href='".$playerdata->getStats()."' target='_blank'>".$playerdata->getStats()."</a></td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }

        die();
    }

    if(isset($_POST["medic_search_steamid3"])) {
        $steamid = trim($_POST["medic_search_steamid3"], '"');

        $playerdatas = new Playerdata();
        $result = $playerdatas->getFromDB('"'.$steamid.'"', "steamid64", "result");
        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $playerdata = new Playerdata($row);

                echo "<tr>";
                    echo "<td>Join Date</td>";
                    echo "<td>".$playerdata->getJoinDate()."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Last Promo</td>";
                    echo "<td>".$playerdata->getPromo()."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Air Rescue</td>";
                    echo "<td>".$playerdata->getAr()."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>RIR</td>";
                    echo "<td>".$playerdata->getRir()."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Infractions</td>";
                    echo "<td>".$playerdata->getInfrac()."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Last Login</td>";
                    echo "<td>".$playerdata->getLogin()."</td>";
                echo "</tr>";
                echo "<tr>";
                    echo "<td>Discord ID</td>";
                    echo "<td>".$playerdata->getDiscord()."</td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }

        die();
    }

    if(isset($_POST["search_police"])) {
        $steamid = trim($_POST["search_police"], '"');

        $polices = new Police();
        $result = $polices->getFromDB($steamid, "steamid", "result");
        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $police = new Police($row);

                $application = $police->getAppLink();

                if (strlen($application) > 20) {
                    $application = substr($application, 0, 20) . '...';
                }

                echo "<tr>";
                    echo "<td>".$police->getTimestamp()."</td>";
                    echo "<td>".$police->getName()."</td>";
                    //echo "<td>".$police->getSteamid()."</td>";
                    //echo "<td>".$police->getForumid()."</td>";
                    echo "<td>".$police->getAppInfo()."</td>";
                    echo "<td><a title='".$police->getAppLink()."' href='".$police->getAppLink()."' target='_blank'>".$application."</a></td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }

        die();
    }

    if(isset($_POST["search_appteam"])) {
        $steamid = trim($_POST["search_appteam"], '"');

        $apps = new App();
        $result = $apps->getFromDB($steamid, "steamid", "result");
        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $app = new App($row);

                $application = $app->getApplication();

                if (strlen($application) > 20) {
                    $application = substr($application, 0, 20) . '...';
                }

                if(strpos(strtolower($app->getDecision()), "declined") !== FALSE) {
                    $class = " class='danger'";
                } else {
                    $class = " class='success'";
                }

                echo "<tr>";
                    echo "<td>".substr($app->getTimestamp(),0,-8)."</td>";
                    echo "<td>".$app->getName()."</td>";
                    echo "<td>".$app->getAge()."</td>";
                    echo "<td".$class.">".$app->getDecision()."</td>";
                    echo "<td><a title='".$app->getApplication()."' href='".$app->getApplication()."' target='_blank'>".$application."</a></td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }

        die();
    }

    if(isset($_POST["search_interview_data"])) {
        $steamid = trim($_POST["search_interview_data"], '"');

        $interviews = new Interview();
        $result = $interviews->getFromDB('"'.$steamid.'"', "steamid", "result", false, false, "timestamp", true);
        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $interview = new Interview($row);

                echo "<tr style='cursor: pointer;' onClick='location.href=\"/interviews/".$interview->getId()."/\"'>";
                    echo "<td>".substr($interview->getTimestamp(),0,-8)."</td>";
                    echo "<td>".$interview->getName()."</td>";
                    //echo "<td>".trim($interview->getSteamid(), '"')."</td>";
                    echo "<td>".$interview->getRemarks()."</td>";
                    echo "<td>".$interview->getAge()."</td>";
                    echo "<td>".$interview->getTotal()."</td>";
                    echo "<td>".$interview->getResult()."</td>";
                    echo "<td>".$interview->getInterviewer()."</td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }

        die();
    }

    if(isset($_POST["search_feedback"])) {
        $steamid = trim($_POST["search_feedback"], '"');

        $feedbacks = new Feedback();
        $result = $feedbacks->getFromDB('"'.$steamid.'"', "steamid", "result", false, false, "timestamp", true);
        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $feedback = new Feedback($row);

                if($feedback->getFeedbacktype() == "Positive") {
                    $class = " class='success'";
                } elseif($feedback->getFeedbacktype() == "Neutral") {
                    $class = " class='warning'";
                } elseif($feedback->getFeedbacktype() == "Negative") {
                    $class = " class='danger'";
                }

                echo "<tr>";
                    echo "<td>".substr($feedback->getTimestamp(),0,-8)."</td>";
                    echo "<td>".$feedback->getMTO()."</td>";
                    echo "<td>".$feedback->getMedic()."</td>";
                    echo "<td".$class.">".$feedback->getFeedbacktype()."</td>";
                    echo "<td>".$feedback->getFeedback()."</td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }

        die();
    }

    if(isset($_POST["medic_search_mtosteamid"])) {
        $steamid = trim($_POST["medic_search_mtosteamid"], '"');

        $feedbacks = new Feedback();
        $result = $feedbacks->getFromDB('"'.$steamid.'"', "mtosteamid", "result", false, false, "timestamp", true);
        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $feedback = new Feedback($row);

                if($feedback->getFeedbacktype() == "Positive") {
                    $class = " class='success'";
                } elseif($feedback->getFeedbacktype() == "Neutral") {
                    $class = " class='warning'";
                } elseif($feedback->getFeedbacktype() == "Negative") {
                    $class = " class='danger'";
                }

                echo "<tr>";
                    echo "<td>".substr($feedback->getTimestamp(),0,-8)."</td>";
                    echo "<td>".$feedback->getMTO()."</td>";
                    echo "<td>".$feedback->getMedic()."</td>";
                    echo "<td".$class.">".$feedback->getFeedbacktype()."</td>";
                    echo "<td>".$feedback->getFeedback()."</td>";
                echo "</tr>";
            }
        } else {
            echo "false";
        }

        die();
    }

    if(isset($_POST["login_search"])) {
        $curl = curl_init();

        $steamid = trim($_POST["login_search"], '"');

        $url = 'https://api.roleplay.co.uk/v1/player/'.$steamid.'/sessions/?side=guer';
        if($_POST["do_all"] === "true") {
            $url = 'https://api.roleplay.co.uk/v1/player/'.$steamid.'/sessions/';
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            ),
        ));

        $results = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($curl);

        if($httpcode !== 400 && $httpcode !== 404 && $httpcode !== 300) {
            $results = json_decode($results);

            if(!empty($results->sessions)) {
                $cleandatetime = new DateTime('@0');

                $totaldatetime = clone $cleandatetime;
                $totaldatetime_civ = clone $cleandatetime;
                $totaldatetime_police = clone $cleandatetime;
                $totaldatetime_medic = clone $cleandatetime;

                $totaldatetime_30days = clone $cleandatetime;
                $totaldatetime_30days_civ = clone $cleandatetime;
                $totaldatetime_30days_police = clone $cleandatetime;
                $totaldatetime_30days_medic = clone $cleandatetime;

                $totaldatetime_7days = clone $cleandatetime;
                $totaldatetime_7days_civ = clone $cleandatetime;
                $totaldatetime_7days_police = clone $cleandatetime;
                $totaldatetime_7days_medic = clone $cleandatetime;

                $total_count = 0;
                foreach ($results->sessions as $obj) {
                    $displaySide = $obj->side;
                    $class = "";
                    if($obj->side == "guer") {
                        $displaySide = "Medic";
                        $class = " class='success'";
                    } else if($obj->side == "civ") {
                        $displaySide = "Civillian";
                        $class = " class='purple'";
                    } else if($obj->side == "west") {
                        $displaySide = "Police";
                        $class = " class='info'";
                    } else if($obj->side == "east") {
                        $displaySide = "UNMC";
                        $class = " class='danger'";
                    }

                    echo "<tr".$class.">";
                        echo "<td>".$obj->name."</td>";
                        echo "<td>".$displaySide."</td>";
                        echo "<td>".$obj->server."</td>";
                        echo "<td>".$obj->playtime_start."</td>";
                        echo "<td>".$obj->playtime_end."</td>";

                        $start = DateTime::createFromFormat('Y-m-d H:i:s', $obj->playtime_start);
                        $end = DateTime::createFromFormat('Y-m-d H:i:s', $obj->playtime_end);

                        $interval = $start->diff($end);

                        $totaldatetime->add($interval);

                        if($obj->side == "west") {
                          $totaldatetime_police->add($interval);
                        } else if($obj->side == "guer") {
                          $totaldatetime_medic->add($interval);
                        } else if($obj->side == "civ") {
                          $totaldatetime_civ->add($interval);
                        }

                        $total_count++;

                        $now = new DateTime();
                        $diffsincestart = $now->diff($start)->days;

                        if($diffsincestart <= 30) {
                            $totaldatetime_30days->add($interval);

                            if($obj->side == "west") {
                              $totaldatetime_30days_police->add($interval);
                            } else if($obj->side == "guer") {
                              $totaldatetime_30days_medic->add($interval);
                            } else if($obj->side == "civ") {
                              $totaldatetime_30days_civ->add($interval);
                            }
                        }

                        if($diffsincestart <= 7) {
                            $totaldatetime_7days->add($interval);

                            if($obj->side == "west") {
                              $totaldatetime_7days_police->add($interval);
                            } else if($obj->side == "guer") {
                              $totaldatetime_7days_medic->add($interval);
                            } else if($obj->side == "civ") {
                              $totaldatetime_7days_civ->add($interval);
                            }
                        }

                        echo "<td>".DiffString($interval, "Under 3 minutes", true)."</td>";
                    echo "</tr>";
                };

                $totalinterval = $totaldatetime->diff($cleandatetime);
                $totalinterval_civ = $totaldatetime_civ->diff($cleandatetime);
                $totalinterval_police = $totaldatetime_police->diff($cleandatetime);
                $totalinterval_medic = $totaldatetime_medic->diff($cleandatetime);

                $totalinterval_30days = $totaldatetime_30days->diff($cleandatetime);
                $totalinterval_30days_civ = $totaldatetime_30days_civ->diff($cleandatetime);
                $totalinterval_30days_police = $totaldatetime_30days_police->diff($cleandatetime);
                $totalinterval_30days_medic = $totaldatetime_30days_medic->diff($cleandatetime);

                $totalinterval_7days = $totaldatetime_7days->diff($cleandatetime);
                $totalinterval_7days_civ = $totaldatetime_7days_civ->diff($cleandatetime);
                $totalinterval_7days_police = $totaldatetime_7days_police->diff($cleandatetime);
                $totalinterval_7days_medic = $totaldatetime_7days_medic->diff($cleandatetime);

                $average_datetime = new DateTime("@".round($totaldatetime->getTimestamp() / $total_count));
                $average_interval = $average_datetime->diff($cleandatetime);

                echo "<tr id='total_duration'><td>".DiffString($totalinterval, "Under 3 minutes", true)."</td></tr>";
                echo "<tr id='total_duration_30days'><td>".DiffString($totalinterval_30days, "Under 3 minutes", true)."</td></tr>";
                echo "<tr id='total_duration_7days'><td>".DiffString($totalinterval_7days, "Under 3 minutes", true)."</td></tr>";
                echo "<tr id='total_duration_average'><td>".DiffString($average_interval, "Under 3 minutes", true)."</td></tr>";

                echo "<tr id='graph_civLoginData'><td>".json_encode([DiffHours($totalinterval_civ),DiffHours($totalinterval_30days_civ),DiffHours($totalinterval_7days_civ)])."</td></tr>";
                echo "<tr id='graph_policeLoginData'><td>".json_encode([DiffHours($totalinterval_police),DiffHours($totalinterval_30days_police),DiffHours($totalinterval_7days_police)])."</td></tr>";
                echo "<tr id='graph_medicLoginData'><td>".json_encode([DiffHours($totalinterval_medic),DiffHours($totalinterval_30days_medic),DiffHours($totalinterval_7days_medic)])."</td></tr>";
            } else {
                echo "false";
            }
        } else {
            echo "false";
        }

        die();
    }
