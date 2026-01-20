@extends('errors.layout', [
    'code' => '503',
    'title' => 'Service unavailable',
    'message' => 'We are performing maintenance or experiencing heavy load.',
    'hint' => 'Please check back in a little while.',
    'primaryText' => 'Go Home',
    'primaryUrl' => url('/'),
    'secondaryText' => 'Go Back',
    'secondaryUrl' => url()->previous(),
])
