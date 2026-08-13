<?php

require_once __DIR__ . '/llm/LlmProvider.php';
require_once __DIR__ . '/HtmlText.php';

/**
 * Tag suggestions via any LLM provider (Anthropic, OpenAI, Gemini, or a
 * local Ollama model - see lib/llm/). Expects a structured JSON response
 * for easy parsing.
 *
 * This class only builds the prompt and parses the reply - it has no idea
 * which provider it's talking to. Pass in whichever LlmProvider you want:
 *
 *   $tagger = new LlmTagger(new AnthropicProvider(), 'de');
 *   $tagger = new LlmTagger(new OpenAiProvider(), 'en');
 *   $tagger = new LlmTagger(new OllamaProvider('llama3.2'), 'de');
 */
final class LlmTagger
{
    private LlmProvider $provider;
    private string $language;

    /**
     * Prompt templates per language. Placeholders use sprintf's numbered
     * argument syntax (%1$d, %2$s, %3$s) rather than positional (%d, %s)
     * so the argument order never has to match between languages - each
     * template can reorder %1$.../%2$.../%3$... independently if needed.
     *
     * IMPORTANT: the JSON keys "matched" and "new" in the format example
     * stay in English in EVERY language template - that's the API contract
     * suggest() parses ($parsed['matched'], $parsed['new']), not something
     * translatable. Only the natural-language instructions are localized.
     *
     * Nowdoc syntax (<<<'PROMPT', single-quoted) is required here rather
     * than heredoc, since class constants must be compile-time constant
     * expressions - heredoc's variable interpolation would disqualify it.
     */
    private const PROMPT_TEMPLATES = [
        'en' => <<<'PROMPT'
You will be given a blog article and a list of already existing tags.
Suggest suitable tags for the article.

Rules:
- Prefer existing tags from the list if they fit the content.
- Also suggest new tags if important topics are missing.
- Maximum of %1$d tags total.
- Reply with ONLY valid JSON, no markdown code blocks, no prose.
- Keep the JSON keys "matched" and "new" exactly as shown below, in
  English, regardless of the article's language.

Format:
{"matched": ["existing tag", ...], "new": ["new tag", ...]}

Existing tags: %2$s

Article:
%3$s
PROMPT,
        'de' => <<<'PROMPT'
Du bekommst einen Blogartikel und eine Liste bereits vorhandener Tags.
Schlage passende Tags fuer den Artikel vor.

Regeln:
- Bevorzuge bestehende Tags aus der Liste, wenn sie zum Inhalt passen.
- Schlage zusaetzlich neue Tags vor, falls wichtige Themen fehlen.
- Maximal %1$d Tags insgesamt.
- Antworte NUR mit gueltigem JSON, keine Markdown-Codebloecke, kein Fliesstext.
- Die JSON-Schluessel "matched" und "new" bleiben unveraendert auf
  Englisch, unabhaengig von der Sprache des Artikels.

Format:
{"matched": ["bestehender Tag", ...], "new": ["neuer Tag", ...]}

Bestehende Tags: %2$s

Artikel:
%3$s
PROMPT,
    ];

    private const NO_TAGS_LABEL = [
        'en' => '(none available)',
        'de' => '(keine vorhanden)',
    ];

    /**
     * @param LlmProvider $provider Which LLM to talk to - see lib/llm/
     * @param string      $language 'en' or 'de' - controls the prompt language.
     *                              Falls back to 'en' for anything else.
     */
    public function __construct(LlmProvider $provider, string $language = 'en')
    {
        $this->provider = $provider;
        $this->language = isset(self::PROMPT_TEMPLATES[$language]) ? $language : 'en';
    }

    /**
     * Builds the finished prompt WITHOUT calling the API - split out
     * specifically so the prompt text itself can be inspected/unit-tested
     * without an API key or network access. suggest() below just wraps this.
     */
    public function buildPrompt(string $text, array $existingTags = [], int $limit = 5): string
    {
        $plain = HtmlText::toPlainText($text);
        // Truncate very long articles for the prompt (saves tokens/cost)
        if (mb_strlen($plain) > 6000) {
            $plain = mb_substr($plain, 0, 6000) . ' […]';
        }

        $tagList = empty($existingTags)
            ? self::NO_TAGS_LABEL[$this->language]
            : implode(', ', $existingTags);

        return sprintf(self::PROMPT_TEMPLATES[$this->language], $limit, $tagList, $plain);
    }

    /**
     * @param string   $text          Article text (raw, HTML is stripped roughly)
     * @param string[] $existingTags  Known tags that should be reused preferentially
     * @param int      $limit         Max number of tags
     * @return array{matched: string[], suggested: array<array{tag:string, score:float}>}
     */
    public function suggest(string $text, array $existingTags = [], int $limit = 5): array
    {
        $prompt = $this->buildPrompt($text, $existingTags, $limit);
        $textBlock = $this->provider->chat($prompt, 500);

        $clean = trim(preg_replace('/```json|```/', '', $textBlock));
        $parsed = json_decode($clean, true);

        if (!is_array($parsed)) {
            // Fallback: mark the raw response as a single "tag" so nothing is lost
            return ['matched' => [], 'suggested' => [['tag' => '(parse error: ' . $clean . ')', 'score' => 0.0]]];
        }

        $matched = $parsed['matched'] ?? [];
        $newTags = $parsed['new'] ?? [];

        $suggested = [];
        foreach ($newTags as $tag) {
            $suggested[] = ['tag' => $tag, 'score' => 1.0];
        }

        return ['matched' => $matched, 'suggested' => $suggested];
    }
}
