@extends('errors.layout', [
    'code' => '404',
    'title' => 'Page not found',
    'message' => 'The page you are looking for does not exist or has been moved.',
    'hint' => 'Check the URL or explore the latest content.',
    'primaryText' => 'Go Home',
    'primaryUrl' => url('/'),
    'secondaryText' => 'Go Back',
    'secondaryUrl' => url()->previous(),
])
