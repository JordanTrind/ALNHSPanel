function updateCheckbox() {
    var allcheckbox = $("input[name='perm_all']");

    if(allcheckbox.is(":checked")) {
        $(".perm_checkbox").prop("disabled", true);
        $(".perm_checkbox").prop('checked', true);
    } else {
        $(".perm_checkbox").prop("disabled", false);
        $(".perm_checkbox").prop('checked', false);
    }

    allcheckbox.prop("disabled", false);
}

$(function() {
    if(!$("input[name='perm_all']").is(":disabled") && $("input[name='perm_all']").is(":checked")) {
        updateCheckbox();
    }

    $("input[name='perm_all']").on("change", function() {
        updateCheckbox();
    });


    var userform = $("form[name='userform']");

    $("input[name='updateuser']").on("click", function(e) {

        e.preventDefault();

        userform.find("input[name='hiddensubmit']").click();
    });

    userform.on('submit', function (e) {
        e.preventDefault();

        if(userform[0].checkValidity()) {
            $("input[name='updateuser'], input[name='deleteuser']").prop("disabled", true);
            EnableLoading(500);

            var data = {
                updateuser: $("input[name='id']").val(),
                username: $("input[name='username']").val(),
                email: $("input[name='email']").val(),
                usertheme: $("select[name='usertheme']").val(),
                steamid: $("input[name='steamid']").val(),
                password: $("input[name='password']").val(),
                mustchangepassword: $("input[name='mustchangepassword']").is(":checked"),
                disabled: $("input[name='disabled']").is(":checked")
            };

            $(".perm_checkbox").each(function() {
                var name = $(this).attr("name");

                if(name.substring(0, 5) === "perm_") {
                    data[name] = $(this).is(":checked");
                }
            });

            $.post("#", data).done(function(data) {
                DisableLoading();

                if(data === "true") {
                    Alert("Saved successfully!", "The user has been created!", "green", function() {
                        location.href = '/users/';
                    });
                } else if(data === "true2") {
                    Alert("Saved successfully!", "The user data has been saved.", "green");
                    location.reload();
                } else if(data === "true3") {
                    Alert("Saved successfully!", "The user data has been saved and the password has been changed.", "green");
                    location.reload();

                    $("input[name='password']").val("");
                } else if(data === "true4") {
                    $("input[name='password']").val("");
                    Alert("Saved successfully!", "Your settings have been updated!", "green", function() {
                        location.reload();
                    });
                } else {
                    Alert("Save failed!", data);
                }

                $("input[name='updateuser'], input[name='deleteuser']").prop("disabled", false);
            }).fail(function() {
                DisableLoading();

                Alert("Something went wrong!", "Failed to connect to the server!");

                $("input[name='updateuser'], input[name='deleteuser']").prop("disabled", false);
            });
        }
    });

    $("input[name='deleteuser']").on("click", function(e) {
        e.preventDefault();

        $("input[name='updateuser'], input[name='deleteuser']").prop("disabled", true);

        $.confirm({
            title: "Delete user?",
            content: "Are you sure you want to delete this user?",
            type: "red",
            typeAnimated: true,
            escapeKey: false,
            backgroundDismiss: false,
            theme: 'modern',
            onClose: function() {
                $("input[name='updateuser'], input[name='deleteuser']").prop("disabled", false);
            },
            buttons: {
                cancel: {
                    text: 'No, cancel',
                    btnClass: 'btn-default'
                },
                confirm: {
                    text: 'Yes, delete',
                    btnClass: 'btn-default',
                    action: function () {
                        EnableLoading(500);

                        $.post("#", {
                            deleteuser: $("input[name='id']").val()
                        }).done(function(data) {
                            DisableLoading();

                            if(data === "true") {
                                Alert("Deleted successfully!", "The user has been deleted!", "green", function() {
                                    location.href = '/users/';
                                });
                            } else {
                                DisableLoading();

                                Alert("Delete failed!", data);

                                $("input[name='updateuser'], input[name='deleteuser']").prop("disabled", false);
                            }
                        }).fail(function() {
                            DisableLoading();

                            Alert("Something went wrong!", "Failed to connect to the server!");

                            $("input[name='updateuser'], input[name='deleteuser']").prop("disabled", false);
                        });
                    }
                }
            }
        });
    });
});
