<?php

declare(strict_types=1);

namespace Yiisoft\Bootstrap5;

use BackedEnum;
use InvalidArgumentException;
use Stringable;
use Yiisoft\Bootstrap5\Utility\Responsive;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Widget\Widget;

/**
 * Modal renders a modal window that can be toggled by clicking on a trigger element.
 *
 * For example,
 *
 * ```php
 * echo Modal::widget()
 *     ->body(P::tag()->content('Modal body text goes here.'))
 *     ->footer(
 *         Button::tag()
 *             ->addClass('btn btn-secondary')
 *             ->attribute('data-bs-dismiss', 'modal')
 *             ->content('Close'),
 *         Button::tag()
 *             ->addClass('btn btn-primary')
 *             ->content('Save changes'),
 *     )
 *     ->fullScreen(ModalDialogFullScreen::FULL_SCREEN)
 *     ->id('modal')
 *     ->scrollable()
 *     ->title('Modal title')
 *     ->triggerButton()
 *     ->verticalCentered()
 *    ->render();
 * ```
 *
 * @link https://getbootstrap.com/docs/5.3/components/modal/
 */
final class Modal extends Widget
{
    private const CLASS_CLOSE_BUTTON = 'btn-close';
    private const NAME = 'modal';
    private const MODAL_BODY = 'modal-body';
    private const MODAL_CONTENT = 'modal-content';
    private const MODAL_DIALOG = 'modal-dialog';
    private const MODAL_FOOTER = 'modal-footer';
    private const MODAL_HEADER = 'modal-header';
    private const MODAL_TITLE = 'modal-title';
    private array $attributes = [];
    private string $body = '';
    private array $bodyAttributes = [];
    private array $closeButtonAttributes = [];
    private string $closeButtonLabel = '';
    private array $contentAttributes = [];
    private array $cssClasses = [];
    private array $dialogAttributes = [];
    private array $dialogClasses = [];
    private string $footer = '';
    private array $footerAttributes = [];
    private array $headerAttributes = [];
    private bool|string $id = true;
    private string $responsive = '';
    private string|Stringable $title = '';
    private string|Stringable $triggerButton = '';

    /**
     * Adds a set of attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names. e.g. `['id' => 'my-id']`.
     *
     * @return self A new instance with the specified attributes added.
     *
     * Example usage:
     * ```php
     * $modal->addAttributes(['data-id' => '123']);
     * ```
     */
    public function addAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = [...$this->attributes, ...$attributes];

        return $new;
    }

    /**
     * Adds one or more CSS classes to the existing classes.
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to add. Pass `null` to skip adding a class.
     *
     * @return self A new instance with the specified CSS classes added to existing ones.
     *
     * @link https://html.spec.whatwg.org/#classes
     *
     * Example usage:
     * ```php
     * $modal->addClass('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function addClass(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = [...$this->cssClasses, ...$class];

        return $new;
    }

    /**
     * Adds a CSS style.
     *
     * @param array|string $style The CSS style. If an array, the values will be separated by a space. If a string, it
     * will be added as is. For example, `color: red`. If the value is an array, the values will be separated by a
     * space. e.g., `['color' => 'red', 'font-weight' => 'bold']` will be rendered as `color: red; font-weight: bold;`.
     * @param bool $overwrite Whether to overwrite existing styles with the same name. If `false`, the new value will be
     * appended to the existing one.
     *
     * @return self A new instance with the specified CSS style value added.
     *
     * Example usage:
     * ```php
     * $modal->addCssStyle('color: red');
     *
     * // or
     * $modal->addCssStyle(['color' => 'red', 'font-weight' => 'bold']);
     * ```
     */
    public function addCssStyle(array|string $style, bool $overwrite = true): self
    {
        $new = clone $this;
        Html::addCssStyle($new->attributes, $style, $overwrite);

        return $new;
    }

    /**
     * Adds a sets attribute value.
     *
     * @param string $name The attribute name.
     * @param mixed $value The attribute value.
     *
     * @return self A new instance with the specified attribute added.
     *
     * Example usage:
     * ```php
     * $modal->attribute('data-id', '123');
     * ```
     */
    public function attribute(string $name, mixed $value): self
    {
        $new = clone $this;
        $new->attributes[$name] = $value;

        return $new;
    }

    /**
     * Sets the HTML attributes.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $modal->attributes(['data-id' => '123']);
     * ```
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;

        return $new;
    }

    /**
     * Sets the body content.
     *
     * @param string|Stringable ...$content The body content.
     *
     * @return self A new instance with the specified body content.
     *
     * Example usage:
     * ```php
     * $modal->body('Modal body');
     * ```
     */
    public function body(string|Stringable ...$content): self
    {
        $new = clone $this;
        $new->body = implode("\n", $content);

        return $new;
    }

    /**
     * Sets the HTML attributes for the body section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the body section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $modal->bodyAttributes(['class' => 'my-class']);
     * ```
     */
    public function bodyAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->bodyAttributes = $attributes;

        return $new;
    }

    /**
     * Replaces all existing CSS classes with the specified one(s).
     *
     * @param BackedEnum|string|null ...$class One or more CSS class names to set. Pass `null` to skip setting a class.
     *
     * @return self A new instance with the specified CSS classes set.
     *
     * Example usage:
     * ```php
     * $modal->class('custom-class', null, 'another-class', BackGroundColor::PRIMARY);
     * ```
     */
    public function class(BackedEnum|string|null ...$class): self
    {
        $new = clone $this;
        $new->cssClasses = $class;

        return $new;
    }

    /**
     * Sets the HTML attributes for the close button.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the close button.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $modal->closeButtonAttributes(['data-id' => '123']);
     * ```
     */
    public function closeButtonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->closeButtonAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the label for the close button.
     *
     * @param string $label The label for the close button.
     *
     * @return self A new instance with the specified close button label.
     *
     * Example usage:
     * ```php
     * $modal->closeButtonLabel('Close');
     * ```
     */
    public function closeButtonLabel(string $label): self
    {
        $new = clone $this;
        $new->closeButtonLabel = $label;

        return $new;
    }

    /**
     * Sets the HTML attributes for the content section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the content section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $modal->contentAttributes(['class' => 'my-class']);
     * ```
     */
    public function contentAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->contentAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the HTML attributes for the dialog section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the dialog section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $modal->dialogAttributes(['class' => 'my-class']);
     * ```
     */
    public function dialogAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->dialogAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the footer content.
     *
     * @param string|Stringable ...$content The footer content.
     *
     * @return self A new instance with the specified footer content.
     *
     * Example usage:
     * ```php
     * $modal->footer('Modal footer');
     * ```
     */
    public function footer(string|Stringable ...$content): self
    {
        $new = clone $this;
        $new->footer = implode("\n", $content);

        return $new;
    }

    /**
     * Sets the HTML attributes for the footer section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the footer section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $modal->footerAttributes(['class' => 'my-class']);
     * ```
     */
    public function footerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->footerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the fullscreen dialog.
     *
     * @param ModalDialogFullScreenSize $size The fullscreen dialog.
     *
     * @return self A new instance with the specified fullscreen dialog.
     */
    public function fullscreen(ModalDialogFullScreenSize $size): self
    {
        $new = clone $this;
        $new->dialogClasses[] = $size->value;

        return $new;
    }

    /**
     * Sets the HTML attributes for the header section.
     *
     * @param array $attributes Attribute values indexed by attribute names.
     *
     * @return self A new instance with the specified attributes for the header section.
     *
     * @see {\Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * Example usage:
     * ```php
     * $modal->headerAttributes(['class' => 'my-class']);
     * ```
     */
    public function headerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->headerAttributes = $attributes;

        return $new;
    }

    /**
     * Sets the ID.
     *
     * @param bool|string $id The ID of the component. If `true`, an ID will be generated automatically.
     *
     * @return self A new instance with the specified ID.
     *
     * Example usage:
     * ```php
     * $alert->id('my-id');
     * ```
     */
    public function id(bool|string $id): self
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * Sets the responsive size.
     *
     * @param Responsive $size The responsive size.
     *
     * @return self A new instance with the specified responsive size setting.
     */
    public function responsive(Responsive $size): self
    {
        $new = clone $this;
        $new->responsive = $size->value;

        return $new;
    }

    /**
     * Sets the scrollable dialog.
     *
     * @return self A new instance with the scrollable dialog.
     */
    public function scrollable(): self
    {
        $new = clone $this;
        $new->dialogClasses[] = 'modal-dialog-scrollable';

        return $new;
    }

    /**
     * Sets the title.
     *
     * @param string|Stringable $content The title.
     * @param string $tag The tag to use for the title. Default is `H5`.
     * @param array $attributes The HTML attributes for the title.
     *
     * @return self A new instance with the specified title.
     *
     * Example usage:
     * ```php
     * $modal->title('Modal Title');
     * ```
     */
    public function title(string|Stringable $content, string $tag = 'H5', array $attributes = []): self
    {
        if ($tag === '') {
            throw new InvalidArgumentException('The tag for the title cannot be an empty string.');
        }

        if (is_string($content)) {
            $id = $this->getId();
            $classes = $attributes['class'] ?? null;

            unset($attributes['class']);

            $content = Html::tag($tag)
                ->addAttributes($attributes)
                ->addClass(
                    self::MODAL_TITLE,
                    $classes,
                )
                ->content($content)
                ->id($id !== null ? $id . 'Label' : null)
                ->render();
        }

        $new = clone $this;
        $new->title = $content;

        return $new;
    }

    /**
     * Sets the trigger button.
     *
     * @param string|Stringable $content The content of the trigger button.
     * @param bool $staticBackdrop Whether to use a static backdrop or not.
     * @param array $attributes The HTML attributes for the trigger button.
     *
     * @return self A new instance with the specified trigger button.
     *
     * Example usage:
     * ```php
     * $modal->triggerButton('Launch Modal');
     * ```
     *
     * Note: Setting `aria-hidden="true"` may cause accessibility errors in some modern browsers (for example,
     * Chrome Beta/Canary) when the modal is closed, due to focus management issues during the fade transition.
     * If this occurs, set `$ariaHidden` to `false` and manage the attribute via JavaScript, for example, by updating
     * it after the `hidden.bs.modal` event.
     *
     * @link https://github.com/twbs/bootstrap/issues/41005 for details.
     *
     * ```php
     * <script>
     * <!-- Script to remove aria-hidden -->
     * document.addEventListener('hide.bs.modal', (event) => {
     *     const modal = event.target;
     *     modal.removeAttribute('aria-hidden');
     * });
     * </script>
     * ```
     */
    public function triggerButton(
        string|Stringable $content = 'Launch modal',
        bool $staticBackdrop = false,
        array $attributes = [],
        bool $ariaHidden = true,
    ): self {
        $new = $this->id($this->getId() ?? '');

        if (is_string($content)) {
            $classes = $attributes['class'] ?? 'btn btn-primary';

            unset($attributes['class']);

            $content = Button::button($content)
                ->addAttributes($attributes)
                ->addClass($classes)
                ->attribute('data-bs-toggle', 'modal')
                ->attribute('data-bs-target', '#' . $new->id)
                ->render() . "\n";
        }

        $new = clone $this;
        $new->triggerButton = $content;

        if ($staticBackdrop) {
            $new = $new->attribute('data-bs-backdrop', 'static')->attribute('data-bs-keyboard', 'false');
        }

        $new = $new->addClass('fade')->attribute('aria-labelledby', $new->id . 'Label');

        if ($ariaHidden) {
            $new = $new->attribute('aria-hidden', 'true');
        }

        return $new;
    }

    public function verticalCentered(): self
    {
        $new = clone $this;
        $new->dialogClasses[] = 'modal-dialog-centered';

        return $new;
    }

    /**
     * Run the widget.
     *
     * @return string The HTML representation of the element.
     */
    public function render(): string
    {
        $attributes = $this->attributes;
        $classes = $attributes['class'] ?? null;

        unset($attributes['class']);

        if ($this->triggerButton === '') {
            throw new InvalidArgumentException('Set the trigger button before rendering the modal.');
        }

        $modal = Div::tag()
            ->addAttributes($attributes)
            ->addClass(
                self::NAME,
                ...$this->cssClasses,
            )
            ->addClass($classes)
            ->attribute('tabindex', '-1')
            ->content(
                "\n",
                $this->renderDialog(),
                "\n",
            )
            ->encode(false)
            ->id($this->getId())
            ->render();


        return $this->triggerButton . $modal;
    }

    /**
     * Generates the ID.
     *
     * @return string|null The generated ID.
     *
     * @psalm-return non-empty-string|null The generated ID.
     */
    private function getId(): string|null
    {
        return match ($this->id) {
            true => $this->attributes['id'] ?? Html::generateId(self::NAME . '-'),
            '', false => throw new InvalidArgumentException('The "id" must be specified.'),
            default => $this->id,
        };
    }

    private function renderBody(): string
    {
        $bodyAttributes = $this->bodyAttributes;
        $bodyClasses = $bodyAttributes['class'] ?? null;

        unset($bodyAttributes['class']);

        return Div::tag()
            ->addAttributes($bodyAttributes)
            ->addClass(
                self::MODAL_BODY,
                $bodyClasses,
            )
            ->content(
                "\n",
                $this->body !== '' ? $this->body . "\n" : '',
            )
            ->encode(false)
            ->render();
    }

    private function renderContent(): string
    {
        $contentAttributes = $this->contentAttributes;
        $contentClasses = $contentAttributes['class'] ?? null;

        unset($contentAttributes['class']);

        Html::addCssClass($contentAttributes, [self::MODAL_CONTENT, $contentClasses]);

        return Div::tag()
            ->addAttributes($contentAttributes)
            ->addClass(
                self::MODAL_CONTENT,
                $contentClasses,
            )
            ->content(
                "\n",
                $this->renderHeader(),
                "\n",
                $this->renderBody(),
                "\n",
                $this->renderFooter(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    private function renderDialog(): string
    {
        $dialogAttributes = $this->dialogAttributes;
        $dialogClasses = $dialogAttributes['class'] ?? null;

        unset($dialogAttributes['class']);

        return Div::tag()
            ->addAttributes($dialogAttributes)
            ->addClass(
                self::MODAL_DIALOG,
                $this->responsive !== '' ? self::NAME . '-' . $this->responsive : null,
                $dialogClasses,
                ...$this->dialogClasses,
            )
            ->content(
                "\n",
                $this->renderContent(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    private function renderHeader(): string
    {
        $headerAttributes = $this->headerAttributes;
        $headerClasses = $headerAttributes['class'] ?? null;

        unset($headerAttributes['class']);

        return Div::tag()
            ->addAttributes($headerAttributes)
            ->addClass(
                self::MODAL_HEADER,
                $headerClasses,
            )
            ->content(
                "\n",
                $this->title !== '' ? $this->title . "\n" : '',
                $this->renderToggler(),
                "\n",
            )
            ->encode(false)
            ->render();
    }

    private function renderFooter(): string
    {
        $footerAttributes = $this->footerAttributes;
        $footerClasses = $footerAttributes['class'] ?? null;

        unset($footerAttributes['class']);

        return Div::tag()
            ->addAttributes($footerAttributes)
            ->addClass(
                self::MODAL_FOOTER,
                $footerClasses,
            )
            ->content(
                "\n",
                $this->footer !== '' ? $this->footer . "\n" : '',
            )
            ->encode(false)
            ->render();
    }

    /**
     * Renders the toggler.
     *
     * @throws InvalidArgumentException If the close button tag is an empty string.
     *
     * @return string The HTML representation of the element.
     */
    private function renderToggler(): string
    {
        $buttonTag = Button::button($this->closeButtonLabel);

        $closeButtonAttributes = $this->closeButtonAttributes;
        $classesButton = $closeButtonAttributes['class'] ?? null;

        unset($closeButtonAttributes['class']);

        $buttonTag = $buttonTag
            ->addClass(self::CLASS_CLOSE_BUTTON, $classesButton)
            ->addAttributes($closeButtonAttributes);

        if (array_key_exists('data-bs-dismiss', $closeButtonAttributes) === false) {
            $buttonTag = $buttonTag->attribute('data-bs-dismiss', 'modal');
        }

        if (array_key_exists('aria-label', $closeButtonAttributes) === false) {
            $buttonTag = $buttonTag->attribute('aria-label', 'Close');
        }

        return $buttonTag->render();
    }
}
