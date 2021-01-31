<?php
    ini_set('display_errors', 1);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    header('Content-Type: text/html; charset=utf-8');
    session_start();
    date_default_timezone_set('UTC');

    $globa_debug = false;

    define('APPLICATION_PATH', 'C:/xampp/htdocs/NHS Panel');

    $paths = array(APPLICATION_PATH . '/classes');
    set_include_path(implode(PATH_SEPARATOR, $paths));

    require_once "global/functions.php";

    function AutoLoader($class) {
        require_once($class.'.php');
    }
    spl_autoload_register('AutoLoader');

    define("HOST", '/');

    $str = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), "/");
    $temp = explode("/", $str);
    unset($temp[0]);
    $parts = array_values($temp);

    if ($parts[0] != "") {
        $page = urldecode(htmlspecialchars($parts[0]));
    } else {
        $page = "dashboard";
    }

    $under = array();
    if (isset($parts[2]) && $parts[2] != "") {
        foreach ($parts as $key => $underpage) {
            if ($key != 0) {
                $under[] = urldecode(htmlspecialchars($underpage));
            }
        }
    }
    else if (isset($parts[1]) && $parts[1] != "") {
        foreach ($parts as $key => $underpage) {
            if ($key != 0) {
                $under[] = urldecode(htmlspecialchars($underpage));
            }
        }
    }



    $me = new User();
    if (isset($_SESSION['uid'])) {
        $uservalid = true;
        if (!$me->getFromDB($_SESSION['uid'])) {
            $uservalid = false;
        }

        if(!$uservalid) {
            $me->logout();
            header('Location: ' . $_SERVER['REQUEST_URI']);

            die();
        }
    }

    $globals = glob('pages/'.$page.'/functions/*.php', GLOB_BRACE);
    foreach ($globals as $file) {
        require_once $file;
    }

    $globals = glob('pages/'.$page.'/postandget/*.php', GLOB_BRACE);
    foreach ($globals as $file) {
        require_once $file;
    }

    $globals = glob('global/*.php', GLOB_BRACE);
    foreach ($globals as $file) {
        require_once $file;
    }

    foreach($mainmenu as $name => $data) {
        if(isset($data["data"])) {
            foreach($data["data"] as $undername => $underdata) {
                if($page === trim($underdata["href"], "/")) {
                    $pagetitle = $undername;
                    break 2;
                }
            }
        }
    }

    if(empty($pagetitle)) {
        $pagetitle = ucfirst(strtolower(str_replace("_", " ", $page)));
        if (empty($pagetitle)) {
            $pagetitle = "Dashboard";
        }
    }

    updateLastactive();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="google" content="notranslate" />
        <meta http-equiv="Content-Language" content="en_US" />

        <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">

        <title>Academy Panel - <?=$pagetitle?></title>


        <link href="./vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"><!-- Bootstrap Core CSS -->
        <link href="./vendor/metisMenu/metisMenu.min.css" rel="stylesheet"><!-- MetisMenu CSS -->
        <link href="./vendor/morrisjs/morris.css" rel="stylesheet"><!-- Morris Charts CSS -->
        <link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- Custom Fonts -->

        <script src="./vendor/jquery/jquery.min.js"></script><!-- jQuery -->
        <script src="./vendor/bootstrap/js/bootstrap.min.js"></script><!-- Bootstrap Core JavaScript -->
        <script src="./vendor/metisMenu/metisMenu.min.js"></script><!-- Metis Menu Plugin JavaScript -->

        <?php
            $disabledcaching = false;

            $styles = glob('vendor/css/*.css', GLOB_BRACE);
            foreach ($styles as $file) {
                echo "<link href='./".$file.($disabledcaching ? "?".time() : "")."' rel='stylesheet'>\n";
            }
            $styles = array(); // Manually add css files here

            foreach ($styles as $file) {
                if (substr($file, 0, 7) == "http://" || substr($file, 0, 8) == "https://") {
                    echo "<link href='".$file."' rel='stylesheet'>\n";
                } else {
                    echo "<link href='./".$file."' rel='stylesheet'>\n";
                }
            }

            $styles = glob('css/global/*.css', GLOB_BRACE);
            foreach ($styles as $file) {
                echo "<link href='./".$file.($disabledcaching ? "?".time() : "")."' rel='stylesheet'>\n";
            }

            $styles = glob('css/'.$page.'/*.css', GLOB_BRACE);
            foreach ($styles as $file) {
                echo "<link href='./".$file.($disabledcaching ? "?".time() : "")."' rel='stylesheet'>\n";
            }

            if (file_exists("css/".$page.".css")) {
                echo "<link href='./css/".$page.".css".($disabledcaching ? "?".time() : "")."' rel='stylesheet'>\n";
            }

            $scripts = glob('vendor/scripts/*.js', GLOB_BRACE);
            foreach ($scripts as $file) {
                echo "<script src='./".$file.($disabledcaching ? "?".time() : "")."'></script>\n";
            }

            $scripts = array(
                "https://www.google.com/recaptcha/api.js"
            ); // Manually add js files here

            foreach ($scripts as $file) {
                if (substr($file, 0, 7) == "http://" || substr($file, 0, 8) == "https://") {
                    echo "<script src='".$file."'></script>\n";
                } else {
                    echo "<script src='./".$file."'></script>\n";
                }
            }

            $scripts = glob('scripts/global/*.js', GLOB_BRACE);
            foreach ($scripts as $file) {
                echo "<script src='./".$file.($disabledcaching ? "?".time() : "")."'></script>\n";
            }

            $scripts = glob('scripts/'.$page.'/*.js', GLOB_BRACE);
            foreach ($scripts as $file) {
                echo "<script src='./".$file.($disabledcaching ? "?".time() : "")."'></script>\n";
            }

            if (file_exists("scripts/".$page.".js")) {
                echo "<script src='./scripts/".$page.".js".($disabledcaching ? "?".time() : "")."'></script>\n";
            }
        ?>
    </head>

    <body>
        <?php
            if($me->IsLoggedIn()) {
                if($me->MustChangePassword()) {
                    require "pages/mustchangepassword.php";
                } else {
                    ?>
                    <div id="wrapper">
                        <!-- Navigation -->
                        <nav class="navbar navbar-theme-<?=$me->getUserTheme()?> navbar-static-top" role="navigation" style="margin-bottom: 0;height: 50px;" id="topMenuBar">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="/"><b>Altis NHS - Staff Panel</b></a>
                            </div>

                            <ul class="nav navbar-top-links navbar-right">
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                        <b>
                                        <?php
                                        $playerdata = new Playerdata();
                                        $playerdata->getFromDB('"'.$me->getSteamid().'"');

                                        if($me->hasPermission("smto") && !$me->hasPermission("*")) {
                                          echo $playerdata->getRank().". ".$me->getUsername()." [SMTO]";
                                        } elseif ($me->hasPermission("mto") && !$me->hasPermission("*")) {
                                          echo $playerdata->getRank().". ".$me->getUsername()." [MTO]";
                                        } elseif (($me->hasPermission("app_team") || $me->hasPermission("seniorappteam")) && !$me->hasPermission("*")) {
                                          echo $playerdata->getRank().". ".$me->getUsername()." [AT]";
                                        } elseif ($me->hasPermission("*") && $playerdata->getRank() == "CMO") {
                                          echo $playerdata->getRank().". ".$me->getUsername()." (Admin)";
                                        } elseif ($me->hasPermission("*") && !$playerdata->getRank() == "CMO") {
                                          echo $me->getUsername()." (Admin)";
                                        } else {
                                          echo $playerdata->getRank().". ".$me->getUsername();
                                        }
                                        ?>
                                      </b><i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user">
                                        <li>
                                            <a href="/profile/"><i class="fa fa-cog fa-fw"></i> My Profile</a>
                                            <a href="/messages/"><i class="fa fa-commenting fa-fw"></i> Messages</a>
                                            <a href="/logout/"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <div class="navbar-theme-<?=$me->getUserTheme()?> sidebar" role="navigation" id="sideMenuBar">
                                <div class="sidebar-nav navbar-collapse">
                                    <ul class="nav" id="side-menu">
                                        <li>
                                            <a href="/"><i class="fa fa-dashboard fa-fw"></i> <span class="awhite">Dashboard</span></a>
                                        </li>
                                        <?php
                                            foreach($mainmenu as $name => $data) {
                                                echo '<li>';
                                                    $hasperm = false;
                                                    if(empty($data["permission"])) {
                                                        $hasperm = true;
                                                    } else {
                                                        foreach(explode(",", $data["permission"]) as $perm) {
                                                            if($me->hasPermission($perm)) {
                                                                $hasperm = true;

                                                                break;
                                                            }
                                                        }
                                                    }

                                                    if($hasperm) {
                                                        if(isset($data["data"])) {
                                                            echo '<a href="#"><i class="fa '.$data["icon"].' fa-fw"></i> '.$name.'<span class="fa arrow"></span></a>';
                                                            echo '<ul class="nav nav-second-level">';
                                                                foreach($data["data"] as $undername => $underdata) {
                                                                    $hasperm2 = false;
                                                                    if(empty($underdata["permission"])) {
                                                                        $hasperm2 = true;
                                                                    } else {
                                                                        foreach(explode(",", $underdata["permission"]) as $perm) {
                                                                            if($me->hasPermission($perm)) {
                                                                                $hasperm2 = true;

                                                                                break;
                                                                            }
                                                                        }
                                                                    }

                                                                    if($hasperm2) {
                                                                        if($undername === "BREAK" || $undername === "BREAK2" || $undername === "BREAK3") {
                                                                            echo "<br />";
                                                                        } else {
                                                                            if (substr($underdata["href"], 0, 7) === "http://" || substr($underdata["href"], 0, 8) === "https://") {
                                                                                echo '<li><a href="'.$underdata["href"].'" target="_blank"><i class="fa '.$underdata["icon"].' fa-fw"></i> '.$undername.'<span class="fa fa-external-link" style="float: right;"></span></a></li>';
                                                                            } else {
                                                                                echo '<li><a href="'.$underdata["href"].'"><i class="fa '.$underdata["icon"].' fa-fw"></i> '.$undername.'</a></li>';
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            echo '</ul>';
                                                        } else {
                                                            if($name === "BREAK" || $name === "BREAK2" || $name === "BREAK3") {
                                                                echo "<br />";
                                                            } else {
                                                                if (substr($data["href"], 0, 7) === "http://" || substr($data["href"], 0, 8) === "https://") {
                                                                    echo '<a href="'.$data["href"].'" target="_blank"><i class="fa '.$data["icon"].' fa-fw"></i> '.$name.'<span class="fa fa-external-link" style="float: right;"></span></a>';
                                                                } else {
                                                                    echo '<a href="'.$data["href"].'"><i class="fa '.$data["icon"].' fa-fw"></i> '.$name.'</a>';
                                                                }
                                                                //echo '<a href="'.$data["href"].'"><i class="fa '.$data["icon"].' fa-fw"></i> '.$name.'</a>';
                                                            }

                                                        }
                                                    }
                                                echo "</li>";
                                            }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </nav>

                        <?php
                        if($page === "profile") {
                            require_once "pages/users.php";
                        } else {
                            if (file_exists("pages/".$page."/".$under[0].".php")) {
                                require_once "pages/".$page."/".$under[0].".php";
                            } elseif (file_exists("pages/".$page."/content.php")) {
                                require_once "pages/".$page."/content.php";
                            } elseif (file_exists("pages/".$page.".php")) {
                                require_once "pages/".$page.".php";
                            } else {
                                require_once "pages/404.php";
                            }
                        }
                    echo "</div>";
                }
            } else {
                require "pages/login.php";
            }

            if($me->IsLoggedIn()) {
            ?>
                <script>
                    setInterval(function() {
                        $.post("#", {
                            keeponline: true
                        }).done(function(data) {
                            if(data === "true") {
                                location.reload();
                            }
                        });
                    }, 30000);
                </script>
            <?php
            }
        ?>
    </body>
</html>
