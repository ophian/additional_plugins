<?php

// A fake provider that pretends to be some kind of LLM and simply returns
// a fixed JSON response without using the network at all.
final class FakeProvider implements LlmProvider
{
    public function chat(string $prompt, int $maxTokens = 500): string {
        return "{\"matched\": [\"php\"], \"new\": [\"cms\", \"plugin\"]}";
    }
    public function buildRequest(string $prompt, int $maxTokens = 500): array {
        return ["url" => "fake", "headers" => [], "body" => []];
    }
}
