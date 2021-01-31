<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("seniorappteam") && !$me->hasPermission("app_team")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper" class="fullwidth">
    <div class="container-fluid">
        <!-- /.row -->

        <iframe class="embed-sheat noheader" src="https://docs.google.com/spreadsheets/d/191TbmMomyoD_EmN2HaiA2GQYSMNaMnK5znSu_LiDr8c/?rm=demo"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
