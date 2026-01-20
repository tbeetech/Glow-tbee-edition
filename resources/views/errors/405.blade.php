@extends('errors.layout', [
    'code' => '405',
    'title' => 'Method not allowed',
    'message' => 'That action is not supported for this page.',
    'hint' => 'Try navigating using the menus instead.',
    'primaryText' => 'Go Home',
    'primaryUrl' => url('/'),
    'secondaryText' => 'Go Back',
    'secondaryUrl' => url()->previous(),
])
