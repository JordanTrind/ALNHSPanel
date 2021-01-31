<?php
    if($me->hasPermission("edituser") || $page === "profile") {
        if(isset($under[0]) || $page === "profile") {
            $user = new User();

            if($page === "profile") {
                $user = $me;
            } else if($under[0] !== "new") {
                $user->getFromDB($under[0]);
            }

            if($user->getId() || $under[0] === "new") {
                $disabled = "";

                if($user->hasPermission("consultants") && !$me->hasPermission("*")) {
                    $disabled = " disabled";
                }

                $passdisabled = $disabled;
                $updatedisabled = $disabled;
                $updatetext = "Save";

                $updateid = ($user->getId() ? $user->getId() : "new");

                if($page === "profile") {
                    $pageheader = "My Profile";
                    $disabled = " disabled";
                    $updatedisabled = "";
                    $updateid = "me";
                } else {
                    $pageheader = ($user->getUsername() ? "Edit user: ".$user->getUsername() : "Create new user");
                }

                ?>
                <div id="page-wrapper">
                    <form method="post" name="userform">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="page-header"><?=$pageheader?></h1>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <label>Panel Username</label>
                                <div class="form-group input-group">
                                    <span class="input-group-addon">@</span>
                                    <input class="form-control" name='username' placeholder='Username' value='<?=($user->getUsername() ? $user->getUsername() : "")?>'<?=$disabled?> required />
                                </div>

                                <div class="form-group">
                                    <label>Google Docs Email</label>
                                    <input class="form-control" name='email' placeholder='E-mail' value='<?=($user->getEmail() ? $user->getEmail() : "")?>'<?=$disabled?> required />
                                </div>

                                <div class="form-group">
                                    <label>Steam ID</label>
                                    <input class="form-control" name='steamid' placeholder='Steam ID' value='<?=($user->getSteamid() ? $user->getSteamid() : "")?>'<?=$disabled?> required />
                                </div>

                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="form-control" type='password' name='password' placeholder='Password' minlength="8" pattern="(.*[0-9].*)" oninvalid="this.setCustomValidity('Password does not meet requirements')" oninput="setCustomValidity('')" />
                                </div>

                                <div class="form-group">
                                    <label>Theme</label>
                                    <select class="form-control" name="usertheme">
                                        <?php
                                            $first = true;
                                            foreach(array(
                                                "Navy",
                                                "Red",
                                                "Dark Red",
                                                "Pink",
                                                "Orange",
                                                "Purple",
                                                "Dark Purple",
                                                "Green",
                                                "Dark Green",
                                                "Teal",
                                                "Blue",
                                                "Dark Blue",
                                                "Brown",
                                                "Gray",
                                                "Slate Gray",
                                                "Black",
                                            ) as $theme_name) {
                                                $theme_value = str_replace(" ", "", strtolower($theme_name));

                                                if($first) {
                                                    $first = false;
                                                    $theme_name = $theme_name." (Default)";
                                                }

                                                echo "<option ".($user->getUserTheme() == $theme_value ? ' selected="selected"' : "")." value='".$theme_value."' >".$theme_name."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Permissions</label>
                                    <label>(Consultants inherit all below them)</label>
                                    <?php
                                        $permission_icons = array(
                                            "all" => "fa-lock",
                                            "edituser" => "fa-users",
                                            "deleteuser" => "fa-times-circle",
                                            "mtolead" => "fa-bullhorn",
                                            "masterdb" => "fa-key",
                                            "consultants" => "fa-tasks",
                                            "smto" => "fa-pencil-square",
                                            "mto" => "fa-pencil",
                                            "seniorappteam" => "fa-files-o",
                                            "app_team" => "fa-file-text-o",
                                            "rir" => "fa-car",
                                            "ar" => "fa-plane",
                                            "interviews" => "fa-comments"
                                        );

                                        $permissions = array(
                                            "all" => "All",
                                            "edituser" => "Edit Users",
                                            "deleteuser" => "Delete User",
                                            "mtolead" => "MTO Lead",
                                            "masterdb" => "MasterDB Access",
                                            "consultants" => "Consultant",
                                            "smto" => "SMTO",
                                            "mto" => "MTO",
                                            "seniorappteam" => "Senior App Team",
                                            "app_team" => "App Team",
                                            "rir" => "RIR Staff",
                                            "ar" => "AR Staff",
                                            "interviews" => "Interview Trained (None CST/SMTO)"
                                        );

                                        $disableall = $disabled;

                                        foreach($permissions as $perm => $name) {
                                            $checked = "";
                                            if($user->hasPermission($perm)) {
                                                $checked = " checked";
                                            }

                                            if(!$disableall) {
                                                $disabled = "";

                                                if(!$disabled) {
                                                    if(($perm === "all" || $perm === "deleteuser" || $perm === "masterdb" || $perm === "edituser" || $perm === "consultants"  || $perm === "mtolead") && !$me->hasPermission("*")) {
                                                        $disabled = " disabled";
                                                    }

                                                }
                                            }

                                            echo '<div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="perm_checkbox" name="perm_'.$perm.'"'.$checked.$disabled.' /><i class="fa '.$permission_icons[$perm].' fa-fw"></i> '.$name.'
                                                </label>
                                            </div>';
                                        }
                                    ?>
                                </div>
                            </div>

                            <?php
                                $createdat = "Unknown";
                                $editedat = "Unknown";
                                $editedby = "Unknown";
                                if($user->getUpdated_by()) {
                                    try {
                                        $temp = new User();
                                        $temp->getFromDB($user->getUpdated_by());

                                        if($temp->getUsername()) {
                                            $editedby = $temp->getUsername();
                                        }
                                    } catch (Exception $ex) {}
                                }
                                if($user->getUpdated()) {
                                    $editedat = $user->getUpdated();
                                }
                                if($user->getCreated()) {
                                    $createdat = $user->getCreated();
                                }
                            ?>
                            <?php
                            if($page !== "profile") {
                            ?>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <p><span style="font-weight: bold">IP:</span> <?=($user->getIp() ? $user->getIp() : "Unknown")?></p>
                                    <p><span style="font-weight: bold">Created at:</span> <?=$createdat?></p>
                                    <p><span style="font-weight: bold">Last edited at:</span> <?=$editedat?></p>
                                    <p><span style="font-weight: bold">Last edited by:</span> <?=$editedby?></p>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="row">
                            <?php
                            if($page !== "profile") {
                            ?>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <input type="checkbox" name="mustchangepassword" <?=($user->MustChangePassword() ? " checked" : "")?><?=$disabled?> /> Must change password<br />
                                    <input type="checkbox" name="disabled" <?=($user->IsDisabled() ? " checked" : "")?><?=$disabled?> /> Account is disabled
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="id" value='<?=$updateid?>' />
                                <input type="submit" name="hiddensubmit" style="display: none;" />

                                <input type="button" name="updateuser" class="btn btn-success" value='<?=$updatetext?>'<?=$updatedisabled?> />

                                <?php
                                    if($page !== "profile") {
                                        $disabledelete = $disabled;

                                        if(!$me->hasPermission("deleteuser")) {
                                            $disabledelete = " disabled";
                                        }

                                        echo '<input type="button" name="deleteuser" class="btn btn-danger" value="Delete"'.$disabledelete.' />';
                                    }
                                ?>
                            </div>
                        </div>

                        <br />

                        <?php
                            $rank = "Unknown";
                            $department = "Unknown";
                            $activitystatus = "Unknown";
                            $ar = "Unknown";
                            $join = "Unknown";
                            $discord = "Unknown";
                            $forum = "Unknown";
                            $stats = "Unknown";
                            $rir = "Unknown";
                            $promo = "Unknown";

                            try {
                                $playerdata = new Playerdata();
                                $playerdata->getFromDB('"'.$user->getSteamid().'"');

                                if($playerdata->getRank()) {
                                    $rank = $playerdata->getRank();
                                }
                                if($playerdata->getDepartment()) {
                                    $department = $playerdata->getDepartment();
                                }
                                if($playerdata->getActivityStatus()) {
                                    $activitystatus = $playerdata->getActivityStatus();
                                }
                                if($playerdata->getAr()) {
                                    $ar = $playerdata->getAr();
                                }
                                if($playerdata->getJoinDate()) {
                                    $join = $playerdata->getJoinDate();
                                }
                                if($playerdata->getDiscord()) {
                                    $discord = $playerdata->getDiscord();
                                }
                                if($playerdata->getForum()) {
                                    $forum = "<a href='".$playerdata->getForum()."' target='_blank'>".$playerdata->getForum()."</a>";
                                }
                                if($playerdata->getStats()) {
                                    $stats = "<a href='".$playerdata->getStats()."' target='_blank'>".$playerdata->getStats()."</a>";
                                }
                                if($playerdata->getRir()) {
                                    $rir = $playerdata->getRir();
                                }
                                if($playerdata->getPromo()) {
                                    $promo = $playerdata->getPromo();
                                }
                            } catch (Exception $ex) {}
                        ?>

                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table first-bold">
                                    <tbody>
                                        <tr>
                                            <td>Rank</td>
                                            <td><?=$rank?></td>
                                        </tr>
                                        <tr>
                                            <td>Department</td>
                                            <td><?=$department?></td>
                                        </tr>
                                        <tr>
                                            <td>Activity</td>
                                            <td><?=$activitystatus?></td>
                                        </tr>
                                        <tr>
                                            <td>Air Rescue</td>
                                            <td><?=$ar?></td>
                                        </tr>
                                        <tr>
                                            <td>Join Date</td>
                                            <td><?=$join?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-6">
                                <table class="table first-bold">
                                    <tbody>
                                        <tr>
                                            <td>Discord ID</td>
                                            <td><?=$discord?></td>
                                        </tr>
                                        <tr>
                                            <td>Forum Link</td>
                                            <td><?=$forum?></td>
                                        </tr>
                                        <tr>
                                            <td>Stats Link</td>
                                            <td><?=$stats?></td>
                                        </tr>
                                        <tr>
                                            <td>RIR</td>
                                            <td><?=$rir?></td>
                                        </tr>
                                        <tr>
                                            <td>Last promotion</td>
                                            <td><?=$promo?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
            } else {
                echo "<h1 class='error'>Permission denied!</h1>";
            }
        } else {
            ?>
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">User Management</h1>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <a href="/users/new/" class="btn btn-primary"><b>New User</b></i></a>

                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <!--<th>DBID</th>-->
                                            <th>Permissions</th>
                                            <th>Username</th>
                                            <th>Rank</th>
                                            <th>Department</th>
                                            <th>SteamID</th>
                                            <!--<th>IP</th>-->
                                            <th>Lastlogin</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $finalusers = array();
                                            $usedusersids = array();
                                            $temp = array();

                                            $users = new User();
                                            $result = $users->getFromDB(NULL, NULL, "result");
                                            if($result->num_rows > 0) {
                                                while($row = $result->fetch_object()) {
                                                    $user = new User($row);

                                                    $temp[] = $user;
                                                }
                                            }

                                            foreach(array(
                                                "all",
                                                "deleteuser",
                                                "edituser",
                                                "mtolead",
                                                "consultants",
                                                "smto",
                                                "mto",
                                                "seniorappteam",
                                                "app_team",
                                                "rir",
                                                "ar",
                                                "masterdb",
                                                "interviews"
                                            ) as $perm) {
                                                foreach($temp as $user) {
                                                    $id = $user->getId();

                                                    if(!isset($usedusersids[$id])) {
                                                        if($user->hasPermission($perm)) {
                                                            $usedusersids[$id] = true;
                                                            $finalusers[] = $user;
                                                        }
                                                    }
                                                }
                                            }

                                            foreach($temp as $user) {
                                                $id = $user->getId();

                                                if(!isset($usedusersids[$id])) {
                                                    $usedusersids[$id] = true;
                                                    $finalusers[] = $user;
                                                }
                                            }

                                            foreach($finalusers as $user) {
                                                $online = new Online();
                                                $online->getFromDB($user->getId());

                                                $lasteditedby = "Unknown";
                                                try {
                                                    $temp = new User();
                                                    $temp->getFromDB($user->getUpdated_by());

                                                    if($temp->getUsername()) {
                                                        $lasteditedby = $temp->getUsername();
                                                    }
                                                } catch (Exception $ex) {}

                                                $permission_icons = array(
                                                    //"deleteuser" => "fa-times-circle",
                                                    "edituser" => "fa-users",
                                                    "mtolead" => "fa-bullhorn",
                                                    "consultants" => "fa-tasks",
                                                    "smto" => "fa-pencil-square",
                                                    "mto" => "fa-pencil",
                                                    "seniorappteam" => "fa-files-o",
                                                    "app_team" => "fa-file-text-o",
                                                    "rir" => "fa-car",
                                                    "ar" => "fa-plane",
                                                    "masterdb" => "fa-key",
                                                    "interviews" => "fa-comments"
                                                );

                                                $permission_list = "";
                                                if($user->hasPermission("*")) {
                                                    $permission_list = ' <i class="fa fa-lock fa-fw"></i>';
                                                } else {
                                                    foreach($permission_icons as $perm => $icon) {
                                                        if($user->hasPermission($perm)) {
                                                            $permission_list .= ' <i class="fa '.$icon.' fa-fw"></i>';

                                                            //if($perm === "command") {
                                                            //    break;
                                                            //}

                                                            //if($perm === "consultants") {
                                                            //    break;
                                                            //}
                                                        }
                                                    }
                                                }

                                                $rank = "Unknown";
                                                $department = "Unknown";

                                                try {
                                                    $playerdata = new Playerdata();
                                                    $playerdata->getFromDB('"'.$user->getSteamid().'"');

                                                    if($playerdata->getRank()) {
                                                        $rank = $playerdata->getRank();
                                                    }
                                                    if($playerdata->getDepartment()) {
                                                        $department = $playerdata->getDepartment();
                                                    }
                                                } catch (Exception $ex) {}

                                                $title = "Last edited: ".$user->getUpdated()." by ".$lasteditedby." | "." Created: ".$user->getCreated();

                                                $ip = "Unknown";
                                                if($user->getIp()) {
                                                    $ip = $user->getIp();
                                                }

                                                $class = "";
                                                if($user->IsDisabled()) {
                                                    $class = " class='dark_red'";
                                                } elseif($user->hasPermission("*")) {
                                                    $class = " class='danger'";
                                                } elseif($user->hasPermission("consultants")) {
                                                    $class = " class='orange'";
                                                } elseif($user->hasPermission("smto")) {
                                                    $class = " class='dark_blue'";
                                                } elseif($user->hasPermission("mto")) {
                                                    $class = " class='info'";
                                                } elseif($user->hasPermission("app_team") || $user->hasPermission("seniorappteam")) {
                                                    $class = " class='success'";
                                                }  elseif($user->hasPermission("ar")) {
                                                    $class = " class='purple'";
                                                }  elseif($user->hasPermission("rir")) {
                                                    $class = " class='pink'";
                                                }


                                                echo "<tr style='cursor: pointer;'".$class." title='".$title."' onClick='location.href=\"/users/".$user->getId()."/\"'>";
                                                    //echo "<td>".$user->getId()."</td>";
                                                    echo "<td>".$permission_list."</td>";
                                                    echo "<td>".$user->getUsername()."</td>";
                                                    echo "<td>".$rank."</td>";
                                                    echo "<td>".$department."</td>";
                                                    echo "<td>".$user->getSteamid()."</td>";
                                                    //echo "<td>".$ip."</td>";
                                                    echo "<td>".$user->getLastlogin()."</td>";
                                                    echo "<td>".$online->getOnlineStyled()."</td>";
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            $("#update_theme").on("select", function(){
                var topMenu = document.querySelector("#topMenuBar");
                var sideMenu = document.querySelector("#sideMenuBar");
                topMenu.classList.remove("navbar-theme-navy");
                sideMenu.classList.remove("navbar-theme-navy");
                topMenu.classList.add("navbar-theme-red");
                sideMenu.classList.add("navbar-theme-red");
            });
            </script>

            <?php
        }
    } else {
        echo "<h1 class='error'>Permission denied!</h1>";
    }
