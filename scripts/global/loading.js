$(function() {
    window.loading = false;
    
    $("body").append('<div id="fullpageloading"><div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div><a href="#" onclick="location.reload();return false;" style="display: none;">Nothing happening? Click here</a></div>');
});

function isLoading() {
    return window.loading;
}

function EnableLoading(waitabit) {
    window.loading = true;
    
    if(waitabit) {
        setTimeout(function() {
            if(isLoading()) {
                EnableLoading(false);
            }
        }, 500);
    } else {
        $("#fullpageloading").fadeIn();
        window.clearTimeout(window.loadingtimer);
        window.loadingtimer = setTimeout(function() {
            if(isLoading()) {
                $("#fullpageloading a").fadeIn().css("display", "");
            }
        }, 150000);
    }
}

function DisableLoading() {
    window.clearTimeout(window.loadingtimer);
    window.loading = false;
    $("#fullpageloading").fadeOut(function() {
        $("#fullpageloading a").css("display", "none");
    });
}

function ToggleLoading() {
    if(isLoading()) {
        DisableLoading();
    } else {
        EnableLoading();
    }
}

function EnablePartLoader(selector, instant) {
    selector.append('<div id="loadingdiv"><div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>');

    if(instant) {
        selector.find("#loadingdiv").css("height", selector.css("height")).show();
    } else {
        selector.find("#loadingdiv").fadeIn();
    }
}

function DisablePartLoader(selector, instant) {
    if(instant) {
        selector.find("#loadingdiv").remove();
    } else {
        selector.find("#loadingdiv").fadeOut(function() {
            $(this).remove();
        });
    }
    
}