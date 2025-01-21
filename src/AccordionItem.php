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
        private bool $active = false,
        private string $body = '',
        private bool $encodeBody = true,
        private bool $encodeHeader = true,
        private string $header = '',
        private bool|string $id = true,
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
     * Sets the active state of the accordion item.
     *
     * @param bool $value Whether the accordion item is active.
     *
     * @return self A new instance with the specified active state.
     */
    public function active(bool $value): self
    {
        $new = clone $this;
        $new->active = $value;

        return $new;
    }

    /**
     * Sets the body content of the accordion item.
     *
     * @param string $value The body content.
     *
     * @return self A new instance with the specified body content.
     */
    public function body(string $value): self
    {
        $new = clone $this;
        $new->body = $value;

        return $new;
    }

    /**
     * Sets whether to encode the body content.
     *
     * @param bool $value Whether to encode the body content.
     *
     * @return self A new instance with the specified encoding setting.
     */
    public function encodeBody(bool $value): self
    {
        $new = clone $this;
        $new->encodeBody = $value;

        return $new;
    }

    /**
     * Sets whether to encode the header content.
     *
     * @param bool $value Whether to encode the header content.
     *
     * @return self A new instance with the specified encoding setting.
     */
    public function encodeHeader(bool $value): self
    {
        $new = clone $this;
        $new->encodeHeader = $value;

        return $new;
    }

    /**
     * Sets the header content of the accordion item.
     *
     * @param string $value The header content.
     *
     * @return self A new instance with the specified header content.
     */
    public function header(string $value): self
    {
        $new = clone $this;
        $new->header = $value;

        return $new;
    }

    /**
     * Sets the ID of the accordion item.
     *
     * @param bool|string $value The ID of the accordion item. If `true`, an auto-generated ID will be used. If `false`,
     * no ID will be set.
     *
     * @throws InvalidArgumentException If the "id" property is empty or `false`.
     *
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $value): self
    {
        if ($value === '' || $value === false) {
            throw new InvalidArgumentException('The "id" property must be a non-empty string or `true`.');
        }

        $new = clone $this;
        $new->id = $value;

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
