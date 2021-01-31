<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("seniorappteam") && !$me->hasPermission("app_team")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row" style="height: 100px">
            <div class="col-lg-12">
                <h1 class="page-header">App Team Handbook</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <iframe class="embed-sheat noheader" src="https://docs.google.com/document/d/1W4CSlmWcRs8bVYQzQTTbbj_74RC5uYkjzFHaN-7r96M/?rm=demo"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
