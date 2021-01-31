<?php
if(!$me->hasPermission("interviews") && !$me->hasPermission("smto") && !$me->hasPermission("consultants")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper" class="fullwidth">
    <div class="container-fluid">
        <!-- /.row -->

        <iframe class="embed-sheat noheader" src="https://docs.google.com/spreadsheets/d/1HO60dHFi7Wu5n0pD4eDg1G_K9407L88AVs1QQpqg1J4/?rm=demo"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
