<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;

trait CloseButtonTrait
{
    private array $closeButtonOptions = [];
    private string|Stringable $closeButtonLabel = '';
    private bool $encodeCloseButton = true;
    private bool $showCloseButton = true;


    abstract protected function toggleComponent(): string;

    abstract public function getId(): ?string;

    /**
     * The HTML attributes for the widget close button tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function withCloseButtonOptions(array $options): static
    {
        $new = clone $this;
        $new->closeButtonOptions = $options;

        return $new;
    }

    /**
     * Disable close button.
     */
    public function withoutCloseButton(): static
    {
        $new = clone $this;
        $new->showCloseButton = false;

        return $new;
    }

    public function withCloseButton(): static
    {
        $new = clone $this;
        $new->showCloseButton = true;

        return $new;
    }

    public function withCloseButtonLabel(string|Stringable $label): static
    {
        $new = clone $this;
        $new->closeButtonLabel = $label;

        return $new;
    }

    public function withEncodeCloseButton(bool $encode): static
    {
        $new = clone $this;
        $new->encodeCloseButton = $encode;

        return $new;
    }

    public function renderCloseButton(bool $inside = false): ?Tag
    {
        if ($inside && $this->showCloseButton === false) {
            return null;
        }

        $options = $this->closeButtonOptions;
        $tagName = ArrayHelper::remove($options, 'tag', 'button');

        Html::addCssClass($options, ['widget' => 'btn-close']);

        $label = (string) $this->closeButtonLabel;
        $options['data-bs-dismiss'] = $this->toggleComponent();

        if (!$inside) {
            $options['data-bs-target'] = '#' . $this->getId();
        }

        if (empty($label) && !isset($options['aria-label']) && !isset($options['aria']['label'])) {
            $options['aria-label'] = 'Close';
        }

        if ($tagName !== 'button') {
            $options['role'] = 'button';
        } elseif (!isset($options['type'])) {
            $options['type'] = 'button';
        }

        return Html::tag($tagName, $label, $options)
            ->encode($this->encodeCloseButton);
    }
}
