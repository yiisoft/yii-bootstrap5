<?php
declare(strict_types = 1);

namespace Yiisoft\Yii\Bootstrap4;

use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Yii\Bootstrap4\Exception\InvalidConfigException;

/**
 * Button renders a bootstrap button.
 *
 * For example,
 *
 * ```php
 *    <?= Breadcrumbs::widget()
 *        ->links(['label' => !empty($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]);
 *    ?>
 * ```
 */
class Breadcrumbs extends Widget
{
    /**
     * @var string the name of the breadcrumb container tag.
     */
    private $tag = 'ol';

    /**
     * @var bool whether to HTML-encode the link labels.
     */
    private $encodeLabels = true;

    /**
     * @var array the first hyperlink in the breadcrumbs (called home link).
     *
     * Please refer to {@see links} on the format of the link.
     * If this property is not set, it will default to a link pointing with the label 'Home'. If this property is false,
     * the home link will not be rendered.
     */
    private $homeLink;

    /**
     * @var array list of links to appear in the breadcrumbs. If this property is empty, the widget will not render
     *            anything. Each array element represents a single link in the breadcrumbs with the following structure:
     *
     * ```php
     * [
     *     'label' => 'label of the link',  // required
     *     'url' => 'url of the link',      // optional, will be processed by Url::to()
     *     'template' => 'own template of the item', // optional, if not set $this->itemTemplate will be used
     * ]
     * ```
     *
     *
     */
    private $links = [];

    /**
     * @var string the template used to render each inactive item in the breadcrumbs. The token `{link}` will be
     *             replaced with the actual HTML link for each inactive item.
     */
    private $itemTemplate = "<li class=\"breadcrumb-item\">{link}</li>\n";

    /**
     * @var string the template used to render each active item in the breadcrumbs. The token `{link}` will be replaced
     *             with the actual HTML link for each active item.
     */
    private $activeItemTemplate = "<li class=\"breadcrumb-item active\" aria-current=\"page\">{link}</li>\n";

    /**
     * @var array the HTML attributes for the widgets nav container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private $navOptions = ['aria-label' => 'breadcrumb'];

    /**
     * @var array the HTML attributes for the widget container tag. The following special options are recognized:
     *
     * - tag: string, defaults to "nav", the name of the container tag.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    private $options = [];

    /**
     * Renders the widget.
     *
     * @return string
     */
    public function getContent(): string
    {
        $this->clientOptions = false;

        if (!isset($this->options['id'])) {
            $this->options['id'] = "{$this->getId()}-breadcrumb";
        }

        Html::addCssClass($this->options, ['widget' => 'breadcrumb']);

        $this->registerPlugin('breadcrumb', $this->options);

        if (empty($this->links)) {
            return '';
        }

        $links = [];

        if (empty($this->homeLink)) {
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

        return Html::tag('nav', Html::tag($this->tag, implode('', $links), $this->options), $this->navOptions);
    }
    /**
     * Renders a single breadcrumb item.
     *
     * @param array $link the link to be rendered. It must contain the "label" element. The "url" element is optional.
     * @param string $template the template to be used to rendered the link. The token "{link}" will be replaced by the
     *                         link.
     *
     * @return string the rendering result
     *
     * @throws InvalidConfigException if `$link` does not have "label" element.
     */
    protected function renderItem(array $link, string $template): string
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);

        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }

        if (isset($link['template'])) {
            $template = $link['template'];
        }

        if (isset($link['url'])) {
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }

    public function __toString(): string
    {
        return $this->run();
    }

    /**
     * {@see activeItemTemplate}
     *
     * @param bool $activeItemTemplate
     *
     * @return $this
     */
    public function activeItemTemplate(string $value): self
    {
        $this->activeItemTemplate = $value;

        return $this;
    }

    /**
     * {@see encodeLabels}
     *
     * @param bool $encodeLabels
     *
     * @return $this
     */
    public function encodeLabels(bool $value): self
    {
        $this->encodeLabels = $value;

        return $this;
    }

    /**
     * {@see homeLink}
     *
     * @param bool $homeLink
     *
     * @return $this
     */
    public function homeLink(array $value): self
    {
        $this->homeLink = $value;

        return $this;
    }

    /**
     * {@see itemTemplate}
     *
     * @param bool $itemTemplate
     *
     * @return $this
     */
    public function itemTemplate(string $value): self
    {
        $this->itemTemplate = $value;

        return $this;
    }

    /**
     * {@see links}
     *
     * @param bool $links
     *
     * @return $this
     */
    public function links(array $value): self
    {
        $this->links = $value;

        return $this;
    }

    /**
     * {@see navOptions}
     *
     * @param array $navOptions
     *
     * @return $this
     */
    public function navOptions(array $value): self
    {
        $this->navOptions = $value;

        return $this;
    }

    /**
     * {@see options}
     *
     * @param array $options
     *
     * @return $this
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }

    /**
     * {@see tag}
     *
     * @param array $tag
     *
     * @return $this
     */
    public function tag(array $value): self
    {
        $this->tagName = $value;

        return $this;
    }
}
