<?php
if(!$me->hasPermission("mto") && !$me->hasPermission("smto") && !$me->hasPermission("consultants")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row" style="height: 100px">
            <div class="col-lg-12">
                <h1 class="page-header">MTO Handbook</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <iframe class="embed-sheat noheader" src="https://docs.google.com/document/d/14_LQFaR7Mh6EqS6eYZs_bCpKlhrAtNNWny_fZq6LLfQ/?rm=demo"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
