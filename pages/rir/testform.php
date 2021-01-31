<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("rir")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <iframe class="embed-sheat noheader" src="https://docs.google.com/forms/d/e/1FAIpQLSc7rVY9NXgb38iYYpqQm9kS0LgLsJP8me2YcFSdZ7DVRXPn5w/viewform?embedded=true"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
