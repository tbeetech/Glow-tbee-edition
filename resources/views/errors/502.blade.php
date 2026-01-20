@extends('errors.layout', [
    'code' => '502',
    'title' => 'Bad gateway',
    'message' => 'We received an invalid response while trying to load this page.',
    'hint' => 'Please try again shortly.',
    'primaryText' => 'Go Home',
    'primaryUrl' => url('/'),
    'secondaryText' => 'Try Again',
    'secondaryUrl' => url()->current(),
])
