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
    public const TYPE_PRIMARY = 'alert-primary';
    public const TYPE_SECONDARY = 'alert-secondary';
    public const TYPE_SUCCESS = 'alert-success';
    public const TYPE_DANGER = 'alert-danger';
    public const TYPE_WARNING = 'alert-warning';
    public const TYPE_INFO = 'alert-info';
    public const TYPE_LIGHT = 'alert-light';
    public const TYPE_DARK = 'alert-dark';

    private string $body = '';
    private ?string $header = null;
    private array $headerOptions = [];
    private ?array $closeButton = [
        'class' => 'btn-close',
    ];
    private bool $encode = false;
    private array $options = [];
    private ?string $type = null;
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
        $content .= $this->renderCloseButton();
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
    public function closeButton(?array $value): self
    {
        $new = clone $this;
        $new->closeButton = $value;

        return $new;
    }

    /**
     * Disable close button.
     *
     * @return self
     */
    public function withoutCloseButton(): self
    {
        return $this->closeButton(null);
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
     * Set type of alert, 'alert-success', 'alert-danger' etc
     *
     * @param string $type
     *
     * @return self
     */
    public function type(string $type): self
    {
        $new = clone $this;
        $new->type = $type;

        return $new;
    }

    /**
     * Short method for primary alert type
     *
     * @return self
     */
    public function primary(): self
    {
        return $this->type(self::TYPE_PRIMARY);
    }

    /**
     * Short method for secondary alert type
     *
     * @return self
     */
    public function secondary(): self
    {
        return $this->type(self::TYPE_SECONDARY);
    }

    /**
     * Short method for success alert type
     *
     * @return self
     */
    public function success(): self
    {
        return $this->type(self::TYPE_SUCCESS);
    }

    /**
     * Short method for danger alert type
     *
     * @return self
     */
    public function danger(): self
    {
        return $this->type(self::TYPE_DANGER);
    }

    /**
     * Short method for warning alert type
     *
     * @return self
     */
    public function warning(): self
    {
        return $this->type(self::TYPE_WARNING);
    }

    /**
     * Short method for info alert type
     *
     * @return self
     */
    public function info(): self
    {
        return $this->type(self::TYPE_INFO);
    }

    /**
     * Short method for light alert type
     *
     * @return self
     */
    public function light(): self
    {
        return $this->type(self::TYPE_LIGHT);
    }

    /**
     * Short method for dark alert type
     *
     * @return self
     */
    public function dark(): self
    {
        return $this->type(self::TYPE_DARK);
    }

    /**
     * Renders the close button.
     *
     * @throws JsonException
     *
     * @return string the rendering result
     */
    public function renderCloseButton(bool $outside = false): ?string
    {
        if ($this->closeButton === null) {
            return null;
        }

        $options = array_merge(
            $this->closeButton,
            [
                'aria-label' => 'Close',
                'data-bs-dismiss' => 'alert',
            ],
        );
        $tag = ArrayHelper::remove($options, 'tag', 'button');
        $label = ArrayHelper::remove($options, 'label', '');
        $encode = ArrayHelper::remove($options, 'encode', $this->encode);

        if ($tag === 'button' && !isset($options['type'])) {
            $options['type'] = 'button';
        }

        if ($outside) {
            $options['data-bs-target'] = '#' . $this->getId();
        }

        return Html::tag($tag, $label, $options)->encode($encode)->render();
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
        $tag = ArrayHelper::remove($options, 'tag', 'h4');
        $encode = ArrayHelper::remove($options, 'encode', true);

        Html::addCssClass($options, ['alert-heading']);

        return Html::tag($tag, $this->header, $options)->encode($encode)->render();
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
        $classNames = ['widget' => 'alert'];

        if ($this->type) {
            $classNames[] = $this->type;
        }

        if ($this->closeButton !== null) {
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
