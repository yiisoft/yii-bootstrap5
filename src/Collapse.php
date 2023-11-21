<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_key_exists;

/**
 * Collapse renders an collapse bootstrap JavaScript component.
 *
 * For example
 *
 * $collapse =Collapse::widget()
 *      ->withTitle('Foo')
 *      ->withContent('Bar');
 *
 * echo $collapse->render();
 *
 * Or
 *
 * $collapse = $collapse->withToggle(false);
 *
 * echo '<p>' . $collapse->renderToggle() . '</p><div>Some other content</div>' . $collapse->render();
 */
final class Collapse extends AbstractToggleWidget
{
    private array $options = [];
    private array $bodyOptions = [
        'tag' => 'div',
    ];
    private string|Stringable $content = '';
    private bool $horizontal = false;
    private bool $collapsed = false;
    private ?string $tagName = null;

    public function getId(?string $suffix = '-collapse'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    protected function toggleComponent(): string
    {
        return 'collapse';
    }

    public function withOptions(array $options): self
    {
        $new = clone $this;
        $new->options = $options;

        return $new;
    }

    public function withBodyOptions(array $options): self
    {
        $new = clone $this;
        $new->bodyOptions = $options;

        if (!array_key_exists('tag', $options)) {
            $new->bodyOptions['tag'] = 'div';
        }

        return $new;
    }

    public function withContent(string|Stringable $content): self
    {
        $new = clone $this;
        $new->content = $content;

        return $new;
    }

    public function withHorizontal(bool $horizontal): self
    {
        $new = clone $this;
        $new->horizontal = $horizontal;

        return $new;
    }

    public function withCollapsed(bool $collapsed): self
    {
        $new = clone $this;
        $new->collapsed = $collapsed;

        return $new;
    }

    private function prepareOptions(): array
    {
        $options = $this->options;
        $options['id'] = $this->getId();

        $classNames = [
            'widget' => 'collapse',
        ];

        if ($this->horizontal) {
            $classNames[] = 'collapse-horizontal';
        }

        if ($this->collapsed) {
            $classNames[] = 'show';
        }

        Html::addCssClass($options, $classNames);

        return $options;
    }

    private function prepareBodyOptions(): array
    {
        $options = $this->bodyOptions;
        Html::addCssClass($options, ['widget' => 'card card-body']);

        return $options;
    }

    protected function prepareToggleOptions(): array
    {
        [$tagName, $options, $encode] = parent::prepareToggleOptions();

        $options['aria-expanded'] = $this->collapsed ? 'true' : 'false';

        return [$tagName, $options, $encode];
    }

    public function begin(): ?string
    {
        parent::begin();

        $options = $this->prepareOptions();
        $bodyOptions = $this->prepareBodyOptions();
        $this->tagName = ArrayHelper::remove($options, 'tag', 'div');
        $html = $this->renderToggle ? $this->renderToggle() : '';
        $html .= Html::openTag($this->tagName, $options);

        if ($bodyTag = ArrayHelper::remove($bodyOptions, 'tag')) {
            $html .= Html::openTag($bodyTag, $bodyOptions);
        }

        return $html;
    }

    /**
     * @inheritDoc
     */
    public function render(): string
    {
        if ($tagName = $this->tagName) {
            $this->tagName = null;

            if (isset($this->bodyOptions['tag'])) {
                return Html::closeTag($this->bodyOptions['tag']) . Html::closeTag($tagName);
            }

            return Html::closeTag($tagName);
        }

        if ($this->renderToggle) {
            return $this->renderToggle() . $this->renderCollapse();
        }

        return $this->renderCollapse();
    }

    private function renderCollapse(): string
    {
        $options = $this->prepareOptions();
        $tagName = ArrayHelper::remove($options, 'tag', 'div');

        return Html::tag($tagName, $this->renderBody(), $options)
            ->encode(false)
            ->render();
    }

    private function renderBody(): string
    {
        $options = $this->prepareBodyOptions();
        $tagName = ArrayHelper::remove($options, 'tag', 'div');
        $encode = ArrayHelper::remove($options, 'encode');

        if ($tagName === null) {
            return $encode ? Html::encode($this->content) : (string) $this->content;
        }

        return Html::tag($tagName, $this->content, $options)
            ->encode($encode)
            ->render();
    }
}
