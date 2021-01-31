<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("rir")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row" style="height: 100px">
            <div class="col-lg-12">
                <h1 class="page-header">RIR Folder</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <iframe class="embed-sheat noheader" src="https://drive.google.com/embeddedfolderview?id=0B4yZzDcGUcdCLW9UZlJZR0NtcGM"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
