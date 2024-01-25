<?php

namespace Diego03\PathToRegexp;

use Exception;
use TRegx\CleanRegex\Pattern;

class PathParser
{
    const PARAM_REGEX = '/^:\w+$/';
    const OPTIONAL_PARAM_REGEX = '/^:\w+\?$/';
    const TEXT_REGEX = '/^\w+$/';

    public function toRegex(string $path)
    {
        if ($path === '/') {
            return Pattern::of('^\/$');
        }

        $tokens = $this->tokenize($path);
        $regexPattern = '';

        foreach ($tokens as $token) {
            if ($token['type'] === 'param') {
                $regexPattern .= "(\/(?<{$token['value']}>\w+))";
            } else if ($token['type'] === 'optional_param') {
                $regexPattern .= "(\/(?<{$token['value']}>\w*))?";
            } else if ($token['type'] === 'name') {
                $regexPattern .= "(\/{$token['value']})";
            }
        }

        $regexPattern = "^$regexPattern$";

        return Pattern::of($regexPattern);
    }

    protected function tokenize(string $path)
    {
        $parts = explode('/', $path);
        $tokens = [];

        if ($parts[0] === '') {
            array_shift($parts);
        }

        foreach ($parts as $part) {

            if (boolval(preg_match(self::PARAM_REGEX, $part))) {
                $tokens[] = $this->paramToken($part);
                continue;
            } else if (boolval(preg_match(self::OPTIONAL_PARAM_REGEX, $part))) {
                $tokens[] = $this->optionalParamToken($part);
                continue;
            } else if (boolval(preg_match(self::TEXT_REGEX, $part))) {
                $tokens[] = $this->textToken($part);
                continue;
            } else {
                throw new Exception('Invalid route');
            }
        }

        return $tokens;
    }

    protected function paramToken(string $part)
    {
        $paramAlias = str_split($part);
        array_shift($paramAlias);

        return [
            'type' => 'param',
            'value' => implode('', $paramAlias)
        ];
    }

    protected function optionalParamToken(string $part)
    {
        $paramAlias = str_split($part);
        array_shift($paramAlias);
        array_pop($paramAlias);

        return [
            'type' => 'optional_param',
            'value' => implode('', $paramAlias)
        ];
    }

    protected function textToken(string $part)
    {
        return [
            'type' => 'name',
            'value' => $part
        ];
    }
}
