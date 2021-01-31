
<!-- Page Content -->
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">All MTO Timesheets</h1>
      </div>
  </div>

  <div class="row">
  <div class="col-lg-12">
      <div class="panel panel-red">
          <div class="panel-heading">MTO Timesheets</div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-hover">
                          <thead>
                              <tr>
                                  <th>Timestamp</th>
                                  <th>MTO</th>
                                  <th>Start</th>
                                  <th>End</th>
                                  <th>Duration</th>
                                  <th>Trainees</th>
                                  <th>Notes</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php
                                $timesheets = new Timesheet();
                                $result = $timesheets->getFromDB(NULL, NULL, "result", false, false, "timestamp", true);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_object()) {
                                        $timesheet = new Timesheet($row);

                                        echo "<tr>";
                                            echo "<td>".substr($timesheet->getTimestamp(),0,-8)."</td>";
                                            echo "<td>".$timesheet->getMTO()."</td>";
                                            echo "<td>".$timesheet->getStarttime()."</td>";
                                            echo "<td>".$timesheet->getEndtime()."</td>";
                                            echo "<td>".$timesheet->getDuration()."</td>";
                                            echo "<td>".$timesheet->getTrainees()."</td>";
                                            echo "<td>".$timesheet->getMTONotes()."</td>";
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
