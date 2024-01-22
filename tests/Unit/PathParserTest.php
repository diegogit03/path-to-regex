<?php

use Diego\PathToRegexp\PathParser;

test('It should create a regex for a simple path', function () {
    $parser = new PathParser();
    $regex = $parser->toRegex('/users');

    expect($regex->match('/users')->test())->toBe(true);
});

test('It should create a regex for simple path that recuses invalid urls', function () {
    $parser = new PathParser();
    $regex = $parser->toRegex('/users');

    expect($regex->match('/user')->test())->toBe(false);
    expect($regex->match('/users//')->test())->toBe(false);
    expect($regex->match('//users/')->test())->toBe(false);
    expect($regex->match('users')->test())->toBe(false);
});

test('It should create a regex for a path with params', function () {
    $parser = new PathParser();
    $regex = $parser->toRegex('/users/:id');

    expect($regex->match('/users/1')->test())->toBe(true);
});

test('It should create a regex for a path with multiple params', function () {
    $parser = new PathParser();
    $regex = $parser->toRegex('/users/:blog_id/posts/:post_id');

    expect($regex->match('/users/1/posts/2')->test())->toBe(true);
});

test('It should create a regex for a path with optional param', function () {
    $parser = new PathParser();
    $regex = $parser->toRegex('/users/:id?');

    expect($regex->match('/users/1')->test())->toBe(true);
    expect($regex->match('/users')->test())->toBe(true);
});
