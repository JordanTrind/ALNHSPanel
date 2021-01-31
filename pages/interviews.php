<?php
if(!$me->hasPermission("interviews") && !$me->hasPermission("smto") && !$me->hasPermission("consultants")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<div id="page-wrapper">
    <?php
        if(isset($under[0])) {
            $interview = new Interview();
            $interview->getFromDB($under[0]);

            if($interview->getId()) {
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Interview ID: <?=$interview->getId()?> - <?=$interview->getName()?> <h4><?=$interview->getTimestamp()?></h4></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="disabledSelect">Steam ID</label>
                            <input class="form-control" type="text" placeholder="Steam ID" value="<?=trim($interview->getSteamid(), '"')?>" disabled>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="disabledSelect">Interviewer</label>
                            <input class="form-control" type="text" placeholder="Disabled input" value="<?=$interview->getInterviewer()?>" disabled>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="disabledSelect">Forum Profile</label><br />
                            <p class="form-control-static"><a href="<?=$interview->getForum()?>" target="_blank">Click here</a></p>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="disabledSelect">Link to edit</label><br />
                            <p class="form-control-static"><a href="<?=$interview->getLink()?>" target="_blank">Click here</a></p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Remarks</label>
                            <textarea class="form-control" rows="5" disabled><?=$interview->getRemarks()?></textarea>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="disabledSelect">Total score</label>
                            <input class="form-control" type="text" placeholder="Total score" value="<?=$interview->getTotal()?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="disabledSelect">Result</label>
                            <input class="form-control" type="text" placeholder="Result" value="<?=$interview->getResult()?>" disabled>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="disabledSelect">Age</label>
                            <input class="form-control" type="text" placeholder="Age" value="<?=$interview->getAge()?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="disabledSelect">Entered</label>
                            <input class="form-control" type="text" placeholder="Entered" value="<?=$interview->getEntered()?>" disabled>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>1) Why do you want to be in the NHS? - Score: <?=round($interview->getScore())?> / 10</label><br />
                    <span class="question_hint">(Use own initative and score depending on how well they would fit in / bring to the force)</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ1()?></textarea>
                </div>

                <div class="form-group">
                    <label>2) What would you say are important qualities to have when playing as a Medic? - Score: <?=round($interview->getScore_2())?> / 5 </label><br />
                    <span class="question_hint">(The ability to Roleplay any given scenario and complete jobs in an efficient manner)</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ2()?></textarea>
                </div>

                <div class="form-group">
                    <label>3) There is a bank robbery in progress. Both Rebels and Police are down and you are currently at the Police Checkpoint. What do you do? - Score: <?=round($interview->getScore_3())?> / 10 </label><br />
                    <span class="question_hint">(Contact Police requesting an update on the situation and permission to revive those at the bank. In these situations Police are priority #1 so they can arrest the rebels once revived)</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ3()?></textarea>
                </div>

                <div class="form-group">
                    <label>4) You are responding to a routine incident. Whilst reviving the individual, a person approaches and without communicating shoots and kills you. How do you react? - Score: <?=round($interview->getScore_4())?> / 10</label><br />
                    <span class="question_hint">(Try to resolve in TS and if not resolved report to the NHS leader and/or Administrators)</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ4()?></textarea>
                </div>

                <div class="form-group">
                    <label>5) An individual approaches you with an illegal firearm and asks you to heal both themself and their friend. How do you proceed? - Score: <?=round($interview->getScore_5())?> / 10</label><br />
                    <span class="question_hint">(Roleplay the situation as normal and providing the correct Medical assistance but be extra careful about what's going on around you. Whilst doing this, advise the Police of the situation so that they may lend support and ensure you are safe)</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ5()?></textarea>
                </div>

                <div class="form-group">
                    <label>6) Several people are killed and requesting medical assistance. As you arrive on the scene a rebel approaches you gun drawn saying "Do not revive or I'll shoot you". How do you proceed? - Score: <?=round($interview->getScore_6())?> / 10</label><br />
                    <span class="question_hint">(Roleplay the scenario in an attempt to save the lives of those on the ground. Failing this. Leave the area as requested. Contact the police allowing them to secure the zone and allowing you to revive those people)</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ6()?></textarea>
                </div>

                <div class="form-group">
                    <label>7) A civilian approaches you in an NHS vehicle. They wish to give it back to you. How do you proceed? - Score: <?=round($interview->getScore_7())?> / 5 </label><br />
                    <span class="question_hint">(Roleplay the situation and try to find out how it was taken. If illegally, contact the Police. If not, thank them (Reward))</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ7()?></textarea>
                </div>

                <div class="form-group">
                    <label>8) An individual wants you to carry out a health checkup. During this time, someone is killed and requests a Medic. How do you proceed? - Score: <?=round($interview->getScore_8())?> / 5</label><br />
                    <span class="question_hint">(Communicate with fellow Medics and see if one is available. If they are, continue the RP. If not, take the person with you if needed)</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ8()?></textarea>
                </div>

                <div class="form-group">
                    <label>9) What can you bring to the table? - Score: <?=round($interview->getScore_9())?> / 10</label><br />
                    <span class="question_hint">(Use own initative and score depending on how well they would fit in/ bring to the force)</span>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getQ9()?></textarea>
                </div>

                <div class="form-group">
                    <label>What do you think of the current state of the NHS?</label>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getOpinion()?></textarea>
                </div>

                <div class="form-group">
                    <label>Favourite vehicle?</label>
                    <textarea class="form-control" rows="3" disabled><?=$interview->getVehicle()?></textarea>
                </div>
                <?php


            } else {
                echo "<h1 class='error'>Interview not found!</h1>";
            }
        } else {
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Interviews <button type="button" class="btn btn-info" id="update_data_sheet1" style="float: right;">Update Data</button></h1>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Player ID</th>
                                        <th>Entered</th>
                                        <th>Score</th>
                                        <th>Result</th>
                                        <th>Interviewer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $interviews = new Interview();
                                        $result = $interviews->getFromDB(NULL, NULL, "result", false, false, "timestamp", true);
                                        if($result->num_rows > 0) {
                                            while($row = $result->fetch_object()) {
                                                $interview = new Interview($row);

                                                $class = "";
                                                if(strtolower($interview->getResult()) === "yes") {
                                                    $class = " class='success'";
                                                } else if(strtolower($interview->getResult()) === "pardon") {
                                                    $class = " class='warning'";
                                                } else if(strtolower($interview->getResult()) === "no") {
                                                    $class = " class='danger'";
                                                }

                                                if(strtolower($interview->getEntered()) === "no") {
                                                    $enteredclass = " class='danger'";
                                                } else {
                                                  $enteredclass = " class=''";
                                                }

                                                echo "<tr style='cursor: pointer;' onClick='location.href=\"/interviews/".$interview->getId()."/\"'>";
                                                    echo "<td>".$interview->getTimestamp()."</td>";
                                                    echo "<td>".$interview->getName()."</td>";
                                                    echo "<td>".$interview->getAge()."</td>";
                                                    echo "<td>".trim($interview->getSteamid(), '"')."</td>";
                                                    echo "<td".$enteredclass.">".$interview->getEntered()."</td>";
                                                    echo "<td>".$interview->getTotal()."</td>";
                                                    echo "<td".$class.">".$interview->getResult()."</td>";
                                                    echo "<td>".$interview->getInterviewer()."</td>";
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
            <?php
        }
    ?>
</div>

<script>
    $(function() {
        $("#update_data_sheet1").on("click", function(e) {
            e.preventDefault();

            var button = $(this);

            button.prop("disabled", true);
            EnableLoading();

            $.ajax({
                url: "https://api.shaynorman.com/spreadsheet_to_db/?sheetid=1",
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
    });
</script>
