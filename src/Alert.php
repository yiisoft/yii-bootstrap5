<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_merge;

/**
 * Alert renders an alert bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Alert::widget()
 *     ->options([
 *         'class' => 'alert-info',
 *     ])
 *     ->body('Say hello...');
 * ```
 *
 * @link https://getbootstrap.com/docs/5.0/components/alerts/
 */
final class Alert extends Widget
{
    private string $body = '';
    private ?string $header = null;
    private array $headerOptions = [];
    /** @psalm-var non-empty-string */
    private string $headerTag = 'h4';
    private array $closeButton = [
        'class' => 'btn-close',
    ];
    /** @psalm-var non-empty-string */
    private string $closeButtonTag = 'button';
    private bool $closeButtonInside = true;
    private bool $encode = false;
    private array $options = [];
    private array $classNames = [];
    private bool $fade = false;

    public function getId(?string $suffix = '-alert'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    protected function run(): string
    {
        $options = $this->prepareOptions();
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        $content = Html::openTag($tag, $options);
        $content .= $this->renderHeader();
        $content .= $this->encode ? Html::encode($this->body) : $this->body;

        if ($this->closeButtonInside) {
            $content .= $this->renderCloseButton(false);
        }

        $content .= Html::closeTag($tag);

        return $content;
    }

    /**
     * The body content in the alert component. Alert widget will also be treated as the body content, and will be
     * rendered before this.
     *
     * @param string $value
     *
     * @return self
     */
    public function body(string $value): self
    {
        $new = clone $this;
        $new->body = $value;

        return $new;
    }

    /**
     * The header content in alert component
     *
     * @param string|null $header
     *
     * @return self
     */
    public function header(?string $header): self
    {
        $new = clone $this;
        $new->header = $header;

        return $new;
    }

    /**
     * The HTML attributes for the widget header tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $options
     *
     * @return self
     */
    public function headerOptions(array $options): self
    {
        $new = clone $this;
        $new->headerOptions = $options;

        return $new;
    }

    /**
     * Set tag name for header
     *
     * @param string $tag
     * @psalm-param non-empty-string $tag
     *
     * @return self
     */
    public function headerTag(string $tag): self
    {
        $new = clone $this;
        $new->headerTag = $tag;

        return $new;
    }

    /**
     * The options for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window. If {@see closeButtonEnabled} is false, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     *
     * Please refer to the [Alert documentation](http://getbootstrap.com/components/#alerts) for the supported HTML
     * attributes.
     *
     * @param array $value
     *
     * @return self
     */
    public function closeButton(array $value): self
    {
        $new = clone $this;
        $new->closeButton = $value;

        return $new;
    }

    /**
     * Disable close button.
     *
     * @param bool $value
     *
     * @return self
     */
    public function withoutCloseButton(bool $value = false): self
    {
        $new = clone $this;
        $new->closeButtonInside = $value;

        return $new;
    }

    /**
     * Set close button tag
     *
     * @param string $tag
     * @psalm-param non-empty-string $tag
     *
     * @return self
     */
    public function closeButtonTag(string $tag): self
    {
        $new = clone $this;
        $new->closeButtonTag = $tag;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Enable/Disable encode body
     *
     * @param bool $encode
     *
     * @return self
     */
    public function encode(bool $encode = true): self
    {
        $new = clone $this;
        $new->encode = $encode;

        return $new;
    }

    /**
     * Enable/Disable dissmiss animation
     *
     * @param bool $fade
     *
     * @return self
     */
    public function fade(bool $fade = true): self
    {
        $new = clone $this;
        $new->fade = $fade;

        return $new;
    }

    /**
     * Set type of alert, 'alert-success', 'alert-danger', 'custom-alert' etc
     *
     * @param string ...$classNames
     *
     * @return self
     */
    public function addClassNames(string ...$classNames): self
    {
        $new = clone $this;
        $new->classNames = array_filter($classNames, static fn ($name) => $name !== '');

        return $new;
    }

    /**
     * Short method for primary alert type
     *
     * @return self
     */
    public function primary(): self
    {
        return $this->addClassNames('alert-primary');
    }

    /**
     * Short method for secondary alert type
     *
     * @return self
     */
    public function secondary(): self
    {
        return $this->addClassNames('alert-secondary');
    }

    /**
     * Short method for success alert type
     *
     * @return self
     */
    public function success(): self
    {
        return $this->addClassNames('alert-success');
    }

    /**
     * Short method for danger alert type
     *
     * @return self
     */
    public function danger(): self
    {
        return $this->addClassNames('alert-danger');
    }

    /**
     * Short method for warning alert type
     *
     * @return self
     */
    public function warning(): self
    {
        return $this->addClassNames('alert-warning');
    }

    /**
     * Short method for info alert type
     *
     * @return self
     */
    public function info(): self
    {
        return $this->addClassNames('alert-info');
    }

    /**
     * Short method for light alert type
     *
     * @return self
     */
    public function light(): self
    {
        return $this->addClassNames('alert-light');
    }

    /**
     * Short method for dark alert type
     *
     * @return self
     */
    public function dark(): self
    {
        return $this->addClassNames('alert-dark');
    }

    /**
     * Renders the close button.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    public function renderCloseButton(bool $outside = true): ?string
    {
        $options = array_merge(
            $this->closeButton,
            [
                'aria-label' => 'Close',
                'data-bs-dismiss' => 'alert',
            ],
        );
        $label = ArrayHelper::remove($options, 'label', '');
        $encode = ArrayHelper::remove($options, 'encode', $this->encode);

        if ($this->closeButtonTag === 'button' && !isset($options['type'])) {
            $options['type'] = 'button';
        }

        if ($outside) {
            $options['data-bs-target'] = '#' . $this->getId();
        }

        return Html::tag($this->closeButtonTag, $label, $options)
            ->encode($encode)
            ->render();
    }

    /**
     * Render header tag
     *
     * @return string|null
     */
    private function renderHeader(): ?string
    {
        if ($this->header === null) {
            return null;
        }

        $options = $this->headerOptions;
        $encode = ArrayHelper::remove($options, 'encode', true);

        Html::addCssClass($options, ['alert-heading']);

        return Html::tag($this->headerTag, $this->header, $options)
            ->encode($encode)
            ->render();
    }

    /**
     * Prepare the widget options.
     *
     * This method returns the default values for various options.
     *
     * @return array
     */
    private function prepareOptions(): array
    {
        $options = $this->options;
        $options['id'] = $this->getId();
        $classNames = array_merge(['alert'], $this->classNames);

        if ($this->closeButtonInside) {
            $classNames[] = 'alert-dismissible';
        }

        if ($this->fade) {
            $classNames[] = 'fade show';
        }

        Html::addCssClass($options, $classNames);

        if (!isset($options['role'])) {
            $options['role'] = 'alert';
        }

        return $options;
    }
}
