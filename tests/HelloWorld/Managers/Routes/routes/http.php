<?php

return [
    "GET" => [
        "/users" => [
            "name" => "users.all",
            "target" => ["users", "index"]
        ]
    ],

    "POST" => [
        "/users/create" => [
            "name" => "users.create",
            "target"=> ["users", "create"]
        ]
    ]
];