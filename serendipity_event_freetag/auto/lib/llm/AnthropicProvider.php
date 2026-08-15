<?php

/**
 * NOTE ON THE MODEL NAME: same caveat as OpenAiProvider - 'claude-sonnet-4-20250514'
 * may be outdated by the time you use this. Check
 * https://platform.claude.com/docs/en/about-claude/models/overview for the current lineup.
 * Changed to 'claude-sonnet-5' in August, 13th 2026 for Take I.
 */
final class AnthropicProvider implements LlmProvider
{
    private string $apiKey;
    private string $model;
    private string $endpoint = 'https://api.anthropic.com/v1/messages';

    /**
     * @param string $model e.g. 'claude-sonnet-5' (quality) or 'claude-haiku-4-5-20251001' (cheap/fast)
     */
    public function __construct(?string $apiKey = null, string $model = 'claude-sonnet-5')
    {
        $this->apiKey = $apiKey ?? (string) getenv('ANTHROPIC_API_KEY');
        $this->model = $model;

        if ($this->apiKey === '') {
            throw new RuntimeException(
                'No Anthropic API key found. Set ANTHROPIC_API_KEY or pass one to the constructor.'
            );
        }
    }

    public function buildRequest(string $prompt, int $maxTokens = 500): array
    {
        return [
            'url' => $this->endpoint,
            'headers' => [
                'Content-Type: application/json',
                'x-api-key: ' . $this->apiKey,
                'anthropic-version: 2023-06-01',
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
            throw new RuntimeException('cURL error during Anthropic API call: ' . $error);
        }
        if ($httpCode !== 200) {
            throw new RuntimeException("Anthropic API responded with HTTP {$httpCode}: {$response}");
        }

        $data = json_decode($response, true);
        $text = '';
        foreach ($data['content'] ?? [] as $block) {
            if (($block['type'] ?? '') === 'text') {
                $text .= $block['text'];
            }
        }

        return $text;
    }
}
