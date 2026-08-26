<?php

/**
 * NOTE ON THE MODEL NAME: same caveat as OpenAiProvider - 'gemini-2.0-flash'
 * may be outdated by the time you use this. Check
 * https://ai.google.dev/gemini-api/docs/models for the current lineup.
 * Changed to 'gemini-3.1-flash-lite' in August, 13th 2026 for Take I.
 */
final class GeminiProvider implements LlmProvider
{
    private string $apiKey;
    private string $model;

    public function __construct(?string $apiKey = null, string $model = 'gemini-3.1-flash-lite')
    {
        $this->apiKey = $apiKey ?? (string) getenv('GEMINI_API_KEY');
        $this->model = $model;

        if ($this->apiKey === '') {
            throw new RuntimeException(
                'No Gemini API key found. Set GEMINI_API_KEY or pass one to the constructor.'
            );
        }
    }

    public function buildRequest(string $prompt, int $maxTokens = 500): array
    {
        $url = sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
            $this->model,
            $this->apiKey
        );

        return [
            'url' => $url,
            'headers' => [
                'Content-Type: application/json',
            ],
            'body' => [
                'contents' => [
                    ['parts' => [['text' => $prompt]]],
                ],
                'generationConfig' => [
                    'maxOutputTokens' => $maxTokens,
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
        $ch = NULL;

        if ($response === false) {
            throw new RuntimeException('cURL error during Gemini API call: ' . $error);
        }
        if ($httpCode !== 200) {
            throw new RuntimeException("Gemini API responded with HTTP {$httpCode}: {$response}");
        }

        $data = json_decode($response, true);

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    }
}
