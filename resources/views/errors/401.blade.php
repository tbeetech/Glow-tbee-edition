@extends('errors.layout', [
    'code' => '401',
    'title' => 'Sign-in required',
    'message' => 'You are not authorized to view this page without signing in.',
    'hint' => 'Try logging in with an account that has access.',
    'primaryText' => 'Sign In',
    'primaryUrl' => url('/login'),
    'secondaryText' => 'Go Back',
    'secondaryUrl' => url()->previous(),
])
