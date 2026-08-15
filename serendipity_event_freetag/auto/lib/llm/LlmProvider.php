<?php

/**
 * Common interface every LLM provider implements. LlmTagger only talks to
 * this interface - it builds the prompt (multilingual, see LlmTagger.php)
 * and parses the JSON reply, but has no idea whether it's talking to
 * Anthropic, OpenAI, Gemini, or a local Ollama model. Each provider only
 * has to translate "send this prompt, give me back the plain text reply".
 */
interface LlmProvider
{
    /**
     * Sends a prompt and returns the model's raw text reply (whatever text
     * the model generated - LlmTagger is responsible for parsing it as JSON).
     *
     * @throws RuntimeException on network/API errors
     */
    public function chat(string $prompt, int $maxTokens = 500): string;

    /**
     * Builds the request (URL, headers, body) WITHOUT sending it. Split out
     * from chat() so the request itself can be inspected/tested without
     * network access or an API key - the same pattern LlmTagger::buildPrompt()
     * already uses.
     *
     * @return array{url: string, headers: string[], body: array}
     */
    public function buildRequest(string $prompt, int $maxTokens = 500): array;
}
