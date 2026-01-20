@extends('errors.layout', [
    'code' => '403',
    'title' => 'Access denied',
    'message' => 'You do not have permission to open this page.',
    'hint' => 'If you think this is a mistake, reach out to an administrator.',
    'primaryText' => 'Go Home',
    'primaryUrl' => url('/'),
    'secondaryText' => 'Go Back',
    'secondaryUrl' => url()->previous(),
])
