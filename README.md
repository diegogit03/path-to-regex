# PathToRegexp PHP Library

The `PathToRegexp` PHP library allows you to easily convert route paths into regular expression patterns for flexible route matching in web applications. This readme provides an overview of the library and includes various examples of usage.

## Installation

```bash
composer require diego/path-to-regexp
```

## Usage

### Basic Usage

```php
use Diego\PathToRegexp\PathParser;

$pathParser = new PathParser();
$pattern = $pathParser->toRegex('/users/:id/edit');

// Use $pattern in your route matching logic
if ($pattern->matches($uri)) {
    // Matched!
}
```

### Route with Parameter

```php
$pathParser = new PathParser();
$pattern = $pathParser->toRegex('/posts/:postId');

// The resulting pattern will match paths like '/posts/123'
if ($pattern->matches($uri)) {
    // Matched!
}
```

### Route with Optional Parameter

```php
$pathParser = new PathParser();
$pattern = $pathParser->toRegex('/articles/:slug?');

// The resulting pattern will match paths like '/articles' and '/articles/some-slug'
if ($pattern->matches($uri)) {
    // Matched!
}
```

### Route with Text Segment

```php
$pathParser = new PathParser();
$pattern = $pathParser->toRegex('/categories/:categoryName');

// The resulting pattern will match paths like '/categories/some-category'
if ($pattern->matches($uri)) {
    // Matched!
}
```

### Complex Route

```php
$pathParser = new PathParser();
$pattern = $pathParser->toRegex('/users/:userId/:action?');

// The resulting pattern will match paths like '/users/123' and '/users/123/edit'
if ($pattern->matches($uri)) {
    // Matched!
}
```

### Note on Regular Expression Patterns

The library uses the `TRegx\CleanRegex\Pattern` class for regular expression patterns. You can leverage its features for more advanced use cases. Check the [T-Regx documentation](https://github.com/t-regx/T-Regx) for detailed information.

## Contributing

Contributions are welcome! Feel free to open issues or submit pull requests.

## License

This library is open-sourced software licensed under the [MIT license](https://gitlab.com/diegogitlab03/path-to-regexp/-/blob/master/LICENSE.md?ref_type=heads).
