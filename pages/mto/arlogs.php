
<!-- Page Content -->
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">All AR Timesheets</h1>
      </div>
  </div>

  <div class="row">
  <div class="col-lg-12">
      <div class="panel panel-danger">
          <div class="panel-heading">AR Timesheets</div>
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
                          <tbody>
                            <?php
                                $ars = new AR();
                                $result = $ars->getFromDB(NULL, NULL, "result", false, false, "timestamp", true);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_object()) {
                                        $ar = new AR($row);

                                        if($ar->getCrashed() == "No") {
                                            $crashedclass = " class='success'";
                                        } elseif($ar->getCrashed() == "Yes") {
                                            $crashedclass = " class='danger'";
                                        }
                                        
                                        echo "<tr>";
                                            echo "<td>".substr($ar->getTimestamp(),0,-8)."</td>";
                                            echo "<td>".$ar->getPilot()."</td>";
                                            echo "<td>".$ar->getVehicle()."</td>";
                                            echo "<td>".$ar->getStarttime()."</td>";
                                            echo "<td>".$ar->getEndtime()."</td>";
                                            echo "<td>".$ar->getDuration()."</td>";
                                            echo "<td>".$ar->getPassenger1()."</td>";
                                            echo "<td>".$ar->getPassenger2()."</td>";
                                            echo "<td>".$ar->getPassenger3()."</td>";
                                            echo "<td".$crashedclass.">".$ar->getCrashed()."</td>";
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
  </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
