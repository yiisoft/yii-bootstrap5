<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Yiisoft\Html\Html;

/**
 * AccordionItem represents a single collapsible item within an Accordion widget.
 *
 * Each item consists of a header that can be clicked to show/hide the body content. The item can be set as active
 * (expanded) by default and supports both raw and HTML content.
 *
 *
 * For example:
 *
 * ```php
 * AccordionItem::to(
 *     'Collapsible Group Item #1'
 *     'Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.',
 * );
 * ```
 */
final class AccordionItem
{
    private const DEFAULT_ID_PREFIX = 'collapse';

    /**
     * Use {@see AccordionItem::to()} to create a new instance.
     */
    private function __construct(
        private readonly bool $active = false,
        private readonly string $body = '',
        private readonly bool $encodeBody = true,
        private readonly bool $encodeHeader = true,
        private readonly string $header = '',
        private readonly bool|string $id = true,
    ) {
    }

    /**
     * Creates a new {@see AccordionItem} instance.
     *
     * @param string $header The header content.
     * @param string $body The body content.
     * @param bool|string $id The ID of the accordion item. If `true`, an auto-generated ID will be used. If `false`, no
     * ID will be set.
     * @param bool $encodeHeader Whether to encode the header content.
     * @param bool $encodeBody Whether to encode the body content.
     * @param bool $active Whether the item is active.
     *
     * @return self A new instance with the specified configuration.
     */
    public static function to(
        string $header = '',
        string $body = '',
        bool|string $id = true,
        bool $encodeHeader = true,
        bool $encodeBody = true,
        bool $active = false
    ): self {
        return new self($active, $body, $encodeBody, $encodeHeader, $header, $id);
    }

    /**
     * @return string The encoded header content. If {@see encodeHeader} is `false`, the header content will not be
     * encoded.
     */
    public function getHeader(): string
    {
        return $this->encodeHeader ? Html::encode($this->header) : $this->header;
    }

    /**
     * @return string The encoded body content. If {@see encodeBody} is `false`, the body content will not be encoded.
     */
    public function getBody(): string
    {
        return $this->encodeBody ? Html::encode($this->body) : $this->body;
    }

    /**
     * Returns the ID of the accordion item.
     *
     * @throws InvalidArgumentException If the "id" property is invalid.
     *
     * @return bool|string The ID of the accordion item.
     */
    public function getId(): bool|string
    {
        return match ($this->id) {
            true => Html::generateId(self::DEFAULT_ID_PREFIX . '-'),
            '', false => throw new InvalidArgumentException('The "id" property must be a non-empty string or `true`.'),
            default => $this->id,
        };
    }

    /**
     * @return bool Whether the item is active.
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
