<?php

use Whitecube\LaravelTimezones\Casts\TimezonedDatetime;

it('can access UTC database date with application timezone', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = '2022-12-15 09:00:00';

    $output = $cast->get(fakeModel(), 'id', $input, []);

    expect($output->getTimezone()->getName())->toBe('Europe/Brussels');
    expect($output->format('Y-m-d H:i:s'))->toBe('2022-12-15 10:00:00');
});

it('can access UTC database date with application timezone and specific format', function() {
    setupFacade();

    $cast = new TimezonedDatetime('d/m/Y H:i');

    $input = '15/12/2022 09:00';

    $output = $cast->get(fakeModel(), 'id', $input, []);

    expect($output->getTimezone()->getName())->toBe('Europe/Brussels');
    expect($output->format('Y-m-d H:i:s'))->toBe('2022-12-15 10:00:00');
});

it('can access NULL date as NULL', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = null;

    $output = $cast->get(fakeModel(), 'id', $input, []);

    expect($output)->toBeNull();
});

it('can access empty string as NULL', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = '';

    $output = $cast->get(fakeModel(), 'id', $input, []);

    expect($output)->toBeNull();
});

it('can mutate application timezone datetime string to UTC database date string', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = '2022-12-15 10:00:00';

    $output = $cast->set(fakeModel(), 'id', $input, []);

    expect($output)->toBe('2022-12-15 09:00:00');
});

it('can mutate application timezone date instance to UTC database date string', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = new \Carbon\Carbon('2022-12-15 10:00:00', 'Europe/Brussels');

    $output = $cast->set(fakeModel(), 'id', $input, []);

    expect($output)->toBe('2022-12-15 09:00:00');
});

it('can mutate UTC date instance to UTC database date string', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = new \Carbon\Carbon('2022-12-15 09:00:00', 'UTC');

    $output = $cast->set(fakeModel(), 'id', $input, []);

    expect($output)->toBe('2022-12-15 09:00:00');
});

it('can mutate date instance with exotic timezone to UTC database date string', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = new \Carbon\Carbon('2022-12-15 04:00:00', 'America/Toronto');

    $output = $cast->set(fakeModel(), 'id', $input, []);

    expect($output)->toBe('2022-12-15 09:00:00');
});

it('can mutate NULL as NULL', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = null;

    $output = $cast->set(fakeModel(), 'id', $input, []);

    expect($output)->toBeNull();
});

it('can mutate empty string as NULL', function() {
    setupFacade();

    $cast = new TimezonedDatetime();

    $input = '';

    $output = $cast->set(fakeModel(), 'id', $input, []);

    expect($output)->toBeNull();
});