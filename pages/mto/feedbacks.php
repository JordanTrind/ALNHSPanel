
<!-- Page Content -->
<div id="page-wrapper">
  <div class="row">
      <div class="col-lg-12">
          <h1 class="page-header">All MTO Feedbacks</h1>
      </div>
  </div>

  <div class="row">
  <div class="col-lg-12">
      <div class="panel panel-green">
          <div class="panel-heading">MTO Feedbacks</div>
              <div class="panel-body">
                  <div class="table-responsive">
                      <table class="table table-hover">
                          <thead>
                              <tr>
                                <th>Timestamp</th>
                                <th>MTO</th>
                                <th>Medic</th>
                                <th>Type</th>
                                <th>Feedback</th>
                              </tr>
                          </thead>
                          <tbody>
                            <?php
                                $feedbacks = new Feedback();
                                $result = $feedbacks->getFromDB(NULL, NULL, "result", false, false, "timestamp", true);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_object()) {
                                        $feedback = new Feedback($row);

                                        if($feedback->getFeedbacktype() == "Positive") {
                                            $class = " class='success'";
                                        } elseif($feedback->getFeedbacktype() == "Neutral") {
                                            $class = " class='warning'";
                                        } elseif($feedback->getFeedbacktype() == "Negative") {
                                            $class = " class='danger'";
                                        }

                                        echo "<tr>";
                                            echo "<td>".substr($feedback->getTimestamp(),0,-8)."</td>";
                                            echo "<td>".$feedback->getMTO()."</td>";
                                            echo "<td>".$feedback->getMedic()."</td>";
                                            echo "<td".$class.">".$feedback->getFeedbacktype()."</td>";
                                            echo "<td>".$feedback->getFeedback()."</td>";
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
