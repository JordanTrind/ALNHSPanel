<?php
if(!$me->hasPermission("interviews") && !$me->hasPermission("smto") && !$me->hasPermission("consultants")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">All Logins</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table" id="steamidsearch_data_total_table" style="display: none;">
                            <thead>
                                <tr>
                                    <th>Total Duration</th>
                                    <th>Last 30 Days</th>
                                    <th>Last 7 Days</th>
                                    <th>Average Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Player ID</th>
                                    <th>Server</th>
                                    <th>Login</th>
                                    <th>Logout</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody id="steamidsearch_data">
                                <?php
                                    $curl = curl_init();
                                    curl_setopt_array($curl, array(
                                        CURLOPT_URL => 'https://api.roleplay.co.uk/v1/factions/nhs/sessions',
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

                                        $cleandatetime = new DateTime('@0');
                                        $totaldatetime = clone $cleandatetime;
                                        $totaldatetime_30days = clone $cleandatetime;
                                        $totaldatetime_7days = clone $cleandatetime;

                                        $total_count = 0;
                                        foreach ($results as $obj) {
                                            $start = DateTime::createFromFormat('Y-m-d H:i:s', $obj->playtime_start);
                                            $end = DateTime::createFromFormat('Y-m-d H:i:s', $obj->playtime_end);

                                            $interval = $start->diff($end);

                                            $duration_class = "";
                                            $duration = DiffString($interval, "Under 3 minutes", true);
                                            if($duration === "Under 3 minutes") {
                                                $duration_class = " class='danger'";
                                            }

                                            if($duration === "3 minutes") {
                                                $duration_class = " class='danger'";
                                            }

                                            if($duration === "2 minutes") {
                                                $duration_class = " class='danger'";
                                            }

                                            if($duration === "1 minute") {
                                                $duration_class = " class='danger'";
                                            }

                                            echo "<tr".$duration_class.">";
                                                echo "<td>".$obj->name."</td>";
                                                echo "<td>".$obj->playerid."</td>";
                                                echo "<td>".$obj->server."</td>";
                                                echo "<td>".$obj->playtime_start."</td>";
                                                echo "<td>".$obj->playtime_end."</td>";
                                                echo "<td>".$duration."</td>";
                                            echo "</tr>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
