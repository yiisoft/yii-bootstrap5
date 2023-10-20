<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

final class Offcanvas extends AbstractCloseButtonWidget
{
    public const PLACEMENT_TOP = 'offcanvas-top';
    public const PLACEMENT_END = 'offcanvas-end';
    public const PLACEMENT_BOTTOM = 'offcanvas-bottom';
    public const PLACEMENT_START = 'offcanvas-start';

    private array $options = [];
    private array $headerOptions = [];
    private array $titleOptions = [];
    private array $bodyOptions = [];
    private ?string $title = null;
    private string $placement = self::PLACEMENT_START;
    private bool $scroll = false;
    private bool $withoutBackdrop = false;
    protected bool $renderToggle = false;

    public function getId(?string $suffix = '-offcanvas'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    protected function toggleComponent(): string
    {
        return 'offcanvas';
    }

    /**
     * Enable/disable body scroll when offcanvas show
     *
     * @link https://getbootstrap.com/docs/5.1/components/offcanvas/#backdrop
     */
    public function scroll(bool $scroll = true): self
    {
        $new = clone $this;
        $new->scroll = $scroll;

        return $new;
    }

    /**
     * Enable/disable offcanvas backdrop
     *
     * @link https://getbootstrap.com/docs/5.1/components/offcanvas/#backdrop
     */
    public function withoutBackdrop(bool $withoutBackdrop = true): self
    {
        $new = clone $this;
        $new->withoutBackdrop = $withoutBackdrop;

        return $new;
    }

    /**
     * Set placement for opened offcanvas
     *
     * @link https://getbootstrap.com/docs/5.1/components/offcanvas/#placement
     */
    public function placement(string $placement): self
    {
        $new = clone $this;
        $new->placement = $placement;

        return $new;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $options): self
    {
        $new = clone $this;
        $new->options = $options;

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
     * Set/remove offcanvas title
     */
    public function title(?string $title): self
    {
        $new = clone $this;
        $new->title = $title;

        return $new;
    }

    /**
     * The HTML attributes for the widget title tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function titleOptions(array $options): self
    {
        $new = clone $this;
        $new->titleOptions = $options;

        return $new;
    }

    /**
     * The HTML attributes for the widget body tag. The following special options are recognized.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function bodyOptions(array $options): self
    {
        $new = clone $this;
        $new->bodyOptions = $options;

        return $new;
    }

    public function begin(): string
    {
        parent::begin();

        $options = $this->options;
        $bodyOptions = $this->bodyOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        $bodyTag = ArrayHelper::remove($bodyOptions, 'tag', 'div');

        Html::addCssClass($options, ['widget' => 'offcanvas', 'placement' => $this->placement]);
        Html::addCssClass($bodyOptions, ['widget' => 'offcanvas-body']);

        $options['id'] = $this->getId();
        $options['tabindex'] = -1;

        if (!empty($this->title)) {
            if (isset($this->titleOptions['id'])) {
                $options['aria-labelledby'] = $this->titleOptions['id'];
            } elseif ($options['id']) {
                $options['aria-labelledby'] = $options['id'] . '-title';
            }
        }

        if ($this->scroll) {
            $options['data-bs-scroll'] = 'true';
        }

        if ($this->withoutBackdrop) {
            $options['data-bs-backdrop'] = 'false';
        }

        if ($this->theme) {
            $options['data-bs-theme'] = $this->theme;
        }

        $html = $this->renderToggle ? $this->renderToggle() : '';
        $html .= Html::openTag($tag, $options);
        $html .= $this->renderHeader();
        $html .= Html::openTag($bodyTag, $bodyOptions);

        return $html;
    }

    public function render(): string
    {
        $tag = $this->options['tag'] ?? 'div';
        $bodyTag = $this->bodyOptions['tag'] ?? 'div';

        return Html::closeTag($bodyTag) . Html::closeTag($tag);
    }

    /**
     * Renders offcanvas header.
     *
     * @return string the rendering header.
     */
    private function renderHeader(): string
    {
        $options = $this->headerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'header');

        Html::addCssClass($options, ['widget' => 'offcanvas-header']);

        $title = (string) $this->renderTitle();
        $closeButton = $this->renderCloseButton();

        return Html::tag($tag, $title . $closeButton, $options)
            ->encode(false)
            ->render();
    }

    /**
     * Renders offcanvas title.
     *
     * @return string|null the rendering header.
     */
    private function renderTitle(): ?string
    {
        if ($this->title === null) {
            return null;
        }

        $options = $this->titleOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'h5');
        $encode = ArrayHelper::remove($options, 'encode');

        Html::addCssClass($options, ['offcanvas-title']);

        if (!isset($options['id']) && $id = $this->getId()) {
            $options['id'] = $id . '-title';
        }

        return Html::tag($tag, $this->title, $options)
            ->encode($encode)
            ->render();
    }
}
