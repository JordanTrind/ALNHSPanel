<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("ar")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row" style="height: 100px">
            <div class="col-lg-12">
                <h1 class="page-header">Air Resuce Taru Test</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <iframe class="embed-sheat noheader" src="https://docs.google.com/document/d/1Ny8a9cUzBKo7cTp70IXz3JQ9nBpAWua4wNjj83XHbbc/?rm=demo"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
