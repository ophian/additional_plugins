<?php

/**
 * Talks to a local Ollama server (https://ollama.com) - no API key, no
 * per-request cost, runs entirely on your own machine. Relevant if you
 * want to try the LLM-tagging approach without touching a paid API at all
 * (see the earlier discussion about not wanting to pay just to test).
 * Requires `ollama serve` running locally and a model already pulled
 * (e.g. `ollama pull llama3.2`).
 * Changed to 'gemma4' in August, 13th 2026 for Take I.
 */
final class OllamaProvider implements LlmProvider
{
    private string $model;
    private string $baseUrl;

    /**
     * @param string $model   Must already be pulled locally, e.g. 'llama3.2',
     *                        'mistral', 'gemma2' - run `ollama list` to check.
     * @param string $baseUrl Default assumes Ollama's default local port.
     */
    public function __construct(string $model = 'gemma4', string $baseUrl = 'http://localhost:11434')
    {
        $this->model = $model;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function buildRequest(string $prompt, int $maxTokens = 500): array
    {
        return [
            'url' => $this->baseUrl . '/api/chat',
            'headers' => [
                'Content-Type: application/json',
            ],
            'body' => [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'stream' => false,
                'options' => [
                    'num_predict' => $maxTokens,
                ],
            ],
        ];
    }

    public function chat(string $prompt, int $maxTokens = 500): string
    {
        $request = $this->buildRequest($prompt, $maxTokens);

        $ch = curl_init($request['url']);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $request['headers'],
            CURLOPT_POSTFIELDS => json_encode($request['body'], JSON_UNESCAPED_UNICODE),
            // Local models can be slow on modest hardware - more generous timeout
            CURLOPT_TIMEOUT => 120,
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        $ch = NULL;

        if ($response === false) {
            throw new RuntimeException(
                'cURL error during Ollama call: ' . $error . ' - is `ollama serve` running?'
            );
        }
        if ($httpCode !== 200) {
            throw new RuntimeException("Ollama responded with HTTP {$httpCode}: {$response}");
        }

        $data = json_decode($response, true);

        return $data['message']['content'] ?? '';
    }
}
