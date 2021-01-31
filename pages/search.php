<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js'></script>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Medic Search</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <label>Search by Name</label>
            <select class="form-control selectpicker" name='playerid' value="" data-live-search="true" placeholder="" title="Select an NHS Member" id="player_name">
                <option></option>
                <optgroup label="ACTIVE MEMBERS">
                <?php
                    $playerdatas = new Playerdata();

                    $sql = "SELECT * FROM playerdata";
                    $sql .= ' WHERE activity_status = "Active" OR activity_status = "Suspended" OR activity_status = "Absent" OR activity_status="Holiday"';
                    $sql .= " ORDER BY rank ASC, name ASC ";

                    $result = $playerdatas->runSQL($sql, "result");
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_object()) {
                            $playerdata = new Playerdata($row);

                            echo "<option value='".$playerdata->getSteamID64()."'>".$playerdata->getRank()." \t".$playerdata->getName()."</option>";

                        }
                    }
                ?>
                </optgroup>
                <optgroup label="INACTIVE MEMBERS">
                <?php
                    $playerdatas = new Playerdata();

                    $sql = "SELECT * FROM playerdata";
                    $sql .= ' WHERE activity_status = "Inactive"';
                    $sql .= " ORDER BY rank ASC, name ASC ";

                    $result = $playerdatas->runSQL($sql, "result");
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_object()) {
                            $playerdata = new Playerdata($row);

                            echo "<option value='".$playerdata->getSteamID64()."'>".$playerdata->getRank()." \t".$playerdata->getName()."</option>";

                        }
                    }
                ?>
                </optgroup>
                <optgroup label="LEFT/REMOVED MEMBERS">
                <?php
                    $playerdatas = new Playerdata();

                    $sql = "SELECT * FROM playerdata";
                    $sql .= ' WHERE activity_status = "Left" OR activity_status = "Removed"';
                    $sql .= " ORDER BY rank ASC, name ASC ";

                    $result = $playerdatas->runSQL($sql, "result");
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_object()) {
                            $playerdata = new Playerdata($row);

                            echo "<option value='".$playerdata->getSteamID64()."'>".$playerdata->getRank()." \t".$playerdata->getName()."</option>";

                        }
                    }
                ?>
                </optgroup>
            </select>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label for="disabledSelect">or Steam ID</label>
                <input class="form-control" type="text" id="player_steamid" placeholder="Enter Steam ID">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Search Options</label>
        <label class="radio-inline">
            <input type="radio" name="optionsRadiosInline" id="showRecruitment" checked="">Recruitment
        </label>
        <?php
        if($me->hasPermission("consultants") || $me->hasPermission("smto")) {
        ?>
        <label class="radio-inline">
            <input type="radio" name="optionsRadiosInline" id="showLogins" value="option2">Login Data
        </label>
        <?php
        }
        ?>
        <?php
        if($me->hasPermission("consultants") || $me->hasPermission("mto") || $me->hasPermission("smto")) {
        ?>
        <label class="radio-inline">
            <input type="radio" name="optionsRadiosInline" id="showFeedback" value="option3">MTO Feedback
        </label>
        <label class="radio-inline">
            <input type="radio" name="optionsRadiosInline" id="showTimesheet" value="option4">MTO Timesheet
        </label>
        <label class="radio-inline" style="float: right" id="openFeedback">
            <a class="btn btn-danger" type="button" name="optionsRadiosInline" value="option8">MTO Feedback</a>
        </label>
        <?php
        }
        ?>

        <label class="radio-inline">
            <input type="radio" name="optionsRadiosInline" id="showAR" value="option5">Air Rescue
        </label>
        <label class="radio-inline">
            <input type="radio" name="optionsRadiosInline" id="showRIR" value="option6">RIR
        </label>

        <label class="radio-inline" style="float: right" id="opensubmitAR">
            <a class="btn btn-warning" type="button" name="optionsRadiosInline" value="option9">AR Timesheet</a>
        </label>

        <label class="radio-inline" style="float: right" id="openRecommendation">
            <a class="btn btn-info" type="button" name="optionsRadiosInline" value="option7">NHS Recommendation</a>
        </label>

    </div>



    <div class="container-fluid" id="mtoFeedback" style="display:none" >
        <iframe class="search-embed" id="mtoFeedbackLink"></iframe>
        <div stlye="clear: both;"></div>
    </div>

    <div class="container-fluid" id="recommendation" style="display:none" >
        <iframe class="search-embed" id="recommendationURL"></iframe>
        <div stlye="clear: both;"></div>
    </div>

    <div class="container-fluid" id="submitAR" style="display:none" >
        <iframe class="search-embed" id="submitARurl"></iframe>
        <div stlye="clear: both;"></div>
    </div>


    <div class="row" id="recruitment">
            <div class="col-lg-12">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          Database Record
                      </div>

                      <div class="panel-body">
                          <div class="col-lg-6">
                              <table class="table first-bold">
                                  <tbody id="steamid2_data">
                                  </tbody>
                              </table>
                          </div>
                          <div class="col-lg-6">
                              <table class="table first-bold">
                                  <tbody id="steamid3_data">
                                  </tbody>
                              </table>
                          </div>
                          <p style="text-align:center" id="steamid2_status">No results found!</p>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">Application Results from inputted ID:</a>
                          </h4>
                      </div>
                      <div id="collapseSix" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>Team Member</th>
                                              <th>Age</th>
                                              <th>Decision</th>
                                              <th>URL</th>
                                          </tr>
                                      </thead>
                                      <tbody id="appteam_data">
                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="appteam_status">No results found!</p>
                              </div>
                          </div>
                       </div>
                  </div>
              </div>
              <div class="col-lg-6" >
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Police Results from inputted ID:</a>
                          </h4>
                      </div>
                      <div id="collapseFive" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>Name</th>
                                              <th>App Information</th>
                                              <th>URL</th>
                                          </tr>
                                      </thead>
                                      <tbody id="police_data">
                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="police_status">No results found!</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-12">
                  <div class="panel panel-primary">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Interview Results from inputted ID:</a>
                          </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>Name</th>
                                              <th>Remarks</th>
                                              <th>Age</th>
                                              <th>Score</th>
                                              <th>Result</th>
                                              <th>Interviewer</th>
                                          </tr>
                                      </thead>
                                      <tbody id="interview_data">
                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="interview_status">No results found!</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
    </div>

    <div class="form-group" id="searchLoginsBox" style="display:none">
        <input type="checkbox" id="do_all" /> Search All Logins
    </div>

    <div class="panel panel-yellow" id="searchLoginsGraph" style="display:none">
          <div class="panel-heading">
              <h4 class="panel-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">Graph (To the nearest hour)</a>
              </h4>
          </div>
          <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                <div class="col-lg-12">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                        <canvas width='1' height='1' id='timeGraph'></canvas>
                    </div>
                </div>
              </div>
          </div>
    </div>
    <div class="row" id="searchLogins" style="display:none">
              <div class="col-lg-12">
                  <div class="panel panel-yellow">
                      <div class="panel-heading">Search results from inputted steam ID:</div>
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
                                          <th>Side</th>
                                          <th>Server</th>
                                          <th>Login</th>
                                          <th>Logout</th>
                                          <th>Duration</th>
                                      </tr>
                                  </thead>
                                  <tbody id="steamidsearch_data">
                                  </tbody>
                              </table>

                              <p style="text-align:center" id="steamidsearch_status">No results found!</p>
                          </div>
                      </div>
                  </div>
              </div>
    </div>


    <div class="row" id="feedback" style="display:none">
              <div class="col-lg-12">
                  <div class="panel panel-green">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">MTO Feedback about inputted ID:</a>
                          </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>MTO</th>
                                              <th>Medic</th>
                                              <th>Type</th>
                                              <th>Feedback</th>
                                          </tr>
                                      </thead>
                                      <tbody id="feedback_data">
                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="feedback_status">No MTO feedbacks found!</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-12">
                  <div class="panel panel-green">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Submitted feedback from ID (MTO/SMTO)</a>
                          </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>MTO</th>
                                              <th>Medic</th>
                                              <th>Type</th>
                                              <th>Feedback</th>
                                          </tr>
                                      </thead>
                                      <tbody id="mtofeedback_data">
                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="mtofeedback_status">No submitted feedbacks as an MTO/SMTO found!</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
    </div>
    <div class="row" id="timesheet" style="display:none">
              <div class="col-lg-12">
                  <div class="panel panel-red">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">Patrols with an MTO</a>
                          </h4>
                      </div>
                      <div id="collapseSeven" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table" id="timesheetsearch_data_total_table">
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
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>MTO</th>
                                              <th>Start</th>
                                              <th>End</th>
                                              <th>Duration</th>
                                              <th>Trainees</th>
                                              <th>Notes</th>
                                          </tr>
                                      </thead>
                                      <tbody id="timesheet_data">

                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="timesheet_status">No patrols with an MTO found!</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

              <div class="col-lg-12">
                  <div class="panel panel-red">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">Patrols as an MTO/SMTO</a>
                          </h4>
                      </div>
                      <div id="collapseEight" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table" id="mtotimesheetsearch_data_total_table">
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
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>MTO</th>
                                              <th>Start</th>
                                              <th>End</th>
                                              <th>Duration</th>
                                              <th>Trainees</th>
                                              <th>Notes</th>
                                          </tr>
                                      </thead>
                                      <tbody id="mtotimesheet_data">
                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="mtotimesheet_status">No submitted patrols found!</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
    </div>
    <div class="row" id="ar" style="display:none">
              <div class="col-lg-12">
                  <div class="panel panel-danger">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseNine">Air Rescue Timesheets</a>
                          </h4>
                      </div>
                      <div id="collapseNine" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>Pilot</th>
                                              <th>Vehicle</th>
                                              <th>Start</th>
                                              <th>End</th>
                                              <th>Duration</th>
                                              <th>Passenger 1</th>
                                              <th>Passenger 2</th>
                                              <th>Passenger 3</th>
                                              <th>Crashed</th>
                                          </tr>
                                      </thead>
                                      <tbody id="ar_data">

                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="ar_status">No timesheets found!</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
    </div>
    <div class="row" id="rir" style="display:none">
              <div class="col-lg-12">
                  <div class="panel panel-info">
                      <div class="panel-heading">
                          <h4 class="panel-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseTen">RIR Timesheets</a>
                          </h4>
                      </div>
                      <div id="collapseTen" class="panel-collapse collapse in">
                          <div class="panel-body">
                              <div class="table-responsive">
                                  <table class="table table-hover">
                                      <thead>
                                          <tr>
                                              <th>Timestamp</th>
                                              <th>Driver</th>
                                              <th>Vehicle</th>
                                              <th>Start</th>
                                              <th>End</th>
                                              <th>Duration</th>
                                              <th>Passenger 1</th>
                                              <th>Passenger 2</th>
                                              <th>Passenger 3</th>
                                          </tr>
                                      </thead>
                                      <tbody id="rir_data">

                                      </tbody>
                                  </table>

                                  <p style="text-align:center" id="rir_status">No timesheets found!</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
    </div>
</div>

<script>
    $(function() {
        window.chart = new Chart($("#timeGraph"), {
            type: 'bar',
            data: {
                labels: ["Total", "Last Month", "Last Week"],
                datasets: [
                    {
                        label: "Police",
                        backgroundColor: "#2395ff",
                        data: [0,0,0]
                    }, {
                        label: "NHS",
                        backgroundColor: "#18b235",
                        data: [0,0,0]
                    }, {
                        label: "Civilian",
                        backgroundColor: "#7442f4",
                        data: [0,0,0]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        doSteamidCheck();
    });


    function HideAll() {
        $("#feedback").hide();
        $("#recruitment").hide();
        $("#timesheet").hide();
        $("#searchLogins").hide();
        $("#searchLoginsGraph").hide();
        $("#searchLoginsBox").hide();
        $("#ar").hide();
        $("#rir").hide();
        $("#mtoFeedback").hide();
        $("#recommendation").hide();
        $("#submitAR").hide();
    }

    $("#showLogins").on("change", function(){
        HideAll();
        $("#searchLogins").show();
        $("#searchLoginsGraph").show();
        $("#searchLoginsBox").show();
        doLoginSearch();
    });

    $("#showAR").on("change", function(){
        HideAll();
        $("#ar").show();
    });

    $("#showRIR").on("change", function(){
        HideAll();
        $("#rir").show();
    });

    $("#showFeedback").on("change", function(){
        HideAll();
        $("#feedback").show();
    });

    $("#showTimesheet").on("change", function(){
        HideAll();
        $("#timesheet").show();
    });

    $("#showRecruitment").on("change", function(){
        HideAll();
        $("#recruitment").show();
    });

    $("#openFeedback").on("click", function(){
        HideAll();
        $("#mtoFeedback").show();
    });

    $("#openRecommendation").on("click", function(){
        HideAll();
        $("#recommendation").show();
    });

    $("#opensubmitAR").on("click", function(){
        HideAll();
        $("#submitAR").show();
    });

    $("#do_all").on("change", function(){
        doLoginSearch();
    });

    var steamidChangeTimer = false;

    $("#player_steamid").on("input", function(){
        if(steamidChangeTimer !== false) clearTimeout(steamidChangeTimer);
            steamidChangeTimer = setTimeout(function(){

            doSteamidCheck();
            doLoginSearch();

            steamidChangeTimer = false;
        }, 500);
    });

    var nameChangeTimer = false;

    $("#player_name").on("change", function(){
        if(nameChangeTimer !== false) clearTimeout(nameChangeTimer);
            nameChangeTimer = setTimeout(function(){

            doSteamidCheck();
            doLoginSearch();

            nameChangeTimer = false;
        }, 500);
    });

    function doSteamidCheck() {

        if($("#player_steamid").val() !== "") {
            doSteamidCheckReal($("#player_steamid").val());
        } else if($("#player_name").val() !== "") {
            doSteamidCheckReal($("#player_name").val());
        }
    }

    function doSteamidCheckReal(value) {
        $("#steamid2_data").hide();
        $("#steamid3_data").hide();
        $("#steamid2_status").text("Searching...").show();

        var data = [
            ["medic_search_steamid2", "steamid2", "No results found!"],
            ["medic_search_steamid3", "steamid3", ""],
            ["search_interview_data", "interview", "No results found!"],
            ["search_feedback", "feedback", "No MTO feedbacks found!"],
            ["search_police", "police", "No results found!"],
            ["search_appteam", "appteam", "No applications found!"],
            ["search_ar", "ar", "No timesheets found!"],
            ["search_rir", "rir", "No timesheets found!"],
            ["medic_search_mtosteamid", "mtofeedback", "No submitted feedbacks as an MTO/SMTO found!"]
        ];

        if ($("#player_steamid").val().indexOf('"') >= 0) {
          var feedbackurl = "https://docs.google.com/forms/d/e/1FAIpQLSeX9gisW0VYvbEVLzMdJ40WBRQneuJumJ0v9Kmvr3QuNYkf0w/viewform?embedded=true&entry.259787756=%22<?=$me->getSteamid()?>%22&entry.1869560408=" + $("#player_steamid").val();
          $('#mtoFeedbackLink').attr('src', feedbackurl)
        } else if($("#player_steamid").val() !== "") {
          var feedbackurl = "https://docs.google.com/forms/d/e/1FAIpQLSeX9gisW0VYvbEVLzMdJ40WBRQneuJumJ0v9Kmvr3QuNYkf0w/viewform?embedded=true&entry.259787756=%22<?=$me->getSteamid()?>%22&entry.1869560408=%22"+ $("#player_steamid").val() + "%22";
          $('#mtoFeedbackLink').attr('src', feedbackurl)
        } else if($("#player_name").val() !== "") {
          var feedbackurl = "https://docs.google.com/forms/d/e/1FAIpQLSeX9gisW0VYvbEVLzMdJ40WBRQneuJumJ0v9Kmvr3QuNYkf0w/viewform?embedded=true&entry.259787756=%22<?=$me->getSteamid()?>%22&entry.1869560408=" + $("#player_name").val();
          $('#mtoFeedbackLink').attr('src', feedbackurl)
        }

        if ($("#player_steamid").val().indexOf('"') >= 0) {
          var recommendationURL = "https://docs.google.com/forms/d/e/1FAIpQLScih7uRGPN5YTjT2eZ1W9FePQ0YDw0gtsCe_1WF5e1qEZ0E4w/viewform?embedded=true&entry.1770360570=<?=$me->getUsername()?>&entry.488458342=" + $("#player_steamid").val();
          $('#recommendationURL').attr('src', recommendationURL)
        } else if($("#player_steamid").val() !== "") {
          var recommendationURL = "https://docs.google.com/forms/d/e/1FAIpQLScih7uRGPN5YTjT2eZ1W9FePQ0YDw0gtsCe_1WF5e1qEZ0E4w/viewform?embedded=true&entry.1770360570=<?=$me->getUsername()?>&entry.488458342=%22" + $("#player_steamid").val() + "%22";
          $('#recommendationURL').attr('src', recommendationURL)
        } else if($("#player_name").val() !== "") {
          var recommendationURL = "https://docs.google.com/forms/d/e/1FAIpQLScih7uRGPN5YTjT2eZ1W9FePQ0YDw0gtsCe_1WF5e1qEZ0E4w/viewform?embedded=true&entry.1770360570=<?=$me->getUsername()?>&entry.488458342=" + $("#player_name").val();
          $('#recommendationURL').attr('src', recommendationURL)
        }

        if ($("#player_steamid").val().indexOf('"') >= 0) {
          var submitARurl = "https://docs.google.com/forms/d/e/1FAIpQLSc4hJE9Zw07hbBbTpe65gzNcoPWwVKE2u_V3soMVUZvTV2n4Q/viewform?embedded=true&entry.1231850490=%22<?=$me->getSteamid()?>%22&entry.953639838=" + $("#player_steamid").val();
          $('#submitARurl').attr('src', submitARurlL)
        } else if($("#player_steamid").val() !== "") {
          var submitARurl = "https://docs.google.com/forms/d/e/1FAIpQLSc4hJE9Zw07hbBbTpe65gzNcoPWwVKE2u_V3soMVUZvTV2n4Q/viewform?embedded=true&entry.1231850490=%22<?=$me->getSteamid()?>%22&entry.953639838=%22" + $("#player_steamid").val() + "%22";
          $('#submitARurl').attr('src', submitARurl)
        } else if($("#player_name").val() !== "") {
          var submitARurl = "https://docs.google.com/forms/d/e/1FAIpQLSc4hJE9Zw07hbBbTpe65gzNcoPWwVKE2u_V3soMVUZvTV2n4Q/viewform?embedded=true&entry.1231850490=%22<?=$me->getSteamid()?>%22&entry.953639838=" + $("#player_name").val();
          $('#submitARurl').attr('src', submitARurl)
        }


        for (var i = 0; i < data.length; i++) {
            (function(key){
                var ajaxdata = {};
                ajaxdata[data[key][0]] = value;

                $.post("#", ajaxdata).done(function(htmldata) {
                    if(htmldata !== "false") {
                        $("#"+data[key][1]+"_data").html(htmldata).show();
                        $("#"+data[key][1]+"_status").hide();
                    } else {
                        $("#"+data[key][1]+"_data").hide();
                        if(data[key][2] !== "") {
                            $("#"+data[key][1]+"_status").text(data[key][2]).show();
                        }
                    }
                }).fail(function() {
                    $("#"+data[key][1]+"_data").hide();
                    $("#"+data[key][1]+"_status").text("Failed to connect to the server!").show();
                });
            })(i);
        }

        $.post("#", {
            search_timesheet: value
        }).done(function(data) {
            if(data === "false") {
                $("#timesheet_data").hide();
                $("#timesheet_status").text("No applications found!").show();
            } else {
                $("#timesheet_data").html(data).show();

                var total_duration = $("#timesheet_data #total_duration td").html();
                var total_duration_30days = $("#timesheet_data #total_duration_30days td").html();
                var total_duration_7days = $("#timesheet_data #total_duration_7days td").html();
                var total_duration_average = $("#timesheet_data #total_duration_average td").html();
                $("#timesheet_data #total_duration").remove();
                $("#timesheet_data #total_duration_30days").remove();
                $("#timesheet_data #total_duration_7days").remove();
                $("#timesheet_data #total_duration_average").remove();

                $("#timesheetsearch_data_total_table tbody").html("<tr><td>"+total_duration+"</td><td>"+total_duration_30days+"</td><td>"+total_duration_7days+"</td><td>"+total_duration_average+"</td></tr>");
                $("#timesheetsearch_data_total_table").show();
                $("#timesheet_status").hide();
            }
        }).fail(function() {
            $("#timesheet_data").hide();
            $("#timesheet_status").text("Failed to connect to the server!").show();
        });

        $.post("#", {
            search_timesheet_mto: value
        }).done(function(data) {
            if(data === "false") {
                $("#mtotimesheet_data").hide();
                $("#mtotimesheet_status").text("No applications found!").show();
            } else {
                $("#mtotimesheet_data").html(data).show();

                var total_duration = $("#mtotimesheet_data #total_duration td").html();
                var total_duration_30days = $("#mtotimesheet_data #total_duration_30days td").html();
                var total_duration_7days = $("#mtotimesheet_data #total_duration_7days td").html();
                var total_duration_average = $("#mtotimesheet_data #total_duration_average td").html();
                $("#mtotimesheet_data #total_duration").remove();
                $("#mtotimesheet_data #total_duration_30days").remove();
                $("#mtotimesheet_data #total_duration_7days").remove();
                $("#mtotimesheet_data #total_duration_average").remove();

                $("#mtotimesheetsearch_data_total_table tbody").html("<tr><td>"+total_duration+"</td><td>"+total_duration_30days+"</td><td>"+total_duration_7days+"</td><td>"+total_duration_average+"</td></tr>");
                $("#mtotimesheetsearch_data_total_table").show();
                $("#mtotimesheet_status").hide();
            }
        }).fail(function() {
            $("#mtotimesheet_data").hide();
            $("#mtotimesheet_status").text("Failed to connect to the server!").show();
        });
    }

    function doLoginSearch() {
        if($("#player_steamid").val() !== "") {
            doLoginSearchReal($("#player_steamid").val());
        } else if($("#player_name").val() !== "") {
            doLoginSearchReal($("#player_name").val());
        }
    }

    function doLoginSearchReal(value) {
        $("#steamidsearch_data_total_table").hide();
        $("#steamidsearch_data").hide();
        $("#steamidsearch_status").text("Searching...").show();

        $.post("#", {
            login_search: value,
            do_all: $("#do_all").is(":checked")
        }).done(function(data) {
            if(data === "false") {
                $("#steamidsearch_data").hide();
                $("#steamidsearch_status").text("No results found!").show();

                doActivityGraph([0,0,0], [0,0,0], [0,0,0]);
            } else {
                $("#steamidsearch_data").html(data);

                var total_duration = $("#steamidsearch_data #total_duration td").html();
                var total_duration_30days = $("#steamidsearch_data #total_duration_30days td").html();
                var total_duration_7days = $("#steamidsearch_data #total_duration_7days td").html();
                var total_duration_average = $("#steamidsearch_data #total_duration_average td").html();
                $("#steamidsearch_data #total_duration").remove();
                $("#steamidsearch_data #total_duration_30days").remove();
                $("#steamidsearch_data #total_duration_7days").remove();
                $("#steamidsearch_data #total_duration_average").remove();

                var graph_civLoginData = JSON.parse($("#steamidsearch_data #graph_civLoginData td").html());
                var graph_policeLoginData = JSON.parse($("#steamidsearch_data #graph_policeLoginData td").html());
                var graph_medicLoginData = JSON.parse($("#steamidsearch_data #graph_medicLoginData td").html());
                $("#steamidsearch_data #graph_civLoginData").remove();
                $("#steamidsearch_data #graph_policeLoginData").remove();
                $("#steamidsearch_data #graph_medicLoginData").remove();

                $("#steamidsearch_data_total_table tbody").html("<tr><td>"+total_duration+"</td><td>"+total_duration_30days+"</td><td>"+total_duration_7days+"</td><td>"+total_duration_average+"</td></tr>");

                $("#steamidsearch_data_total_table").show();
                $("#steamidsearch_data").show();

                $("#steamidsearch_status").hide();

                doActivityGraph(graph_civLoginData, graph_policeLoginData, graph_medicLoginData);
            }
        }).fail(function() {
            $("#steamidsearch_data").hide();
            $("#steamidsearch_status").text("Failed to connect to the server!").show();

            doActivityGraph([0,0,0], [0,0,0], [0,0,0]);
        });
    }

    function doActivityGraph(graph_civLoginData, graph_policeLoginData, graph_medicLoginData) {
        window.chart.data.datasets[0].data = graph_policeLoginData;
        window.chart.data.datasets[1].data = graph_medicLoginData;
        window.chart.data.datasets[2].data = graph_civLoginData;

        window.chart.update();
    }
</script>
