<?php

return [
    "GET" => [
        "/users/{id}" => [
            "name" => "users.show",
            "target" => ["api.users", "show"],
            "filter" => [
                "id" => "[A-Za-z0-9_-]+"
            ]
        ]
    ],

    "PUT" => [
        "/users/{id}" => [
            "name" => "users.update",
            "target"=> ["api.users", "update"],
            "filter" => [
                "id" => "[A-Za-z0-9_-]+"
            ]
        ]
    ]
];