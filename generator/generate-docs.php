<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use bulgarianhealer\Twitch\Twitch;

$markdown = collect(class_uses(Twitch::class))
    ->map(function ($trait) {

        $title = str_replace('Trait', '', Arr::last(explode('\\', $trait)));

        if (in_array($title, ['Authentication', 'Validation'])) {
            return null;
        }

        $methods = [];

        $reflection = new ReflectionClass($trait);

        collect($reflection->getMethods())
            ->reject(function (ReflectionMethod $method) {
                return $method->isAbstract();
            })
            ->reject(function (ReflectionMethod $method) {
                return $method->isPrivate() || $method->isProtected();
            })
            ->reject(function (ReflectionMethod $method) {
                return $method->isConstructor();
            })
            ->each(function (ReflectionMethod $method) use (&$methods, $title, $trait) {

                $declaration = collect($method->getModifiers())->map(function (int $modifier) {
                    return $modifier == ReflectionMethod::IS_PUBLIC ? 'public ' : '';
                })->join(' ');

                $declaration .= 'function ';
                $declaration .= $method->getName();
                $declaration .= '(';

                $declaration .= collect($method->getParameters())->map(function (ReflectionParameter $parameter) {

                    $parameterString = '';

                    if ($parameter->allowsNull()) {
                        $parameterString .= '?';
                    }

                    $parameterString .= Arr::last(explode('\\', $parameter->getType()->getName()));
                    $parameterString .= ' ';
                    $parameterString .= '$';
                    $parameterString .= $parameter->getName();

                    if ($parameter->isDefaultValueAvailable()) {
                        $parameterString .= ' = ';
                        $parameterString .= str_replace([
                            PHP_EOL,
                            'array ()',
                        ], [
                            '',
                            '[]',
                        ], var_export($parameter->getDefaultValue(), true));
                    }

                    return $parameterString;

                })->join(', ');

                $declaration .= ')';

                // $method->isDeprecated() dos not work for whatever reason
                if (Str::contains($method->getDocComment(), '@deprecated')) {
                    $declaration .= ' // DEPRECATED';
                }

                $methods[] = $declaration;
            });

        return [$title, $methods];
    })
    ->filter(function ($args) {
        return ! empty($args);
    })
    ->map(function ($args) {

        [$title, $methods] = $args;

        $markdown = '### ' . $title;
        $markdown .= PHP_EOL . PHP_EOL;
        $markdown .= '```php';
        $markdown .= PHP_EOL;

        $markdown .= collect($methods)->each(function ($method) {
            return $method;
        })->implode(PHP_EOL);

        $markdown .= PHP_EOL;
        $markdown .= '```';

        return $markdown;
    })->join(PHP_EOL . PHP_EOL);

$content = file_get_contents(__DIR__ . '/../README.stub.md');

$content = str_replace('<!-- GENERATED-DOCS -->', $markdown, $content);

file_put_contents(__DIR__ . '/../README.md', $content);
