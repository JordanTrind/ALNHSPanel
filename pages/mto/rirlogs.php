
<!-- Page Content -->
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">All RIR Timesheets</h1>
      </div>
  </div>

  <div class="row">
  <div class="col-lg-12">
      <div class="panel panel-info">
          <div class="panel-heading">RIR Timesheets</div>
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
                          <tbody>
                            <?php
                                $rirs = new RIR();
                                $result = $rirs->getFromDB(NULL, NULL, "result", false, false, "timestamp", true);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_object()) {
                                        $rir = new RIR($row);

                                        echo "<tr>";
                                            echo "<td>".substr($rir->getTimestamp(),0,-8)."</td>";
                                            echo "<td>".$rir->getDriver()."</td>";
                                            echo "<td>".$rir->getVehicle()."</td>";
                                            echo "<td>".$rir->getStarttime()."</td>";
                                            echo "<td>".$rir->getEndtime()."</td>";
                                            echo "<td>".$rir->getDuration()."</td>";
                                            echo "<td>".$rir->getPassenger1()."</td>";
                                            echo "<td>".$rir->getPassenger2()."</td>";
                                            echo "<td>".$rir->getPassenger3()."</td>";
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
