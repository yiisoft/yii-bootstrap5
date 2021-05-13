<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use JsonException;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_key_exists;
use function implode;
use function is_array;
use function strtr;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 * echo Breadcrumbs::widget()
 *     ->links(['label' => !empty($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]);
 * ```
 */
final class Breadcrumbs extends Widget
{
    private string $tag = 'ol';
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private array $homeLink = [];
    private array $links = [];
    private string $itemTemplate = "<li class=\"breadcrumb-item\">{link}</li>\n";
    private string $activeItemTemplate = "<li class=\"breadcrumb-item active\" aria-current=\"page\">{link}</li>\n";
    private array $navOptions = ['aria-label' => 'breadcrumb'];
    private array $options = [];

    protected function run(): string
    {
        if (empty($this->links)) {
            return '';
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-breadcrumb";
        }

        /** @psalm-suppress InvalidArgument */
        Html::addCssClass($this->options, ['widget' => 'breadcrumb']);

        $links = [];

        if ($this->homeLink === []) {
            $links[] = $this->renderItem([
                'label' => 'Home',
                'url' => '/',
            ], $this->itemTemplate);
        } else {
            $links[] = $this->renderItem($this->homeLink, $this->itemTemplate);
        }

        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }

            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }

        return Html::tag(
            'nav',
            Html::tag($this->tag, implode('', $links), $this->options)->encode($this->encodeTags)->render(),
            $this->navOptions
        )->encode($this->encodeTags)->render();
    }

    /**
     * The template used to render each active item in the breadcrumbs. The token `{link}` will be replaced with the
     * actual HTML link for each active item.
     *
     * @param string $value
     *
     * @return self
     */
    public function activeItemTemplate(string $value): self
    {
        $new = clone $this;
        $new->activeItemTemplate = $value;

        return $new;
    }

    /**
     * When tags Labels HTML should not be encoded.
     *
     * @return self
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;

        return $new;
    }

    /**
     * The first hyperlink in the breadcrumbs (called home link).
     *
     * Please refer to {@see links} on the format of the link.
     *
     * If this property is not set, it will default to a link pointing with the label 'Home'. If this property is false,
     * the home link will not be rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function homeLink(array $value): self
    {
        $new = clone $this;
        $new->homeLink = $value;

        return $new;
    }

    /**
     * The template used to render each inactive item in the breadcrumbs. The token `{link}` will be replaced with the
     * actual HTML link for each inactive item.
     *
     * @param string $value
     *
     * @return self
     */
    public function itemTemplate(string $value): self
    {
        $new = clone $this;
        $new->itemTemplate = $value;

        return $new;
    }

    /**
     * List of links to appear in the breadcrumbs. If this property is empty, the widget will not render anything. Each
     * array element represents a single link in the breadcrumbs with the following structure:
     *
     * ```php
     * [
     *     'label' => 'label of the link',  // required
     *     'url' => 'url of the link',      // optional, will be processed by Url::to()
     *     'template' => 'own template of the item', // optional, if not set $this->itemTemplate will be used
     * ]
     * ```
     *
     * @param array $value
     *
     * @return self
     */
    public function links(array $value): self
    {
        $new = clone $this;
        $new->links = $value;

        return $new;
    }

    /**
     * The HTML attributes for the widgets nav container tag.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function navOptions(array $value): self
    {
        $new = clone $this;
        $new->navOptions = $value;

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
     * The name of the breadcrumb container tag.
     *
     * @param string $value
     *
     * @return self
     */
    public function tag(string $value): self
    {
        $new = clone $this;
        $new->tag = $value;

        return $new;
    }

    /**
     * Renders a single breadcrumb item.
     *
     * @param array $link the link to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template the template to be used to rendered the link. The token "{link}" will be replaced by the
     * link.
     *
     * @throws JsonException|RuntimeException if `$link` does not have "label" element.
     *
     * @return string the rendering result
     */
    private function renderItem(array $link, string $template): string
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);

        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new RuntimeException('The "label" element is required for each link.');
        }

        if (isset($link['template'])) {
            $template = $link['template'];
        }

        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $linkHtml = Html::a($label, $link['url'], $options)->encode($this->encodeTags);
        } else {
            $linkHtml = $label;
        }

        return strtr($template, ['{link}' => $linkHtml]);
    }
}
