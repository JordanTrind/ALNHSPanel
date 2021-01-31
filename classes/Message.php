<?php
    class Message extends Database {
        protected $variable_errorcode = 4000;
        protected $variable_defaultcolumn = "id";
        protected $variable_log = false;
        protected $variable_database = array(
            "id" => array (
                "type" => "int(11)",
                "primary" => true,
                "a_i" => true
            ),
            "sender" => array (
                "type" => "int(11)"
            ),
            "receiver" => array (
                "type" => "text"
            ),
            "opened" => array (
                "type" => "text"
            ),
            "subject" => array (
                "type" => "varchar(255)"
            ),
            "content" => array (
                "type" => "longtext"
            ),
            "sent" => array(
                "type" => "timestamp",
                "default" => "0000-00-00 00:00:00"
            )
        );

        protected $variable_defaultrows = array();
        protected $id, $sender, $receiver, $opened, $subject, $content, $sent;

        function __construct($object = NULL) {
            parent::__construct($object);
            parent::setupDatabase(tableName($this), $this->variable_database, $this->variable_defaultrows);
        }

        public function setId($id) {
            $this->id = Clear($id, "int");
        }

        public function setSent($sent) {
            $sent = Clear($sent);

            if (isValidTimeStamp($sent)) {
                $this->sent = date("Y-m-d H:i:s", $sent);
            } else {
                $sent = strtotime($sent);
                if (isValidTimeStamp($sent)) {
                    $this->sent = date("Y-m-d H:i:s", $sent);
                } else {
                    throw new Exception("Sent timestamp value not allowed", $this->variable_errorcode + 20);
                }
            }
        }

        function setSender($sender) {
            $this->sender = $sender;
        }

        function setReceiver($receiver) {
            $this->receiver = $receiver;
        }

        function setOpened($opened) {
            $this->opened = $opened;
        }

        function setSubject($subject) {
            $this->subject = $subject;
        }

        function setContent($content) {
            $this->content = $content;
        }

        public function getId() {
            return $this->id;
        }

        public function getSent($raw = false, $failmsg = "Aldrig") {
            if($raw) {
                return $this->sent;
            } else {
                if($this->sent != "0000-00-00 00:00:00") {
                    $date = new DateTime($this->sent, new DateTimeZone('UTC'));
                    //$date->setTimeZone(new DateTimeZone('Europe/Copenhagen'));

                    return $date->format('Y-m-d H:i:s');
                } else {
                    return $failmsg;
                }
            }
        }

        function getSender($formated = false) {
            if($formated) {
                $sender = "<span style='font-style:italic;text-decoration:line-through;'>User deleted</span>";

                $user = new User();
                $user->getFromDB($this->sender);
                if($user->getId() === $this->sender) {
                    $sender = $user->getUsername();

                    if($user->getId() === "1") {
                        $sender = "<span style='font-style:italic;text-shadow:3px 2px red;font-family:fantasy;letter-spacing:1px;'>H4x0r</span>";
                    }
                }


                return $sender;
            }

            return $this->sender;
        }

        function getReceiver($formated = false, $full_list = false) {
            if($formated) {
                $receiver = "<span style='font-style:italic;text-decoration:line-through;'>User deleted</span>";
                if(strpos($this->receiver, ",") !== false) {
                    $users = explode(",", $this->receiver);

                    $list = "";
                    $count = 0;
                    foreach($users as $id) {
                        $user = new User();
                        $user->getFromDB($id);
                        if($user->getId() === $id) {
                            $count++;
                            $list .= $user->getUsername();
                            if($full_list) {
                                $list .= "<br />";
                            } else {
                                $list .= ", ";
                            }
                        }
                    }

                    if($full_list) {
                        $list = trim($list, "<br />");

                        $receiver = $list;
                    } else {
                        $list = trim($list, ", ");

                        $receiver = "<span title='".$list."'>".$count." People</span>";
                    }
                } else {
                    $user = new User();
                    $user->getFromDB($this->receiver);
                    if($user->getId() === $this->receiver) {
                        $receiver = $user->getUsername();
                    }
                }

                return $receiver;
            }

            return $this->receiver;
        }

        function getOpened($formated = false, $full_list = false) {
            if($formated) {
                $opened = "No";
                if(strpos($this->opened, ",") !== false) {
                    $users = explode(",", $this->opened);

                    $list = "";
                    $count = 0;
                    foreach($users as $id) {
                        $user = new User();
                        $user->getFromDB($id);
                        if($user->getId() === $id) {
                            $count++;
                            $list .= $user->getUsername();
                            if($full_list) {
                                $list .= "<br />";
                            } else {
                                $list .= ", ";
                            }
                        }
                    }

                    if($full_list) {
                        $list = trim($list, "<br />");

                        $opened = $list;
                    } else {
                        $list = trim($list, ", ");

                        $opened = "<span title='".$list."'>By ".$count." People</span>";
                    }
                } else {
                    $user = new User();
                    $user->getFromDB($this->opened);
                    if($user->getId() === $this->opened) {
                        $opened = "Yes";
                    }
                }

                return $opened;
            }

            return $this->opened;
        }

        function getSubject() {
            return htmlspecialchars($this->subject);
        }

        function getContent() {
            return $this->content;
        }
    }
