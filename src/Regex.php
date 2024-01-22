<?php

namespace Diego\PathToRegexp;

class Regex
{
    public function __construct(
        protected string $regexPattern
    ) {
    }

    public function match(string $path)
    {
        $result = preg_match($this->regexPattern, $path);
        return boolVal($result);
    }
}
