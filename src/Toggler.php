<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;

/**
 * Toggler represents a single collapsible item within a Bootstrap Collapse component.
 *
 * Each item consists of a toggler (button/link) that controls the visibility of collapsible content.
 * The toggler can be rendered as either a button or link, and can control single or multiple collapse targets.
 *
 * Example usage:
 * ```php
 * // Basic usage
 * Toggler::for(
 *     'Collapsible content here',
 *     togglerContent: 'Toggle collapse'
 * );
 *
 * // As a link with custom ID
 * Toggler::for(
 *     'Collapsible content',
 *     togglerContent: 'Toggle collapse',
 *     togglerAsLink: true,
 *     id: 'customId'
 * );
 *
 * // Multiple collapse control
 * Toggler::for()
 *     ->togglerMultiple(true)
 *     ->ariaControls('collapse1 collapse2')
 *     ->togglerContent('Toggle multiple collapses');
 * ```
 */
final class Toggler
{
    /**
     * Use {@see Toggler::for()} to create an instance.
     */
    private function __construct(
        private string $content,
        private string|bool $id,
        private string $togglerTag,
        private string $togglerContent,
        private bool $togglerAsLink,
        private array $togglerAttributes,
        private bool $encode,
        private bool $togglerMultiple,
        private string $ariaControls,
    ) {
    }

    public static function for(
        string $content = '',
        string|bool $id = true,
        string $togglerTag = 'button',
        string $togglerContent = '',
        bool $togglerAsLink = false,
        array $togglerAttributes = [],
        bool $encode = true,
        bool $togglerMultiple = false,
        string $ariaControls = '',
    ): self {
        $new = new self(
            $content,
            $id,
            $togglerTag,
            $togglerContent,
            $togglerAsLink,
            $togglerAttributes,
            $encode,
            $togglerMultiple,
            $ariaControls,
        );

        return $new->id($new->getId());
    }

    /**
     * Sets the `aria-controls` attribute value for the toggler.
     *
     * @param string $ariaControls The `aria-controls` attribute value for the toggler.
     *
     * @return self A new instance with the specified `aria-controls` attribute value for the toggler.
     */
    public function ariaControls(string $ariaControls): self
    {
        $new = clone $this;
        $new->ariaControls = $ariaControls;

        return $new;
    }

    /**
     * Sets the content to be displayed in the collapsible item.
     *
     * @param string|Stringable $content The content to be displayed in the collapsible item.
     *
     * @return self A new instance with the specified content to be displayed in the collapsible item.
     */
    public function content(string|Stringable $content): self
    {
        $new = clone $this;
        $new->content = (string)$content;

        return $new;
    }

    /**
     * Sets whether to HTML encode the content.
     *
     * @param bool $enabled Whether to HTML encode the content.
     *
     * @return self A new instance with the specified encoding behavior.
     */
    public function encode(bool $enabled): self
    {
        $new = clone $this;
        $new->encode = $enabled;

        return $new;
    }

    /**
     * Generates the ID.
     *
     * @throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     * @return string The generated ID.
     *
     * @psalm-return non-empty-string The generated ID.
     */
    public function getId(): string
    {
        return match ($this->id) {
            true => Html::generateId('collapse-'),
            '', false => throw new InvalidArgumentException('The "id" must be specified.'),
            default => $this->id,
        };
    }

    /**
     * Sets the ID.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
     *
     * @throws InvalidArgumentException if the ID is an empty string or `false`.
     *
     * @return self A new instance with the specified ID.
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * @return string The content to be displayed in the collapsible item.
     */
    public function getContent(): string
    {
        return $this->encode ? Html::encode($this->content) : $this->content;
    }

    public function getTogglerMultiple(): bool
    {
        return $this->togglerMultiple;
    }

    /**
     * Render the toggler to be displayed in the collapsible item.
     *
     * @throws InvalidArgumentException if the toggler tag is an empty string.
     *
     * @return string The HTML representation of the element.
     */
    public function renderToggler(): string
    {
        if ($this->togglerTag === '') {
            throw new InvalidArgumentException('Toggler tag cannot be empty string.');
        }

        $tagName = $this->togglerAsLink ? 'a' : $this->togglerTag;

        $togglerAttributes = $this->togglerAttributes;
        $togglerClasses = $this->togglerAttributes['class'] ?? 'btn btn-primary';

        unset($togglerAttributes['class']);

        return Html::tag($tagName, $this->togglerContent)
            ->attribute('type', $tagName === 'button' ? 'button' : null)
            ->attribute('data-bs-toggle', 'collapse')
            ->attribute('data-bs-target', $this->togglerMultiple ? '.multi-collapse' : '#' . $this->id)
            ->attribute('role', $this->togglerAsLink ? 'button' : null)
            ->attribute('aria-expanded', 'false')
            ->attribute('aria-controls', $this->togglerMultiple ? $this->ariaControls : $this->id)
            ->addClass($togglerClasses)
            ->addAttributes($togglerAttributes)
            ->render();
    }

    /**
     * Sets whether the toggler should be rendered as a link.
     *
     * @param bool $enabled Whether to render the toggler as a link.
     * When true, render as an `<a>` tag with `role="button"`.
     * When false, renders as the specified `togglerTag` (defaults to `button`).
     *
     * @return self A new instance with the specified toggler as link setting.
     */
    public function togglerAsLink(bool $enabled): self
    {
        $new = clone $this;
        $new->togglerAsLink = $enabled;

        return $new;
    }

    /**
     * Sets the HTML attributes for the toggler.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the toggler.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function togglerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->togglerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the content to be displayed in the toggler.
     *
     * @param string|Stringable $content The content to be displayed in the toggler.
     *
     * @return self A new instance with the specified content to be displayed in the toggler.
     *
     * Example usage:
     * ```php
     * Toggler::to()->togglerContent('Toggle collapse');
     * ```
     */
    public function togglerContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->togglerContent = (string) $content;

        return $new;
    }

    /**
     * Sets whether the toggler should control multiple collapse items.
     *
     * @param bool $enabled Whether the toggler should control multiple collapse items.
     * When true, the toggler will target all collapse items with class `.multi-collapse`.
     * When false, the toggler will only target the collapse item with the specified ID.
     *
     * @return self A new instance with the specified toggler multiple setting.
     *
     * Example usage:
     * ```php
     * Toggler::to()->togglerMultiple(true)->ariaControls('collapseOne collapseTwo');
     * ```
     */
    public function togglerMultiple(bool $enabled): self
    {
        $new = clone $this;
        $new->togglerMultiple = $enabled;

        return $new;
    }

    /**
     * Sets the tag name to be used to render the toggler.
     *
     * @param string $tag The tag name to be used to render the toggler.
     *
     * @throws InvalidArgumentException if the tag name is an empty string.
     *
     * @return self A new instance with the specified tag name to be used to render the toggler.
     *
     * Example usage:
     * ```php
     * Toggler::to()->togglerTag('a');
     * ```
     */
    public function togglerTag(string $tag): self
    {
        $new = clone $this;
        $new->togglerTag = $tag;

        return $new;
    }
}
