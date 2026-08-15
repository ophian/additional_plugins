<?php

/**
 * Minimal autoloader - no Composer needed. Registers a function that PHP
 * calls automatically whenever an unknown class is first referenced
 * (`new SomeClass`, `instanceof`, etc.), BEFORE PHP would otherwise fatal
 * with "Class not found". The function's only job: turn the class name
 * into a file path and require it.
 *
 * This is what "namespace"/"use" were missing on their own - those just
 * change how a class is *named/referenced*, they don't tell PHP *where the
 * file is*. spl_autoload_register() is the piece that does that.
 */
spl_autoload_register(function (string $class): void {
    // Convention: LlmProvider -> lib/LlmProvider.php,
    // i.e.        AnthropicProvider -> lib/llm/AnthropicProvider.php
    $candidates = [
        __DIR__ . "/lib/{$class}.php",
        __DIR__ . "/lib/llm/{$class}.php",
    ];
    foreach ($candidates as $file) {
        if (is_file($file)) {
            require_once $file;
            return;
        }
    }
});
