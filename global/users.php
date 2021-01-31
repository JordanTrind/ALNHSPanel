<?php
    if(isset($_POST["updateuser"])) {
        if($me->hasPermission("edituser") || $_POST["updateuser"] === "me") {
            try {
                $user = new User();
                if($_POST["updateuser"] !== "new") {
                    if($_POST["updateuser"] === "me") {
                        $me->setUserTheme($_POST["usertheme"]);
                        $user = $me;
                    } else {
                        $user->getFromDB($_POST["updateuser"]);

                        if(!$user->getId()) {
                            die("User not found!");
                        }

                        if($user->hasPermission("consultants") && !$me->hasPermission("*")) {
                            die("You are not allowed to edit this user!");
                        }
                    }
                }

                if(!empty($_POST["password"])) {
                    $logout = true;

                    if(isset($_POST["mustchangereset"])) {
                        $logout = false;
                    }

                    $user->setPassword($_POST["password"]);
                    $user->GeneratePasswordHash($logout);

                    if(isset($_POST["mustchangereset"]) && $_POST["updateuser"] === "me") {
                        $user->setMustChangePassword(false);
                    }
                }

                if($_POST["updateuser"] !== "me") {
                    $user->setUsername($_POST["username"]);
                    $user->setEmail($_POST["email"]);
                    $user->setUserTheme($_POST["usertheme"]);
                    $user->setSteamid($_POST["steamid"]);
                    $user->setUpdated(time());
                    $user->setUpdated_by($me->getId());
                    $user->setMustChangePassword($_POST["mustchangepassword"]);
                    $user->setDisabled($_POST["disabled"]);

                    $perm = "";
                    foreach($_POST as $key => $value) {
                        if($value === "true") {
                            if($key === "perm_all") {
                                if($me->hasPermission("*")) {
                                    $perm = "*";

                                    break;
                                }
                            }

                            if(substr($key, 0, 5) === "perm_") {
                                $temp = substr(rtrim($key, "_"), 5);

                                $doit = true;
                                if(($temp === "all" || $temp === "deleteuser" || $temp === "command") && !$me->hasPermission("*")) {
                                    $doit = false;
                                }

                                if(($temp === "edituser" || $temp === "consultants") && !$me->hasPermission("command")) {
                                    $doit = false;
                                }

                                if($doit) {
                                    $perm .= ",".$temp;
                                }
                            }
                        }
                    }

                    $user->setCustomPermissions(trim($perm, ","));
                }

                if($user->getId()) {
                    if($user->update()) {
                        if($_POST["updateuser"] === "me") {
                            die("true4");
                        }

                        if(!empty($_POST["password"])) {
                            die("true3");
                        }

                        die("true2");
                    }
                } elseif($_POST["updateuser"] === "new") {
                    if($user->insert()) {
                        die("true");
                    }
                }
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        } else {
            die("You don't have permissions to edit/create a user!");
        }

        die("Unknown error!");
    }

    if(isset($_POST["deleteuser"])) {
        if($me->hasPermission("deleteuser")) {
            try {
                $user = new User();
                $user->getFromDB($_POST["deleteuser"]);

                if(!$user->getId()) {
                    die("User not found!");
                }

                if($user->getUsergroup() === "1") {
                    die("This user cannot be deleted!");
                }

                if($user->delete()) {
                    die("true");
                }
            } catch (Exception $ex) {
                die($ex->getMessage());
            }
        } else {
            die("You don't have permissions to delete a user!");
        }

        die("Unknown error!");
    }
