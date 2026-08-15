<?php

/**
 * NOTE ON THE MODEL NAME: 'gpt-4o-mini' below is a placeholder default that
 * was current at one point but may well be outdated by the time you read
 * this - OpenAI's model lineup moves fast and this code has no way to know
 * the current state. Check https://platform.openai.com/docs/models and pass
 * whatever model string is current into the constructor rather than relying
 * on the default.
 * Changed to 'gpt-5.6-luna' in August, 13th 2026 for Take I.
 */
final class OpenAiProvider implements LlmProvider
{
    private string $apiKey;
    private string $model;
    private string $endpoint = 'https://api.openai.com/v1/chat/completions';

    public function __construct(?string $apiKey = null, string $model = 'gpt-5.6-luna')
    {
        $this->apiKey = $apiKey ?? (string) getenv('OPENAI_API_KEY');
        $this->model = $model;

        if ($this->apiKey === '') {
            throw new RuntimeException(
                'No OpenAI API key found. Set OPENAI_API_KEY or pass one to the constructor.'
            );
        }
    }

    public function buildRequest(string $prompt, int $maxTokens = 500): array
    {
        return [
            'url' => $this->endpoint,
            'headers' => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->apiKey,
            ],
            'body' => [
                'model' => $this->model,
                'max_tokens' => $maxTokens,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
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
            CURLOPT_TIMEOUT => 30,
        ]);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            throw new RuntimeException('cURL error during OpenAI API call: ' . $error);
        }
        if ($httpCode !== 200) {
            throw new RuntimeException("OpenAI API responded with HTTP {$httpCode}: {$response}");
        }

        $data = json_decode($response, true);

        return $data['choices'][0]['message']['content'] ?? '';
    }
}
