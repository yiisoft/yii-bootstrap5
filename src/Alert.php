<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Stringable;
use Yiisoft\Html\Html;

use function preg_replace;
use function strtr;

/**
 * Alert renders an alert bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Alert::widget()->body('Say hello...')->type(Type::PRIMARY)->render();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.0/components/alerts/
 */
final class Alert extends \Yiisoft\Widget\Widget
{
    private const NAME = 'alert';
    private array $addClasses = [];
    private array $attributes = [];
    private string|Stringable $body = '';
    private bool $dismissable = false;
    private bool $generateId = true;
    private string|null $header = null;
    private array $headerAttributes = [];
    private string $headerTag = 'h4';
    private string|null $id = null;
    private string $templateContent = "\n{header}\n{body}\n{toggle}\n";
    private string $template = '{widget}';
    private array $toggleAttributes = [];
    private bool $toggleLink = false;

    /**
     * Sets the CSS class attribute for the alert component.
     *
     * @param string $value The CSS class for the alert component (e.g., 'alert-primary', 'alert-danger').
     *
     * @return self A new instance of the current class with the specified class value.
     *
     * @link https://html.spec.whatwg.org/#classes
     */
    public function addClass(string $value): self
    {
        $new = clone $this;
        $new->addClasses[] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the alert component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance of the current class with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function attributes(array $values): self
    {
        $new = clone $this;
        $new->attributes = $values;

        return $new;
    }

    /**
     * Sets the body content of the alert component.
     *
     * @param string|Stringable $value The body content of the alert component.
     * @param bool $encode Whether the body value should be HTML-encoded. Use this when rendering user-generated content
     * to prevent XSS attacks.
     *
     * @return self A new instance of the current class with the specified body content.
     */
    public function body(string|Stringable $value, bool $encode = true): self
    {
        if ($encode === true) {
            $value = Html::encode($value);
        }

        $new = clone $this;
        $new->body = $value;

        return $new;
    }

    /**
     * Makes the alert dismissible by adding a close button.
     *
     * @return self A new instance of the current class with dismissible added.
     */
    public function dismissable(): self
    {
        $new = clone $this;
        $new->dismissable = true;
        $new->addClasses[] = 'alert-dismissible';

        return $new;
    }

    /**
     * Adds a fade effect to the alert.
     *
     * @return self A new instance of the current class with the fade effect added.
     */
    public function fade(): self
    {
        $new = clone $this;
        $new->addClasses[] = 'fade show';

        return $new;
    }

    /**
     * Sets whether to generate an ID for the alert component.
     *
     * @param bool $value If true, an ID will be automatically generated for the widget.
     *
     * @return self A new instance of the current class with the specified generate ID setting.
     */
    public function generateId(bool $value): self
    {
        $new = clone $this;
        $new->generateId = $value;

        return $new;
    }

    /**
     * Sets the header content of the alert component.
     *
     * @param string|null $value The header content of the alert component.
     * @param bool $encode Whether the body value should be HTML-encoded. Use this when rendering user-generated content
     * to prevent XSS attacks.
     *
     * @return self A new instance of the current class with the specified header content.
     */
    public function header(string|null $value, bool $encode = true): self
    {
        if ($encode === true) {
            $value = Html::encode($value);
        }

        $new = clone $this;
        $new->header = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the header tag in the alert component.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self A new instance of the current class with the specified header attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $values): self
    {
        $new = clone $this;
        $new->headerAttributes = $values;

        return $new;
    }

    /**
     * Sets the HTML tag to be used for the header.
     *
     * @param string $value The HTML tag name for the header.
     *
     * @return self A new instance of the current class with the specified header tag.
     */
    public function headerTag(string $value): self
    {
        $new = clone $this;
        $new->headerTag = $value;

        return $new;
    }

    /**
     * Sets the ID of the alert component.
     *
     * @param string|null $value The ID to be set.
     *
     * @return self A new instance of the current class with the specified ID.
     */
    public function id(string|null $value): self
    {
        $new = clone $this;
        $new->id = $value;

        return $new;
    }

    /**
     * Sets the template to be used for rendering the alert component.
     *
     * @param string $value The template string.
     *
     * @return self A new instance of the current class with the specified template.
     */
    public function template(string $value): self
    {
        $new = clone $this;
        $new->template = $value;

        return $new;
    }

    /**
     * Sets the template content to be used for rendering the alert component.
     *
     * @param string $value The template content string.
     *
     * @return self A new instance of the current class with the specified template content.
     */
    public function templateContent(string $value): self
    {
        $new = clone $this;
        $new->templateContent = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the toggle component in the alert.
     *
     * @param array $value Attribute values indexed by attribute names.
     *
     * @return self A new instance of the current class with the specified toggle attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function toggleAttributes(array $value): self
    {
        $new = clone $this;
        $new->toggleAttributes = $value;

        return $new;
    }

    /**
     * Sets the toggle component to be rendered as a link instead of a button.
     *
     * @return self A new instance of the current class with the toggle set as a link.
     */
    public function toggleLink(): self
    {
        $new = clone $this;
        $new->toggleLink = true;

        return $new;
    }

    /**
     * Set the alert type. The following options are allowed:
     * - `Type::PRIMARY`: Primary alert.
     * - `Type::SECONDARY`: Secondary alert.
     * - `Type::SUCCESS`: Success alert.
     * - `Type::DANGER`: Danger alert.
     * - `Type::WARNING`: Warning alert.
     * - `Type::INFO`: Info alert.
     * - `Type::LIGHT`: Light alert.
     * - `Type::DARK`: Dark alert.
     *
     * @param AlertType $value The alert type.
     *
     * @return self A new instance of the current class with the specified alert type.
     */
    public function type(AlertType $value): self
    {
        $new = clone $this;
        $new->addClasses[] = $value->value;

        return $new;
    }

    /**
     * Run the alert widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $attributes['role'] = self::NAME;
        $content = '';
        $id = $this->id;
        $toggle = '';

        Html::addCssClass($attributes, ['widget' => self::NAME] + $this->addClasses);

        if ($this->dismissable) {
            $toggle = Toggle::widget()->attributes($this->toggleAttributes)->type(ToggleType::TYPE_DISMISS);

            if ($this->toggleLink) {
                $toggle = $toggle->link();
            }
        }

        $content = strtr(
            $this->templateContent,
            [
                '{header}' => $this->renderHeader(),
                '{body}' => $this->body,
                '{toggle}' => $toggle,
            ]
        );

        $content = preg_replace("/\n{2}/", "\n", $content);

        $alert = Html::normalTag('div', $content, $attributes)->encode(false)->id($id)->render();

        if ($this->generateId) {
            $id = $this->id ?? Html::generateId(self::NAME . '-');
        }

        return strtr(
            $this->template,
            [
                '{toggle}' => $toggle,
                '{widget}' => $alert,
            ]
        );
    }

    /**
     * Render header tag.
     *
     * @throws InvalidArgumentException if the header tag is an empty string.
     *
     * @return string The rendered header tag. Empty string if header is not set.
     */
    private function renderHeader(): string
    {
        if ($this->header === null) {
            return '';
        }

        $headerAttributes = $this->headerAttributes;

        Html::addCssClass($headerAttributes, 'alert-heading');

        if ($this->headerTag === '') {
            throw new InvalidArgumentException('Tag cannot be empty string.');
        }

        return Html::tag($this->headerTag, '', $headerAttributes)->content($this->header)->encode(false)->render();
    }
}
