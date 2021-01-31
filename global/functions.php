<?php
    function updateLastactive() {
        global $me;

        if($me->IsLoggedIn()) {
            try {
                $me->setIp(getIP());
                $me->update();
            } catch (Exception $ex) {}

            try {
                $online = new Online();
                $online->getFromDB($me->getId());

                $offline = false;
                $doinsert = false;
                if ($online->getId()) {
                    if($online->getOnline(false) === 0) {
                        if($_SESSION['rememberme']) {
                            try {
                                $me->setLastlogin(time());
                                $me->update();
                            } catch (Exception $e) {}
                        } else {
                            $online->delete();

                            $offline = true;
                        }
                    }
                } else {
                    if($_SESSION['rememberme']) {
                        $online->setUid($me->getId());
                        $doinsert = true;
                    } else {
                        $offline = true;
                    }
                }

                if($offline) {
                    $me->logout('Logout - User timeout');

                    header('Location: '.$_SERVER['REQUEST_URI']);

                    die();
                } else {
                    $online->setLastactive(time());
                    $online->setKeeponline(time());

                    if($doinsert) {
                        $online->insert();
                    } else {
                        $online->update();
                    }
                }
            } catch (Exception $ex) { }
        }
    }

    function Clear($val, $type = "string", $allowed=false) {
        if ($type == "string") {
                return @trim($val);
        } elseif ($type == "float") {
                return filter_var($val, FILTER_VALIDATE_FLOAT);
        } elseif ($type == "int") {
                return (int) $val;
        } elseif ($type == "bool") {
                return (bool) $val;
        } elseif ($type == "message") {
                return htmlentities(trim($val));
        } else {
                return $val;
        }
    }

    function Encrypt($password) {
        for ($i = 0; $i < 1000; $i++) {
            $password = md5($password);
        }

        for ($i = 0; $i < 100; $i++) {
            for ($i1 = 0; $i1 < 10; $i1++) {
                $password = base64_encode($password);
            }

            for ($i2 = 0; $i2 < 10; $i2++) {
                $password = hash("sha512", $password);
            }

            for ($i3 = 0; $i3 < 10; $i3++) {
                $password = sha1($password);
            }
        }

        for ($i = 0; $i < 1000; $i++) {
            $password = md5($password);
        }

        return $password;
    }

    function Msg($msg, $errorcode=false) {
	echo $msg;

	if($errorcode != false) {
	    die(" - Error code: ".$errorcode);
	} else {
	    echo "<br />";
	}
    }

    function str_lreplace($search, $replace, $subject) {
        $pos = strrpos($subject, $search);

        if($pos !== false)
        {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

    function DiffHours($interval) {
        if($interval) {
            $years = $interval->format('%y');
            $months = $interval->format('%m');
            $days = $interval->format('%d');
            $hours = $interval->format('%h');

            $hours += (24 * ($days + (30 * ($months + (12 * $years)))));

            return $hours;
        }

        return 0;
    }

    function DiffString($interval, $fallback="None", $skipseconds=false) {
        if($interval) {
            $years = $interval->format('%y');
            $months = $interval->format('%m');
            $days = $interval->format('%d');
            $hours = $interval->format('%h');
            $minutes = $interval->format('%i');
            $seconds = $interval->format('%s');

            $hours += (24 * ($days + (30 * ($months + (12 * $years)))));

            $diffstring = "";
            if($hours > 0) {
                $diffstring .= $hours;

                if($hours > 1) {
                    $diffstring .= " hours, ";
                } else {
                    $diffstring .= " hour, ";
                }
            }
            if($minutes > 0) {
                $diffstring .= $minutes;

                if($minutes > 1) {
                    $diffstring .= " minutes, ";
                } else {
                    $diffstring .= " minute, ";
                }
            }
            if(!$skipseconds) {
                if($seconds > 0) {
                    $diffstring .= $seconds;

                    if($seconds > 1) {
                        $diffstring .= " seconds, ";
                    } else {
                        $diffstring .= " second, ";
                    }
                }
            }

            if($diffstring != "") {
                return str_lreplace(", ", " and ", substr($diffstring, 0, -2));
            }
        }

        return $fallback;
    }

    function tableName($table) {
        if (is_object($table)) {
            $table = strtolower(get_class($table));
        }

        return $table;
    }

    function httpRequest($url, $data, $type='POST', $json=false) {
        if($json) {
            $header = "Content-type: application/json\r\n";
            $content = json_encode($data);
        } else {
            $header = "Content-type: application/x-www-form-urlencoded\r\n";
            $content = http_build_query($data);
        }

        $context  = stream_context_create(array(
            'http' => array(
                'header'  => $header,
                'method'  => $type,
                'content' => $content,
            ),
        ));

        return file_get_contents($url, false, $context);
    }

    function isValidTimeStamp($timestamp) {
        return (is_numeric($timestamp) && (int)$timestamp == $timestamp) && ($timestamp <= PHP_INT_MAX) && ($timestamp >= ~PHP_INT_MAX);
    }

    function getIP() {
        global $_SERVER;

        $ways_to_get_ip = array(
                "HTTP_CLIENT_IP",
                "HTTP_X_FORWARDED_FOR",
                "HTTP_X_FORWARDED",
                "HTTP_FORWARDED_FOR",
                "HTTP_FORWARDED",
                "REMOTE_ADDR"
        );

        $ip = "";
        if(function_exists('apache_request_headers')) {
                $headers = apache_request_headers();

                foreach($ways_to_get_ip as $val) {
                if(filter_var($headers[$val], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                        $ip = filter_var($headers[$val], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
                }
                }
        }

        if($ip == "") {
                $headers = $_SERVER;

                $ip = "";
                foreach($ways_to_get_ip as $val) {
                if(filter_var($headers[$val], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                        $ip = filter_var($headers[$val], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
                }
                }

                if($ip == "") {
                $ip = '0.0.0.0';
                }
        }

        return $ip;
    }

    function getLang() {
        $langs = array();

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

            if (count($lang_parse[1])) {
                $langs = array_combine($lang_parse[1], $lang_parse[4]);

                foreach ($langs as $lang => $val) {
                    if ($val === '') {
                        $langs[$lang] = 1;
                    }
                }

                arsort($langs, SORT_NUMERIC);
            }
        }

        foreach ($langs as $lang => $val) {
            break;
        }

        if (stristr($lang, "-")) {
            $tmp = explode("-", $lang);
            $lang = $tmp[0];
        }

        return $lang;
    }
