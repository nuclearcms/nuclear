@extends('partials.contents.tabs')

<?php $flaps = [
    'reactor.users.edit' => 'users.self',
    'reactor.users.password' => 'validation.attributes.password',
    'reactor.users.roles' => 'roles.title',
    'reactor.users.permissions' => 'permissions.title',
    'reactor.users.history' => 'general.history'
]; ?>