<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("seniorappteam") && !$me->hasPermission("app_team")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">NHS & Police Application Database <button type="button" class="btn btn-info" id="update_data_sheet2" style="float: right;">Update Data</button></h1>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="form-group">
            <label for="disabledSelect">Search</label>
            <input class="form-control" type="text" id="search" placeholder="Name / Url / Steam ID">
        </div>
        <!--<div class="form-group">
            <input type="checkbox" id="app_do_all" /> Search Police
        </div>-->
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>Team Member's</th>
                                <th>Player ID</th>
                                <th>Age</th>
                                <th>App URL</th>
                                <th>Decision</th>
                            </tr>
                        </thead>
                        <tbody id="application_data">
                            <?php
                                $apps = new App();
                                $result = $apps->getFromDB(NULL, NULL, "result", false, false, "timestamp", true);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_object()) {
                                        $app = new App($row);

                                        $application = $app->getApplication();

                                        if (strlen($application) > 60) {
                                            $application = substr($application, 0, 60) . '...';
                                        }

                                        if(strpos(strtolower($app->getDecision()), "declined") !== FALSE) {
                                            $class = " class='danger'";
                                        } else {
                                            $class = " class='success'";
                                        }

                                        echo "<tr>";
                                            echo "<td>".$app->getTimestamp()."</td>";
                                            echo "<td>".$app->getName()."</td>";
                                            echo "<td>".$app->getSteamid()."</td>";
                                            echo "<td>".$app->getAge()."</td>";
                                            echo "<td><a title='".$app->getApplication()."' href='".$app->getApplication()."' target='_blank'>".$application."</a></td>";
                                            echo "<td".$class.">".$app->getDecision()."</td>";
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>

                    <p style="text-align:center;display: none" id="status">Searching...</p>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                              <th>Police Timestamp</th>
                              <th>Police Database Name</th>
                              <th>Police App Information</th>
                              <th>Police App Link</th>
                            </tr>
                        </thead>
                        <tbody id="police_data">
                        </tbody>
                    </table>

                    <p style="text-align:center;display: none" id="police_status">Searching...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $("#update_data_sheet2").on("click", function(e) {
            e.preventDefault();

            var button = $(this);

            button.prop("disabled", true);
            EnableLoading();

            $.ajax({
                url: "https://api.shaynorman.com/spreadsheet_to_db/?sheetid=2",
                timeout: 120000
             }).done(function() {
                Alert("Success!", "Update done!", "green", function() {
                    location.reload();
                });
            }).fail(function() {
                DisableLoading();

                Alert("Something went wrong!", "Failed to connect to the server!");

                button.prop("disabled", false);
            });
        });

        var ChangeTimer = false;

        $("#search").on("input", function(){
            if(ChangeTimer !== false) clearTimeout(ChangeTimer);
                ChangeTimer = setTimeout(function(){

                $("#application_data").hide();
                $("#status").text("Searching...").show();

                $.post("#", {
                    search_application_db: " " + $("#search").val()
                }).done(function(data) {
                    if(data === "false") {
                        $("#application_data").hide();
                        $("#status").text("No results found on the NHS Database for this ID!").show();
                    } else {
                        $("#application_data").html(data).show();
                        $("#status").hide();
                    }
                }).fail(function() {
                    $("#application_data").hide();
                    $("#status").text("Failed to connect to the server!").show();
                });

                $.post("#", {
                    interview_check_police: $("#search").val()
                }).done(function(data) {
                    if(data === "false") {
                        $("#police_data").hide();
                        $("#police_status").text("No results found on police database for this ID!").show();
                    } else {
                        $("#police_data").html(data).show();
                        $("#police_status").hide();
                    }
                }).fail(function() {
                    $("#police_data").hide();
                    $("#police_status").text("Failed to connect to the server!").show();
                });

                ChangeTimer = false;
            }, 500);
        });
    });
</script>
