<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
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
    use CloseButtonTrait;

    private string|Stringable $body = '';
    private ?string $header = null;
    private array $headerOptions = [];
    /** @psalm-var non-empty-string */
    private string $headerTag = 'h4';
    private bool $encode = false;
    private array $options = [];
    private array $classNames = [];
    private bool $fade = false;

    public function getId(?string $suffix = '-alert'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    protected function toggleComponent(): string
    {
        return 'alert';
    }

    public function render(): string
    {
        $options = $this->prepareOptions();
        $tag = ArrayHelper::remove($options, 'tag', 'div');

        return Html::tag($tag, '', $options)
            ->encode(false)
            ->content(
                (string) $this->renderHeader(),
                $this->encode ? Html::encode($this->body) : $this->body,
                (string) $this->renderCloseButton(true)
            )
            ->render();
    }

    /**
     * The body content in the alert component. Alert widget will also be treated as the body content, and will be
     * rendered before this.
     */
    public function body(string|Stringable $value): self
    {
        $new = clone $this;
        $new->body = $value;

        return $new;
    }

    /**
     * The header content in alert component
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
     * @psalm-param non-empty-string $tag
     */
    public function headerTag(string $tag): self
    {
        $new = clone $this;
        $new->headerTag = $tag;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Enable/Disable encode body
     */
    public function encode(bool $encode = true): self
    {
        $new = clone $this;
        $new->encode = $encode;

        return $new;
    }

    /**
     * Enable/Disable dissmiss animation
     */
    public function fade(bool $fade = true): self
    {
        $new = clone $this;
        $new->fade = $fade;

        return $new;
    }

    /**
     * Set type of alert, 'alert-success', 'alert-danger', 'custom-alert' etc
     */
    public function addClassNames(string ...$classNames): self
    {
        $new = clone $this;
        $new->classNames = array_filter($classNames, static fn ($name) => $name !== '');

        return $new;
    }

    /**
     * Short method for primary alert type
     */
    public function primary(): self
    {
        return $this->addClassNames('alert-primary');
    }

    /**
     * Short method for secondary alert type
     */
    public function secondary(): self
    {
        return $this->addClassNames('alert-secondary');
    }

    /**
     * Short method for success alert type
     */
    public function success(): self
    {
        return $this->addClassNames('alert-success');
    }

    /**
     * Short method for danger alert type
     */
    public function danger(): self
    {
        return $this->addClassNames('alert-danger');
    }

    /**
     * Short method for warning alert type
     */
    public function warning(): self
    {
        return $this->addClassNames('alert-warning');
    }

    /**
     * Short method for info alert type
     */
    public function info(): self
    {
        return $this->addClassNames('alert-info');
    }

    /**
     * Short method for light alert type
     */
    public function light(): self
    {
        return $this->addClassNames('alert-light');
    }

    /**
     * Short method for dark alert type
     */
    public function dark(): self
    {
        return $this->addClassNames('alert-dark');
    }

    /**
     * Render header tag
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
     */
    private function prepareOptions(): array
    {
        $options = $this->options;
        $options['id'] = $this->getId();
        $classNames = array_merge(['alert'], $this->classNames);

        if ($this->showCloseButton) {
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
