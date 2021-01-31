captchaform = false;
recaptcharesponse = "";

$(function() {
    $("input[name='login']").click(function(e) {
        e.preventDefault();

        var button = $(this);

        button.prop("disabled", true);
        EnableLoading(500);

        $.post("#",{
            login: true,
            username: $("input[name='username']").val(),
            password: $("input[name='password']").val(),
            captcha: recaptcharesponse
        }).done(function(data) {
            if(data === "true") {
                location.reload();
            } else {
                DisableLoading();

                if(data === "false1") {
                    Alert("Login failed!", "Please do this captcha before signing in.");

                    captchaform = grecaptcha.render('recaptcha', {
                        'sitekey' : '6LfLmT8UAAAAAOP1M9MM2hm6D5ym-TcMtH_8n6gt',
                        'callback' : function(response) {
                            if(response.length !== 0) {
                                recaptcharesponse = response;
                                $("input[name='login']").prop("disabled", false);
                            }
                        },
                        'theme' : 'light'
                    });
                } else {
                    Alert("Login failed!", data);

                    if(captchaform !== false) {
                        grecaptcha.reset(captchaform);
                    } else {
                        button.prop("disabled", false);
                    }
                }
            }
        }).fail(function() {
            DisableLoading();

            Alert("Something went wrong!", "Failed to connect to the server!");

            button.prop("disabled", false);

            if(captchaform !== false) {
                grecaptcha.reset(captchaform);
            }
        });
    });

    var changepasswordform = $("form[name='changepasswordform']");

    $("input[name='changepassword']").click(function(e) {
        e.preventDefault();

        changepasswordform.find("input[name='hiddensubmit']").click();
    });

    changepasswordform.on('submit', function (e) {
        e.preventDefault();

        if(changepasswordform[0].checkValidity()) {
            e.preventDefault();

            var button = $(this);

            button.prop("disabled", true);
            EnableLoading(500);

            $.post("#", {
                updateuser: "me",
                password: $("input[name='password']").val(),
                mustchangereset: true
            }).done(function(data) {
                DisableLoading();

                if(data === "true4") {
                    $("input[name='password']").val("");
                    Alert("Saved successfully!", "Password has been changed.", "green", function() {
                        location.reload();
                    });
                } else {
                    Alert("Save failed!", data);
                }

                button.prop("disabled", false);
            }).fail(function() {
                DisableLoading();

                Alert("Something went wrong!", "Failed to connect to the server!");

                button.prop("disabled", false);
            });
        }
    });
});
