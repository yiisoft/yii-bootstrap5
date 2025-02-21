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
        private bool $active,
        private string $body,
        private bool $encodeBody,
        private bool $encodeHeader,
        private string $header,
        private bool|string $id,
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
     * Sets the active state.
     *
     * @param bool $enabled Whether the accordion item is active.
     *
     * @return self A new instance with the specified active state.
     */
    public function active(bool $enabled): self
    {
        $new = clone $this;
        $new->active = $enabled;

        return $new;
    }

    /**
     * Sets the body content.
     *
     * @param string $content The body content.
     *
     * @return self A new instance with the specified body content.
     */
    public function body(string $content): self
    {
        $new = clone $this;
        $new->body = $content;

        return $new;
    }

    /**
     * Sets whether to encode the body content.
     *
     * @param bool $enabled Whether to encode the body content.
     *
     * @return self A new instance with the specified encoding setting.
     */
    public function encodeBody(bool $enabled): self
    {
        $new = clone $this;
        $new->encodeBody = $enabled;

        return $new;
    }

    /**
     * Sets whether to encode the header content.
     *
     * @param bool $enabled Whether to encode the header content.
     *
     * @return self A new instance with the specified encoding setting.
     */
    public function encodeHeader(bool $enabled): self
    {
        $new = clone $this;
        $new->encodeHeader = $enabled;

        return $new;
    }

    /**
     * Sets the header content.
     *
     * @param string $content The header content.
     *
     * @return self A new instance with the specified header content.
     */
    public function header(string $content): self
    {
        $new = clone $this;
        $new->header = $content;

        return $new;
    }

    /**
     * Sets the ID.
     *
     * @param bool|string $id The ID of the accordion item. If `true`, an auto-generated ID will be used. If `false`,
     * no ID will be set.
     *
     * @throws InvalidArgumentException If the "id" property is empty or `false`.
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $id): self
    {
        if ($id === '' || $id === false) {
            throw new InvalidArgumentException('The "id" property must be a non-empty string or `true`.');
        }

        $new = clone $this;
        $new->id = $id;

        return $new;
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
     * Returns the ID.
     *
     * @throws InvalidArgumentException If the "id" property is invalid.
     *
     * @return bool|string The ID.
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
