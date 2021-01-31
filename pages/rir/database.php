<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("rir")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper" class="fullwidth">
    <div class="container-fluid">
        <!-- /.row -->

        <iframe class="embed-sheat noheader" src="https://docs.google.com/spreadsheets/d/1HMqijm9UO3IShi0Suykfuc_Rh5UYFSWKIjBumIoam_E/?rm=demo"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
