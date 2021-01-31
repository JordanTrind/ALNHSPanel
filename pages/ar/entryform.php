<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("ar")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <iframe class="embed-sheat noheader" src="https://docs.google.com/forms/d/e/1FAIpQLSdjv_efgD5MqBfJOe-YQ5SHHYpTQ8Bmi4ylGKiUKzmTR0MGAg/viewform?embedded=true"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
