<?php
    if(isset($_POST["search_application_db"])) {


        if($_POST["app_do_all"] === "true") {
          $medics = new medic();
          $sql = "SELECT * FROM medic";

          $value = $medics->DBClear(trim($_POST["search_application_db"]));

          if($value !== "") {
              $sql .= " WHERE name LIKE '%".$value."%' OR steamid LIKE '%".$value."%' OR forumid LIKE '%".$value."%'";
          }

          $sql .= " ORDER BY timestamp DESC";

          $result = $medics->runSQL($sql, "result");

          if($result->num_rows > 0) {
              while($row = $result->fetch_object()) {
                  $medic = new medic($row);

                  echo "<tr>";
                      echo "<td>".$medic->getTimestamp()."</td>";
                      echo "<td>".$medic->getName()."</td>";
                      echo "<td>".$medic->getSteamid()."</td>";
                      echo "<td>".$medic->getAppInfo()."</td>";
                  echo "</tr>";
              }
          } else {
              echo "false";
          }


          die();
        }

        $apps = new App();
        $sql = "SELECT * FROM app";

        $value = $apps->DBClear(trim($_POST["search_application_db"]));

        if($value !== "") {
            $sql .= " WHERE name LIKE '%".$value."%' OR age LIKE '%".$value."%' OR steamid LIKE '%".$value."%' OR application LIKE '%".$value."%'";
        }

        $sql .= " ORDER BY timestamp DESC";

        $result = $apps->runSQL($sql, "result");

        if($result->num_rows > 0) {
            while($row = $result->fetch_object()) {
                $app = new App($row);

                $application = $app->getApplication();

                if (strlen($application) > 78) {
                    $application = substr($application, 0, 78) . '...';
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
        } else {
            echo "false";
        }


        die();
    }
