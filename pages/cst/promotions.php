<?php
if(!$me->hasPermission("consultants")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Active Medics</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <input type="checkbox" id="do_all" /> Show all
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="panel panel-default" style='background-color: #efefef;'>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Name</th>
                                <th>Rank</th>
                                <th>Steam ID</th>
                                <th>Join Date</th>
                                <th>Last Promo</th>
                                <th>Last Login</th>
                                <!--<th>Total Time</th>-->
                                <th>30 Days</th>
                                <th>7 Days</th>
                            </tr>
                        </thead>
                        <tbody id="cst_promo_data">
                            <?php
                                show_cst_promo();
                            ?>
                        </tbody>
                    </table>

                    <p style="text-align:center;display: none;" id="cst_promo_status">No results found!</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#do_all").on("change", function(){
        $("#cst_promo_data").hide();
        $("#cst_promo_status").text("Loading...").show();

        $.post("#", {
            cst_promo: $("#do_all").is(":checked")
        }).done(function(data) {
            if(data === "") {
                $("#cst_promo_data").hide();
                $("#cst_promo_status").text("No results found!").show();
            } else {
                $("#cst_promo_data").html(data).show();
                $("#cst_promo_status").hide();
            }
        }).fail(function() {
            $("#cst_promo_data").hide();
            $("#cst_promo_status").text("Failed to connect to the server!").show();
        });
    });
</script>
