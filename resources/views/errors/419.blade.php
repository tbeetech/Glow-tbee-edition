@extends('errors.layout', [
    'code' => '419',
    'title' => 'Page expired',
    'message' => 'Your session has expired or the form token is no longer valid.',
    'hint' => 'Refresh and try again.',
    'primaryText' => 'Refresh',
    'primaryUrl' => url()->current(),
    'secondaryText' => 'Go Back',
    'secondaryUrl' => url()->previous(),
])
