<?php
    $mainmenu = array(
            "Command" => array(
                    "permission" => "command",
                    "icon" => "fa-suitcase",
                    "data" => array(
                            "CMO Database" => array(
                                    "name" => "CMO Database",
                                    "icon" => "fa-table",
                                    "href" => "/command/database/"
                            ),
                            "CMO Docs Folder" => array(
                                    "name" => "CMO Folder",
                                    "icon" => "fa-folder",
                                    "href" => "/command/folder/"
                            ),
                            "NHS Development" => array(
                                    "name" => "Dev Folder",
                                    "icon" => "fa-folder",
                                    "href" => "/command/development/"
                            ),
                            "Command Structure" => array(
                                    "name" => "Command Strucutre",
                                    "icon" => "fa-file-text",
                                    "href" => "/command/structure/"
                            ),
                            "Faction Activity" => array(
                                    "name" => "Faction Activity",
                                    "icon" => "fa-bar-chart-o",
                                    "href" => "/command/activity/"
                            )
                    )
            ),
            "Master DB" => array(
                    "permission" => "masterdb",
                    "icon" => "fa-key",
                    "href" => "https://docs.google.com/spreadsheets/d/16Jubl7U6A0IcuEVp_yi2BK_4bjWSFxsyUajs5zrnevY/edit"
            ),
            "NHS Archive" => array(
                    "name" => "Archive",
                    "permission" => "masterdb",
                    "icon" => "fa-folder-open",
                    "href" => "/archive/"
            ),
            "Medic Search" => array(
                    "name" => "Search",
                    "permission" => "consultants, smto, mto, seniorappteam, app_team, rir, interviews, ar",
                    "icon" => "fa-user",
                    "href" => "/search/"
            ),
            "Consultants" => array(
                    "permission" => "consultants",
                    "icon" => "fa-tasks",
                    "data" => array(
                            "CST Database" => array(
                                    "name" => "CST Database",
                                    "icon" => "fa-table",
                                    "href" => "/cst/database/"
                            ),
                            "Promotions" => array(
                                    "name" => "Promotions",
                                    "icon" => "fa-list-alt",
                                    "href" => "/cst/promotions/"
                            ),
                            "All Logins" => array(
                                    "name" => "All Logins",
                                    "icon" => "fa-clock-o",
                                    "href" => "/cst/logins/"
                            ),
                            "BREAK" => true,
                            "CST Handbook" => array(
                                    "name" => "CST Handbook",
                                    "icon" => "fa-file-text",
                                    "href" => "/cst/handbook/"
                            ),
                            "Activity Policy" => array(
                                    "name" => "Activity Policy",
                                    "icon" => "fa-file-text",
                                    "href" => "/cst/activity/"
                            ),
                            "CST Folder" => array(
                                    "name" => "CST Folder",
                                    "icon" => "fa-folder",
                                    "href" => "/cst/folder/"
                            )
                    )
            ),
            "HMTO/DMTO" => array(
                    "permission" => "mtolead",
                    "icon" => "fa-bullhorn",
                    "data" => array(
                            "HMTO/DMTO Database" => array(
                                    "name" => "HMTO Database",
                                    "icon" => "fa-table",
                                    "href" => "/hmto/database/"
                            ),
                            "MTO Leads Folder" => array(
                                    "name" => "HMTO Folder",
                                    "icon" => "fa-folder",
                                    "href" => "/hmto/folder/"
                            )
                    )
            ),
            "Interviews" => array(
                    "permission" => "consultants,smto,interviews",
                    "icon" => "fa-comments",
                    "data" => array(
                            "Interview Form" => array(
                                    "name" => "Interview Form",
                                    "icon" => "fa-list",
                                    "href" => "/interviews/form/"
                            ),
                            "Interview Database" => array(
                                    "name" => "Interview DB",
                                    "icon" => "fa-table",
                                    "href" => "/interviews/"
                            ),
                            "MTO Interview DB" => array(
                                    "name" => "MTO Interviews",
                                    "icon" => "fa-table",
                                    "href" => "/interviews/mto/"
                            ),
                            "Handbook Reading" => array(
                                    "icon" => "fa-microphone",
                                    "href" => "https://drive.google.com/file/d/1jVhZh9ECB55HqgzRwg1kOdMskNtksUAH/view"
                            )
                    )
            ),
            "SMTOs" => array(
                    "permission" => "consultants,smto",
                    "icon" => "fa-pencil-square",
                    "data" => array(
                            "SMTO Handbook" => array(
                                    "name" => "SMTO Handbook",
                                    "icon" => "fa-file-text",
                                    "href" => "/smto/handbook/"
                            )
                    )
            ),
            "MTOs" => array(
                    "permission" => "consultants,smto,mto",
                    "icon" => "fa-pencil",
                    "data" => array(
                            "MTO Database" => array(
                                    "name" => "MTO Database",
                                    "icon" => "fa-table",
                                    "href" => "/mto/database/"
                            ),
                            "MTO Master Form" => array(
                                    "name" => "MTO Master",
                                    "icon" => "fa-list",
                                    "href" => "/mto/master/"
                            ),
                            "MTO Interview Form" => array(
                                    "name" => "MTO Interview",
                                    "icon" => "fa-list",
                                    "href" => "/mto/interview/"
                            ),
                            "NHS Recommendations" => array(
                                    "name" => "Recommendation",
                                    "icon" => "fa-list",
                                    "href" => "/mto/recommend/"
                            ),
                            "BREAK" => true,
                            "MTO Handbook" => array(
                                    "name" => "MTO Handbook",
                                    "icon" => "fa-file-text",
                                    "href" => "/mto/handbook/"
                            ),
                            "NHS Ridealong Handbook" => array(
                                    "name" => "Ridealongs",
                                    "icon" => "fa-file-text",
                                    "href" => "/mto/ridealongs/"
                            ),
                            "BREAK2" => true,
                            "All MTO Feedbacks" => array(
                                    "name" => "MTO Feedbacks",
                                    "icon" => "fa-paste",
                                    "href" => "/mto/feedbacks/"
                            ),
                            "All MTO Timesheets" => array(
                                    "name" => "MTO Timesheets",
                                    "icon" => "fa-clock-o",
                                    "href" => "/mto/timesheets/"
                            ),
                            "BREAK3" => true,
                            "AR Timesheet" => array(
                                    "name" => "AR Timesheet",
                                    "icon" => "fa-plane",
                                    "href" => "/mto/ar/"
                            ),
                            "AR Database" => array(
                                    "name" => "AR Timesheet",
                                    "icon" => "fa-plane",
                                    "href" => "/mto/ardatabase/"
                            ),
                            "RIR Form" => array(
                                    "name" => "RIR Timesheet",
                                    "icon" => "fa-car",
                                    "href" => "/mto/rir/"
                            ),
                            "All AR Timesheets" => array(
                                    "name" => "AR Timesheet",
                                    "icon" => "fa-clock-o",
                                    "href" => "/mto/arlogs/"
                            ),
                            "All RIR Timesheets" => array(
                                    "name" => "RIR Timesheet",
                                    "icon" => "fa-clock-o",
                                    "href" => "/mto/rirlogs/"
                            )
                    )
            ),
            "App Team" => array(
                    "permission" => "consultants,app_team,seniorappteam",
                    "icon" => "fa-file-text-o",
                    "data" => array(
                            "App Form" => array(
                                    "name" => "App Log",
                                    "icon" => "fa-list",
                                    "href" => "/app/log/"
                            ),
                            "App Database" => array(
                                    "name" => "App Database",
                                    "icon" => "fa-table",
                                    "href" => "/app/database/"
                            ),
                            "Pending Applications" => array(
                                    "icon" => "fa-exclamation-circle",
                                    "href" => "https://www.roleplay.co.uk/forum/91-nhs-applications/"
                            ),
                            "App Responses" => array(
                                    "icon" => "fa-list",
                                    "href" => "https://www.roleplay.co.uk/topic/33230-application-notes-copy-from-here-app-team/"
                            ),
                            "App Handbook" => array(
                                    "name" => "App Handbook",
                                    "icon" => "fa-file-text",
                                    "href" => "/app/handbook/"
                            ),
                            "App Team Roster" => array(
                                    "name" => "App Team",
                                    "icon" => "fa-table",
                                    "href" => "/app/roster/"
                            ),
                            "BREAK" => true,
                            "HAT DB" => array(
                                    "name" => "HAT DB",
                                    "permission" => "consultants,seniorappteam",
                                    "icon" => "fa-table",
                                    "href" => "/app/hat/"
                            ),
                            "App Team Folder" => array(
                                    "name" => "App Folder",
                                    "permission" => "consultants,seniorappteam",
                                    "icon" => "fa-folder",
                                    "href" => "/app/folder/"
                            ),
                            "App Team Interview" => array(
                                    "name" => "AT Interview",
                                    "permission" => "consultants,seniorappteam",
                                    "icon" => "fa-list",
                                    "href" => "/app/interview/"
                            )
                    )
            ),
            "Air Rescue Staff" => array(
                    "permission" => "consultants,ar",
                    "icon" => "fa-plane",
                    "data" => array(
                            "AR Database" => array(
                                    "name" => "AR Database",
                                    "icon" => "fa-table",
                                    "href" => "/ar/database/"
                            ),
                            "AR Timesheet" => array(
                                    "icon" => "fa-list",
                                    "href" => "https://docs.google.com/forms/d/e/1FAIpQLSc4hJE9Zw07hbBbTpe65gzNcoPWwVKE2u_V3soMVUZvTV2n4Q/viewform"
                            ),
                            "AR Handbook" => array(
                                    "icon" => "fa-file-text",
                                    "href" => "https://docs.google.com/document/d/1vg7vGXUcGhIPt-9HmFnhpRUdkqaE9fdVh11-oHhmRG0/edit"
                            ),
                            "BREAK" => true,
                            "Entry Test v2 Doc" => array(
                                    "name" => "AR Entry Doc",
                                    "icon" => "fa-file-text",
                                    "href" => "/ar/entrydoc/"
                            ),
                            "Entry Test v2 Form" => array(
                                    "name" => "AR Entry Form",
                                    "icon" => "fa-list",
                                    "href" => "/ar/entryform/"
                            ),
                            "BREAK2" => true,
                            "Taru Test Doc" => array(
                                    "name" => "AR Taru Doc",
                                    "permission" => "consultants",
                                    "icon" => "fa-file-text",
                                    "href" => "/ar/tarudoc/"
                            ),
                            "Taru Test Form" => array(
                                    "name" => "AR Taru Form",
                                    "permission" => "consultants",
                                    "icon" => "fa-list",
                                    "href" => "/ar/taruform/"
                            ),
                            "AM+ Folder" => array(
                                    "name" => "AM Folder",
                                    "permission" => "consultants",
                                    "icon" => "fa-folder",
                                    "href" => "/ar/folder/"
                            )
                    )
            ),
            "RIR Staff" => array(
                    "permission" => "consultants,rir",
                    "icon" => "fa-car",
                    "data" => array(
                            "RIR Database" => array(
                                    "name" => "RIR Database",
                                    "icon" => "fa-table",
                                    "href" => "/rir/database/"
                            ),
                            "RIR Handbook" => array(
                                    "name" => "RIR Handbook",
                                    "icon" => "fa-file-text",
                                    "href" => "https://docs.google.com/document/d/1yzewp5RUIjfuRMgnL1pAl6abwpc_87ToprqB5dXrhB4/edit"
                            ),
                            "RIR Timesheet" => array(
                                    "name" => "RIR Timesheet",
                                    "icon" => "fa-list",
                                    "href" => "https://docs.google.com/forms/d/e/1FAIpQLScSvrGDoPstHhpCOlr_t_22fXWVhez52xYnhn7ltYYzqFidnw/viewform"
                            ),
                            "RIR Test Form" => array(
                                    "name" => "RIR Test",
                                    "icon" => "fa-list",
                                    "href" => "/rir/testform/"
                            ),
                            "RIR Folder" => array(
                                    "name" => "RIR Folder",
                                    "icon" => "fa-folder",
                                    "href" => "/rir/folder/"
                            ),
                            "BREAK" => true,
                            "RIR Request Form" => array(
                                    "name" => "RIR Request Form",
                                    "icon" => "fa-list",
                                    "href" => "https://docs.google.com/forms/d/e/1FAIpQLSfBVoVqZ-igK8IwZ2fXa53YSwXs39EbccChAWH6ZDaTuJQdsw/viewform"
                            ),
                            "RIR Test Requests" => array(
                                    "name" => "RIR Requests",
                                    "icon" => "fa-table",
                                    "href" => "/rir/requests/"
                            ),
                            "RIC Interest Form" => array(
                                    "name" => "RIC Form",
                                    "icon" => "fa-list",
                                    "href" => "https://docs.google.com/forms/d/e/1FAIpQLSc0GADKxT2M3pDrPKNCrwH4RYC0N5vCU-70FfeqvryoxfBsGw/viewform"
                            ),
                            "RIC Interests" => array(
                                    "name" => "RIC Interests",
                                    "icon" => "fa-table",
                                    "href" => "/rir/ricinterest/"
                            )
                    )
            ),
            "NHS Handbook" => array(
                    "name" => "Handbook",
                    "icon" => "fa-book",
                    "href" => "/handbook/"
            ),
            "User Management" => array(
                    "name" => "Users",
                    "permission" => "edituser",
                    "icon" => "fa-users",
                    "href" => "/users/"
            )
            //"BREAK" => true,
            //"Logout" => array(
            //        "icon" => "fa-sign-out",
            //        "href" => "/logout/"
            //)
    );
