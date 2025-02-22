<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;

final class CollapseItem
{
    /**
     * Use {@see CollapseItem::to()} to create an instance.
     */
    private function __construct(
        private string $content,
        private string $togglerTag,
        private string $togglerContent,
        private bool $togglerAsLink,
        private string|bool $id,
        private array $attributes,
        private array $togglerAttributes,
        private bool $encode,
        private bool $togglerMultiple,
        private string $ariaControls,
    ) {
    }

    public static function to(
        string $content = '',
        string $togglerTag = 'button',
        string $togglerContent = '',
        bool $togglerAsLink = false,
        string|bool $id = true,
        array $attributes = [],
        array $togglerAttributes = [],
        bool $encode = true,
        bool $togglerMultiple = false,
        string $ariaControls = '',
    ): self {
        $new = new self(
            $content,
            $togglerTag,
            $togglerContent,
            $togglerAsLink,
            $id,
            $attributes,
            $togglerAttributes,
            $encode,
            $togglerMultiple,
            $ariaControls,
        );

        return $new->id($new->getId());
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
            true => $this->attributes['id'] ?? Html::generateId('collapse-'),
            '', false => throw new InvalidArgumentException('The "id" must be specified.'),
            default => $this->id,
        };
    }

    /**
     * Sets the ID.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
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
     * @return string The HTML representation of the element.
     */
    public function renderToggler(): string
    {
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
            ->render() . "\n";
    }

    /**
     * Sets the content to be displayed in the toggler.
     *
     * @param string|Stringable $togglerContent The content to be displayed in the toggler.
     *
     * @return self A new instance with the specified content to be displayed in the toggler.
     */
    public function togglerContent(string|Stringable $togglerContent): self
    {
        $new = clone $this;
        $new->togglerContent = $togglerContent;

        return $new;
    }

    public function togglerMultiple(bool $togglerMultiple): self
    {
        $new = clone $this;
        $new->togglerMultiple = $togglerMultiple;

        return $new;
    }

    /**
     * Sets the tag name to be used to render the toggler.
     *
     * @param string $togglerTag The tag name to be used to render the toggler.
     *
     * @return self A new instance with the specified tag name to be used to render the toggler.
     */
    public function togglerTag(string $togglerTag): self
    {
        $new = clone $this;
        $new->togglerTag = $togglerTag;

        return $new;
    }
}
