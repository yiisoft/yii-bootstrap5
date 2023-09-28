<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;

abstract class AbstractCloseButtonWidget extends AbstractToggleWidget
{
    protected ?array $closeButtonOptions = [];
    protected string|Stringable $closeButtonLabel = '';
    protected bool $encodeCloseButton = true;

    /**
     * The HTML attributes for the widget close button tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function withCloseButtonOptions(?array $options): static
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
        return $this->withCloseButtonOptions(null);
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

    public function renderCloseButton(): ?Tag
    {
        $options = $this->closeButtonOptions;

        if ($options === null) {
            return null;
        }

        $tagName = ArrayHelper::remove($options, 'tag', 'button');

        Html::addCssClass($options, ['widget' => 'btn-close']);

        $label = (string) $this->closeButtonLabel;
        $options['data-bs-dismiss'] = $this->toggleComponent();

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
