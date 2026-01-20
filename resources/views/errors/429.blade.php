@extends('errors.layout', [
    'code' => '429',
    'title' => 'Too many requests',
    'message' => 'You are doing that a bit too fast. Please slow down.',
    'hint' => 'Wait a moment and try again.',
    'primaryText' => 'Go Home',
    'primaryUrl' => url('/'),
    'secondaryText' => 'Go Back',
    'secondaryUrl' => url()->previous(),
])
