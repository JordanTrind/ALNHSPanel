<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Welcome,
                  <?php
                    $playerdata = new Playerdata();
                    $playerdata->getFromDB('"'.$me->getSteamid().'"');

                    if($me->hasPermission("smto") && !$me->hasPermission("*")) {
                      echo $playerdata->getRank()." ".$me->getUsername()." [SMTO]";
                    } elseif ($me->hasPermission("mto") && !$me->hasPermission("*")) {
                      echo $playerdata->getRank()." ".$me->getUsername()." [MTO]";
                    } elseif (($me->hasPermission("app_team") || $me->hasPermission("seniorappteam")) && !$me->hasPermission("*")) {
                      echo $playerdata->getRank()." ".$me->getUsername()." [AT]";
                    } elseif ($me->hasPermission("*") && $playerdata->getRank() == "CMO") {
                      echo "CMO ".$me->getUsername();
                    } elseif ($me->hasPermission("*") && !$playerdata->getRank() == "CMO") {
                      echo $me->getUsername();
                    } else {
                      echo $playerdata->getRank()." ".$me->getUsername();
                    }

                   ?>
                 </h1>
            </div>
        </div>

        <?php
            $messages = new Message();
            $result = $messages->getFromDB(null, null, "result");
            $unread = 0;
            if($result->num_rows > 0) {
                while($row = $result->fetch_object()) {
                    $message = new Message($row);

                    $show = false;
                    if(strpos($message->getReceiver(), ",") !== false) {
                        $users = explode(",", $message->getReceiver());

                        foreach($users as $id) {
                            if($id === $me->getId()) {
                                $show = true;

                                break;
                            }
                        }
                    } elseif($message->getReceiver() === $me->getId()) {
                        $show = true;
                    }

                    if($show) {
                        $opened = false;
                        if(!in_array($me->getId(), explode(",", $message->getOpened()))) {
                            $unread++;
                        }
                    }
                }
            }

            if($unread > 0) {
                echo '<div class="alert alert-warning"> <b>New messages:</b> You have '.$unread.' unread messages! Read them <a href="/messages/">Here</a></div>';
            }
        ?>


        <?php
        $notifyBanner1 = False;
        if($me->hasPermission("consultants") && $notifyBanner2 == True) {
        ?>
        <div class="alert alert-danger"> TEST MESSAGE TO THE CONSULTANTS </div>
        <?php
        }
        ?>

        <?php
        $notifyBanner2 = True;
        if($notifyBanner2 == True) {
        ?>
        <div class="alert alert-danger"> If your colours have bugged out or aren't working press <b>Control+F5</b></div>
        <?php
        }
        ?>



        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Statistics
                    </div>
                    <div class="panel-body">
                        <p>
                        <div class="row">
                            <?php
                            $interviewsindb = "0";
                            $interviewsindb_yes = 0;
                            $interviewsindb_pardon = 0;

                            try {
                                $Interviews = new Interview();
                                $interviewsindb = $Interviews->getFromDB(NULL, NULL, "count");

                                $Interviews = new Interview();
                                $interviewsindb_yes = $Interviews->getFromDB("yes", "result", "count", false, false, false, false, "=", NULL, false);

                                $Interviews = new Interview();
                                $interviewsindb_pardon = $Interviews->getFromDB("pardon", "result", "count", false, false, false, false, "=", NULL, false);
                            } catch (Exception $ex) {}
                            ?>

                            <div class="col-lg-3 col-md-6" title="Yes: <?= round(($interviewsindb_yes / $interviewsindb) * 100); ?>%, Pardon: <?= round(($interviewsindb_pardon / $interviewsindb) * 100); ?>%">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-check fa-4x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge"><?= round((($interviewsindb_yes + $interviewsindb_pardon) / $interviewsindb) * 100); ?>%</div>
                                                <div>Interview Pass Rate</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6" title="NEARLY 2018 BOIS">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-users fa-4x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <?php
                                                $medicsindb = "0";

                                                try {
                                                    $playerdata = new Playerdata();
                                                    $medicsindb = $playerdata->getFromDB(NULL, NULL, "count");
                                                } catch (Exception $ex) {

                                                }
                                                ?>
                                                <div class="huge"><?= $medicsindb; ?></div>
                                                <div>Medics in the database</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-calendar fa-4x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <?php
                                                $interviewsindb_yes_month = 0;

                                                try {
                                                    $interviews = new Interview();
                                                    $result = $interviews->getFromDB(array("yes", "pardon"), "result", "result", false, false, false, false, "=", NULL, false);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_object()) {
                                                            $interview = new Interview($row);

                                                            $date1 = new DateTime();
                                                            $date2 = new DateTime($interview->getTimestamp());

                                                            $diff = $date2->diff($date1)->format("%a");

                                                            if ($diff < 31) {
                                                                $interviewsindb_yes_month++;
                                                            }
                                                        }
                                                    }
                                                } catch (Exception $ex) {

                                                }
                                                ?>
                                                <div class="huge"><?= (string) $interviewsindb_yes_month ?></div>
                                                <div>New medics this month</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <i class="fa fa-comments fa-4x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                <?php
                                                $medicsindb_discord = "0";

                                                try {
                                                    $playerdata = new Playerdata();
                                                    $medicsindb_discord = $playerdata->getFromDB("", "discord", "count", false, false, false, false, "<>");
                                                } catch (Exception $ex) {

                                                }
                                                ?>
                                                <div class="huge"><?= $medicsindb_discord; ?></div>
                                                <div>Medics using discord</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Current Rank Distribution
                                    </div>

                                    <div class="panel-body">
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="rank_pie_chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                                $temppiedata = array();

                                $playerdatas = new Playerdata();
                                $result = $playerdatas->getFromDB("active", "activity_status", "result", false, false, false, false, "=", NULL, false);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_object()) {
                                        $playerdata = new Playerdata($row);

                                        $rank = $playerdata->getRank();

                                        if(!isset($temppiedata[$rank])) {
                                            $temppiedata[$rank] = array(
                                                "label" => $rank,
                                                "data" => 0
                                            );
                                        }

                                        $temppiedata[$rank]["data"]++;
                                    }
                                }

                                unset($temppiedata["CMO"]);
                                unset($temppiedata["CST"]);
                                unset($temppiedata["NHS"]);

                                $temppiedata["STU"]["color"] = "#38761d";
                                $temppiedata["FA"]["color"] = "#274e13";
                                $temppiedata["PAR"]["color"] = "#3778b3";
                                $temppiedata["SUR"]["color"] = "#0b5394";
                                $temppiedata["DR"]["color"] = "#073763";

                                $piedata = array();
                                foreach($temppiedata as $_ => $data) {
                                    $piedata[] = $data;
                                }
                            ?>

                            <script>
                                $(function() {
                                    var piedata = <?=json_encode($piedata)?>;

                                    $.plot($("#rank_pie_chart"), piedata, {
                                        series: {
                                            pie: {
                                                show: true,
                                                label: {
                                                    show: false
                                                }
                                            }
                                        },
                                        legend: {show: false},
                                        grid: {
                                            hoverable: true
                                        },
                                        tooltip: true,
                                        tooltipOpts: {
                                            content: "%p.0%, %s - %n",
                                            shifts: {
                                                x: 20,
                                                y: 0
                                            },
                                            defaultTheme: true
                                        }
                                    });
                                });
                            </script>

                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Medical Activity Distribution
                                    </div>

                                    <div class="panel-body">
                                        <div class="flot-chart">
                                            <div class="flot-chart-content" id="medical_activity_distribution"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                                $bardata = array();
                                $bardata["label"] = "Medical Activity Distribution";
                                $bardata["color"] = "#5482FF";

                                $tempbardata = array();

                                $barticks = array();

                                $playerdatas = new Playerdata();
                                $result = $playerdatas->getFromDB(NULL, NULL, "result");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_object()) {
                                        $playerdata = new Playerdata($row);

                                        $activitystatus = $playerdata->getActivityStatus();

                                        $tempbardata[$activitystatus]++;
                                    }
                                }

                                unset($tempbardata["Management"]);
                                unset($tempbardata["Suspended"]);
                                unset($tempbardata["Holiday"]);
                                unset($tempbardata["Absent"]);

                                $i = 0;
                                foreach($tempbardata as $key => $data) {
                                    $bardata["data"][] = array($i, $data);
                                    $barticks[] = array($i, $key);

                                    $i++;
                                }
                            ?>

                            <script>
                                $(function() {
                                    var bardata = [<?=json_encode($bardata)?>];
                                    var barticks = <?=json_encode($barticks)?>;

//                                    [{
//                                            label: "2012 Average Temperature",
//                                            data: [
//                                                [0, 11], //London, UK
//                                                [1, 15], //New York, USA
//                                                [2, 25], //New Delhi, India
//                                                [3, 24], //Taipei, Taiwan
//                                                [4, 13], //Beijing, China
//                                                [5, 18]  //Sydney, AU
//                                            ],
//                                            color: "#5482FF"
//                                        }]

                                    $.plot($("#medical_activity_distribution"), bardata, {
                                        series: {
                                            bars: {
                                                show: true,
                                                barWidth: 0.2,
                                                lineWidth: 0,
                                                order: 1,
                                                fillColor: {
                                                    colors: [{
                                                        opacity: 1
                                                    }, {
                                                        opacity: 1
                                                    }]
                                                }
                                            }
                                        },
                                        legend: { show: false },
                                        grid: {
                                            hoverable: true,
                                            borderWidth: 0
                                        },
                                        xaxis: {
                                            ticks: barticks,
                                        },
                                        tooltip: true,
                                        tooltipOpts: {
                                            content: "%y",
                                            shifts: {
                                                x: 30,
                                                y: 0
                                            },
                                            defaultTheme: true
                                        }
                                    });
                                });
                            </script>

                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Department Members Distribution
                                    </div>

                                    <div class="panel-body">
                                        <div class="flot-chart">
                                            <div id="department_members_distribution"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                                $templinedata = array();

                                $playerdatas = new Playerdata();
                                $result = $playerdatas->getFromDB("active", "activity_status", "result", false, false, false, false, "=", NULL, false);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_object()) {
                                        $playerdata = new Playerdata($row);

                                        $department = $playerdata->getDepartment();

                                        $templinedata[$department]++;
                                    }
                                }

                                unset($templinedata["Command"]);
                                unset($templinedata["Consultants"]);
                                unset($templinedata["Staff"]);
                                unset($templinedata["None"]);

                                $linedata = array();
                                foreach($templinedata as $department => $amount) {
                                    $linedata[] = array(
                                        "department" => $department,
                                        "value" => $amount
                                    );
                                }
                            ?>

                            <script>
                                $(function() {
                                    var linedata = <?=json_encode($linedata)?>;

                                    new Morris.Line({
                                        // ID of the element in which to draw the chart.
                                        element: 'department_members_distribution',
                                        // Chart data records -- each entry in this array corresponds to a point on
                                        // the chart.
                                        data: linedata,
                                        parseTime:false,
                                        // The name of the data record attribute that contains x-values.
                                        xkey: 'department',
                                        // A list of names of data record attributes that contain y-values.
                                        ykeys: ['value'],
                                        // Labels for the ykeys -- will be displayed when you hover over the
                                        // chart.
                                        labels: ['Value']
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        NHS Quick Links
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-6">
                            <a href="http://handbook.altisnhs.co.uk" class="alert-link" target='_blank'>NHS Handbook</a> <br />
                            <a href="https://www.roleplay.co.uk/topic/88538-roles-and-responsibilities-in-the-nhs/" class="alert-link" target='_blank'>NHS Roles & Responsibilites</a><br />
                            <a href="https://www.roleplay.co.uk/forum/139-nhs-public-information/" class="alert-link" target='_blank'>NHS Public Info</a><br />
                        </div>
                        <div class="col-lg-6">
                            <a href="https://www.roleplay.co.uk/topic/18032-the-nhs-meme-thread/" class="alert-link" target='_blank'>NHS Meme Thread</a><br />
                            <a href="https://docs.google.com/forms/d/e/1FAIpQLScih7uRGPN5YTjT2eZ1W9FePQ0YDw0gtsCe_1WF5e1qEZ0E4w/viewform" class="alert-link" target='_blank'>NHS Recommendations</a><br />
                            <a href="https://www.roleplay.co.uk/forum/92-the-staff-room/" class="alert-link" target='_blank'>NHS Staff Room</a><br />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Currently Online/Away Users
                    </div>
                    <div class="panel-body">
                        <?php
                        $onlinelist = "";

                        $onlines = new Online();
                        $result = $onlines->getFromDB(NULL, NULL, "result");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_object()) {
                                $online = new Online($row);

                                if ($online->getOnline() === 1 || $online->getOnline() === 2) {
                                    $user = new User();
                                    $user->getFromDB($online->getUid());

                                    if ($user->getUsername()) {
                                        if ($online->getOnline() === 1) {
                                            $onlinelist .= "<span class='online' title='Online - Last active: " . $online->getLastactive() . "'>" . $user->getUsername() . "</span>, ";
                                        } else {
                                            $onlinelist .= "<span class='away' title='Away - Last active: " . $online->getLastactive() . "'>" . $user->getUsername() . "</span>, ";
                                        }
                                    }
                                }
                            }
                        }

                        echo rtrim($onlinelist, ", ");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div stlye="clear: both;"></div>
</div>

<script src="../vendor/flot/excanvas.min.js"></script>
<script src="../vendor/flot/jquery.flot.js"></script>
<script src="../vendor/flot/jquery.flot.pie.js"></script>
<script src="../vendor/flot/jquery.flot.resize.js"></script>
<script src="../vendor/flot/jquery.flot.time.js"></script>
<script src="../vendor/flot-tooltip/jquery.flot.tooltip.min.js"></script>
<script src="../vendor/raphael/raphael.min.js"></script>
<script src="../vendor/morrisjs/morris.min.js"></script>
<script src="../scripts/data/morris-data.js"></script>
