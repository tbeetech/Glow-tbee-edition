@extends('errors.layout', [
    'code' => '500',
    'title' => 'Server error',
    'message' => 'We hit an unexpected issue on our side.',
    'hint' => 'Try again in a few moments.',
    'primaryText' => 'Go Home',
    'primaryUrl' => url('/'),
    'secondaryText' => 'Try Again',
    'secondaryUrl' => url()->current(),
])
