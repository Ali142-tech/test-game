<?php

return [
    'attributes' => [
        'name' => 'full name',
        'email' => 'email address',
        'password' => 'password',
        'password_confirmation' => 'password confirmation',
        'phone' => 'phone number',
        'phone_country' => 'country',
        'phone_dial_code' => 'country code',
    ],

    'validation' => [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.max' => 'Email address cannot be longer than :max characters.',
        'email.unique' => 'An account with this email already exists. Try signing in instead.',
        'password.required' => 'Please enter your password.',
        'password.min' => 'Password must be at least :min characters.',
        'password.confirmed' => 'Passwords do not match. Please re-enter them.',
        'name.required' => 'Please enter your full name.',
        'name.min' => 'Name must be at least :min characters.',
        'name.max' => 'Name cannot be longer than :max characters.',
        'name.regex' => 'Name may only contain letters, spaces, hyphens, and apostrophes.',
        'phone.required' => 'Please enter your phone number.',
        'phone.regex' => 'Please enter a valid phone number (digits only, 7–15 numbers).',
        'phone_country.required' => 'Please select your country.',
        'phone_country.in' => 'Please choose a valid country from the list.',
        'phone_dial_code.required' => 'Please select a valid country code.',
    ],

    'login' => [
        'failed' => 'The email or password you entered is incorrect.',
        'admin_only' => 'Admin accounts must sign in from the admin login page.',
    ],
];
