<?php

return [
    // Model which will be having points, generally it will be User
    'payee_model' => '\App\User',

    // Reputation model
    'reputation_model' => '\QCod\Gamify\Reputation',

    // Allow duplicate reputation points
    'allow_reputation_duplicate' => true,

    // Broadcast on private channel
    'broadcast_on_private_channel' => false,

    // Channel name prefix, user id will be suffixed
    'channel_name' => 'user.reputation.',

    // Badge model
    'badge_model' => '\QCod\Gamify\Badge',

    // Where all badges icon stored
    'badge_icon_folder' => 'images/badges/',

    // Extention of badge icons
    'badge_icon_extension' => '.svg',

    // All the levels for badge
    'badge_levels' => [
        'No-Coiner 😱' => 0,
        'Shitcoiner 💩' => 0,
        'Trader 🎢' => 0,
        'Im Rabbit hole 🐰🕳' => 0,
        'DCA 🗓' => 0,
        'Not your keys, not your coins 🗝' => 0,
        'Wale 🐋' => 0,
        'Running a Node 📡' => 0,
        'Lightning-User ⚡️' => 0,
        'Miner ⛏️' => 0,
        'Solo-Miner 🎲' => 0,
        'Orange Pilled 💊' => 1,
        'Cyber Hornet 🐝' => 21000, // 210.000
        'Toxic Maximalist 🧪' => 21000, // 210.000
        'Satoshi Nakamoto 🧠' => 21000000, // 21.000.000
    ],

    // Default level
    'badge_default_level' => 0,
];
