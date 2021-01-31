<div id="page-wrapper">
    <?php
        if(isset($under[0])) {
            if($under[0] === "new" || $under[1] === "forward" || $under[1] === "reply" || $under[1] === "replyall") {
                $title = "New message";
                $subject = "";
                $content = "";
                $receiver = "";

                $show = false;
                if($under[1] === "forward" || $under[1] === "reply" || $under[1] === "replyall") {
                    $message = new Message();
                    $message->getFromDB($under[0]);
                    if($message->getId()) {
                        if(($message->getSender() === $me->getId() && $under[1] === "forward") || $me->getId() === "1") {
                            $show = true;
                        } else {
                            $receiver_count = 0;
                            if(strpos($message->getReceiver(), ",") !== false) {
                                foreach(explode(",", $message->getReceiver()) as $id) {
                                    if($id === $me->getId()) {
                                        $show = true;
                                    }
                                }
                            } elseif($message->getReceiver() === $me->getId()) {
                                $show = true;
                            }
                        }

                        if(!$show) {
                            echo "<h1 class='error'>You are not allowed to see this message!</h2>";
                        }
                    } else {
                        echo "<h1 class='error'>Message not found!</h2>";
                    }

                    if($under[1] === "forward") {
                        $title = "Forward message";
                        $subject = "FW: ".$message->getSubject();
                    } else {
                        $title = "Reply message";
                        $subject = "RE: ".$message->getSubject();

                        if($under[1] === "reply") {
                            $receiver = $message->getSender();
                        } elseif($under[1] === "replyall") {
                            $temp = explode(",", $message->getReceiver());
                            if (($key = array_search($me->getId(), $temp)) !== false) {
                                unset($temp[$key]);
                            }

                            $receiver = $message->getSender().",".implode(",", $temp);
                        }
                    }

                    $receiver = trim($receiver, ",");

                    $content = "<br /><hr><p>
                    <strong>From:</strong> ".$message->getSender(true)."<br />
                    <strong>Sent:</strong> ".$message->getSent()."<br />
                    <strong>To:</strong> ".$message->getReceiver(true, false)."<br />
                    <strong>Subject:</strong> ".$message->getSubject()."<br />
                    </p><br />".$message->getContent();
                } else {
                    $show = true;
                }

                if($show) {
                ?>
                <div class="row" style="height: 100px">
                    <div class="col-lg-12">
                        <h1 class="page-header"><?=$title?></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-lg-6" id='group_box'>
                                <div class="form-group">
                                    <label>Send to:</label>
                                    <select class="form-control" name='group' placeholder='Group'>
                                        <?php
                                            $groups = array(
                                                "specific_user" => "Specific user(s)"
                                            );
                                            if($me->hasPermission("all")) {
                                                $groups = array_merge($groups, array(
                                                    "everyone" => "Everyone",
                                                    "consultants" => "Consultant",
                                                    "smto" => "SMTO",
                                                    "mto" => "MTO",
                                                    "seniorappteam" => "Senior App Team",
                                                    "app_team" => "App Team",
                                                    "rir" => "RIR Staff",
                                                    "ar" => "AR Staff"
                                                ));
                                            } else if($me->hasPermission("consultants")) {
                                                $groups = array_merge($groups, array(
                                                    "smto" => "SMTO",
                                                    "mto" => "MTO",
                                                    "seniorappteam" => "Senior App Team",
                                                    "app_team" => "App Team",
                                                    "rir" => "RIR Staff",
                                                    "ar" => "AR Staff"
                                                ));
                                            } else {
                                                if($me->hasPermission("smto") || $me->hasPermission("mto")) {
                                                    $groups = array_merge($groups, array(
                                                        "mtolead" => "MTO Lead"
                                                    ));
                                                }
                                                if($me->hasPermission("seniorappteam")) {
                                                    $groups = array_merge($groups, array(
                                                        "app_team" => "App Team"
                                                    ));
                                                }
                                                if($me->hasPermission("app_team")) {
                                                    $groups = array_merge($groups, array(
                                                        "seniorappteam" => "Senior App Team"
                                                    ));
                                                }
                                                if($me->hasPermission("ar")) {
                                                    $groups = array_merge($groups, array(
                                                        "ar" => "AR Staff"
                                                    ));
                                                }
                                                if($me->hasPermission("rir")) {
                                                    $groups = array_merge($groups, array(
                                                        "rir" => "RIR Staff"
                                                    ));
                                                }
                                            }

                                            foreach($groups as $perm => $name) {
                                                echo "<option value='".$perm."'>".$name."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6" id='specific_user_selected'>
                                <label>User:</label>
                                <select class="form-control selectpicker" name='userid' placeholder='Username' data-none-selected-text='No user(s) selected' multiple>
                                    <?php
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
                                                    "66",
                                                    "7"
                                                );

                                                if(!in_array($user->getId(), $hide) && $user->getId() !== $me->getId()) {
                                                    echo "<option value='".$user->getId()."'>".$user->getUsername()."</option>";
                                                }
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-lg-10">
                                <div class="form-group">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject" value='<?=$subject?>'>
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <input type="button" name="send_message" class="form-control btn btn-info" value="Send">
                            </div>

                            <div class="col-lg-12">
                                <textarea id='new_message'><?=$content?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    $('.selectpicker').selectpicker('val', [<?=$receiver?>]);

                    function RemoveUnlicensedMessage(editor) {
                        var unlicensedmessage = editor.$wp.find("div:contains('Unlicensed copy of the Froala Editor. Use it legally by purchasing a license.')");

                        if(unlicensedmessage[0].outerHTML === '<div style="z-index: 9999;width: 100%; position: relative"><a href="https://www.froala.com/wysiwyg-editor?k=u" style="padding: 5px 10px;color: #FFF;text-decoration: none;background: #EF5350;display: block;font-size: 15px;" target="_blank">Unlicensed copy of the Froala Editor. Use it legally by purchasing a license.</a></div>') {
                            console.log(unlicensedmessage);

                            unlicensedmessage.css({
                                height: "0px"
                            });
                            unlicensedmessage.find("a").html("").css({
                                background: "transparent",
                                padding: "0px"
                            });

                            editor.placeholder.refresh(true);
                        }
                    }

                    $(function() {
                        $("select[name='group']").on("change", function() {
                            if($(this).val() === "specific_user") {
                                $("#group_box").removeClass("col-lg-12").addClass("col-lg-6");
                                $("#specific_user_selected").show();
                            } else {
                                $("#group_box").removeClass("col-lg-6").addClass("col-lg-12");
                                $("#specific_user_selected").hide();
                            }
                        });

                        $('#new_message').on('froalaEditor.initialized', function (e, editor) {
                            RemoveUnlicensedMessage(editor);
                        });
                        $('#new_message').on('froalaEditor.contentChanged', function (e, editor) {
                            RemoveUnlicensedMessage(editor);
                        });
                        $('#new_message').froalaEditor({
                            heightMin: 300
                        });

                        $("input[name='send_message']").on("click", function(e) {
                            e.preventDefault();

                            if($("input[name='subject']").val() === "" || $('#new_message').froalaEditor('html.get', true) === "") {
                                Alert("Message empty!", "Subject or content is empty!", "red");
                            } else if($("select[name='group']").val() === "specific_user" && $("select[name='userid']").val().join(",") === "") {
                                Alert("Receiver empty!", "Can't send a message to nobody!", "red");
                            } else {
                                $.post("#", {
                                    send_message: true,
                                    group: $("select[name='group']").val(),
                                    userid: $("select[name='userid']").val().join(","),
                                    subject: $("input[name='subject']").val(),
                                    content: $('#new_message').froalaEditor('html.get', true)
                                }).done(function(data) {
                                    if(data === "true") {
                                        Alert("Success!", "Message sent!", "green", function() {
                                            window.location.href = '/messages/';
                                        });
                                    } else {
                                        Alert("Failed!", "Message could not be sent!", "red");
                                    }
                                }).fail(function() {
                                    Alert("Error!", "Failed to connect to the server!", "red");
                                });
                            }
                        });
                    });
                </script>
                <?php
                }
            } else {
                $message = new Message();
                $message->getFromDB($under[0]);
                if($message->getId()) {
                    $show = false;
                    if($message->getSender() === $me->getId() || $me->getId() === "1") {
                        $show = true;
                    } else {
                        $receiver_count = 0;
                        if(strpos($message->getReceiver(), ",") !== false) {
                            $users = explode(",", $message->getReceiver());

                            foreach($users as $id) {
                                $user = new User();
                                $user->getFromDB($id);
                                if($user->getId() === $id) {
                                    $receiver_count++;
                                    if($id === $me->getId()) {
                                        $show = true;
                                    }
                                }
                            }
                        } elseif($message->getReceiver() === $me->getId()) {
                            $show = true;
                        }
                    }

                    if($show) {
                        $buttons = "";

                        if($message->getSender() !== $me->getId()) {
                            $buttons .= "<a href='./reply/' class='btn btn-info'>Reply</a><br />";

                            if($receiver_count > 1) {
                                $buttons .= "<a href='./replyall/' class='btn btn-info'>Reply all</a><br />";
                            }

                            if($me->getId() !== "1") {
                                $opened = explode(",", $message->getOpened());
                                if(!in_array($me->getId(), $opened)) {
                                    $opened[] = $me->getId();
                                }
                                if($opened[0] === "") {
                                    unset($opened[0]);
                                }
                                $message->setOpened(implode(",", $opened));
                                $message->update();
                            }
                        }

                        $buttons .= "<a href='./forward/' class='btn btn-info'>Forward</a>";

                        if($message->getSender() === "1") {
                            $buttons = "";
                        }

                        ?>
                        <div class="row" style="height: 100px">
                            <div class="col-lg-12 page-header">
                                <h1><?=$message->getSubject()?> <div class='pull-right'><?=$buttons?></div></h1>
                                <p>Sent: <?=$message->getSent()?></p>
                                <p>From: <?=$message->getSender(true)?></p>
                                <p>To: <?=$message->getReceiver(true, false)?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <?=$message->getContent()?>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "<h1 class='error'>You are not allowed to see this message!</h2>";
                    }
                } else {
                    echo "<h1 class='error'>Message not found!</h2>";
                }
            }
        } else {
        ?>
        <div class="row" style="height: 100px">
            <div class="col-lg-12">
                <h1 class="page-header">Inbox <a href='/messages/new/' class='btn btn-info pull-right'>New message</a></h1>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="col-xs-6">Subject</th>
                                    <th class="col-xs-2">Sender</th>
                                    <th class="col-xs-2">Opened</th>
                                    <th class="col-xs-2">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $messages = new Message();
                                    $result = $messages->getFromDB(null, null, "result", false, false, "sent", true);
                                    $foundany = false;
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_object()) {
                                            $message = new Message($row);

                                            $show = false;
                                            if($me->getId() === "1") {
                                                $show = true;
                                            } else {
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
                                            }

                                            if($show) {
                                                $foundany = true;

                                                $opened = false;
                                                if(in_array($me->getId(), explode(",", $message->getOpened()))) {
                                                    $opened = true;
                                                }

                                                if(!$opened || $message->getSender() !== "1") {
                                                    echo '<tr onClick="window.location.href = \'/messages/'.$message->getId().'/\';" style="'.($opened ? "cursor:pointer;" : "font-weight:bold;cursor:pointer;").'">
                                                        <td>'.$message->getSubject().'</td>
                                                        <td>'.$message->getSender(true).'</td>
                                                        <td>'.($opened ? "Yes" : "No").'</td>
                                                        <td>'.$message->getSent().'</td>
                                                    </tr>';
                                                }
                                            }
                                        }
                                    }

                                    if(!$foundany) {
                                        echo "<tr>
                                            <td>No received messages</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="height: 100px">
            <div class="col-lg-12">
                <h1 class="page-header">Outbox</h1>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="col-xs-6">Subject</th>
                                    <th class="col-xs-2">Receiver</th>
                                    <th class="col-xs-2">Opened</th>
                                    <th class="col-xs-2">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $messages = new Message();
                                    $result = $messages->getFromDB($me->getId(), "sender", "result", false, false, "sent", true);
                                    if($result->num_rows > 0) {
                                        while($row = $result->fetch_object()) {
                                            $message = new Message($row);

                                            echo '<tr onClick="window.location.href = \'/messages/'.$message->getId().'/\';" style="cursor:pointer;">
                                                <td>'.$message->getSubject().'</td>
                                                <td>'.$message->getReceiver(true, false).'</td>
                                                <td>'.$message->getOpened(true, false).'</td>
                                                <td>'.$message->getSent().'</td>
                                            </tr>';
                                        }
                                    } else {
                                        echo "<tr>
                                            <td>No sent messages</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>";
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
