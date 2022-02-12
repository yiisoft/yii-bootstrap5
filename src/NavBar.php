<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

/**
 * NavBar renders a navbar HTML component.
 *
 * Any content enclosed between the {@see begin()} and {@see end()} calls of NavBar is treated as the content of the
 * navbar. You may use widgets such as {@see Nav} or {@see \Yiisoft\Widget\Menu} to build up such content. For example,
 *
 * ```php
 *    if ($user->getId() !== null) {
 *        $menuItems = [
 *            [
 *                'label' => 'About',
 *                'url' => '/about',
 *            ],
 *            [
 *                'label' => 'Contact',
 *                'url' => '/contact',
 *            ],
 *            [
 *                'label' => 'Logout' . ' ' . '(' . $user->getUsername() . ')',
 *                'url' => '/logout'
 *            ],
 *        ];
 *    } else {
 *        $menuItems = [
 *            [
 *                'label' => 'About',
 *                'url' => '/about',
 *            ],
 *            [
 *                'label' => 'Contact',
 *                'url' => '/contact',
 *            ],
 *            [
 *                'label' => 'Login',
 *                'url' => '/login',
 *            ],
 *        ];
 *    }
 *
 *    <?php NavBar::widget()
 *        ->brandText('My Application Basic')
 *        ->brandUrl('/')
 *        ->options([
 *            'class' => 'navbar navbar-dark bg-dark navbar-expand-lg text-white',
 *        ])
 *        ->begin();
 *
 *        echo Nav::widget()
 *            ->currentPath($currentPath)
 *            ->items($menuItems)
 *            ->options([
 *                'class' => 'navbar-nav float-right ml-auto'
 *            ]);
 *
 *    echo NavBar::end(); ?>
 * ```
 * Note: $currentPath it must be injected from each controller to the main controller.
 *
 * SiteController.php
 *
 * ```php
 *
 *    public function index(ServerRequestInterface $request): ResponseInterface
 *    {
 *        $response = $this->responseFactory->createResponse();
 *        $currentPath = $request->getUri()->getPath();
 *        $output = $this->render('index', ['currentPath' => $currentPath]);
 *        $response->getBody()->write($output);
 *
 *        return $response;
 *    }
 * ```
 *
 * Controller.php
 *
 * ```php
 *    private function renderContent($content, array $parameters = []): string
 *    {
 *        $user = $this->user->getIdentity();
 *        $layout = $this->findLayoutFile($this->layout);
 *
 *        if ($layout !== null) {
 *            return $this->view->renderFile(
 *                $layout,
 *                    [
 *                        'aliases' => $this->aliases,
 *                        'content' => $content,
 *                        'user' => $user,
 *                        'params' => $this->params,
 *                        'currentPath' => !isset($parameters['currentPath']) ?: $parameters['currentPath']
 *                    ],
 *                $this
 *            );
 *        }
 *
 *        return $content;
 *    }
 * ```
 */
final class NavBar extends Widget
{
    public const EXPAND_SM = 'navbar-expand-sm';
    public const EXPAND_MD = 'navbar-expand-md';
    public const EXPAND_LG = 'navbar-expand-lg';
    public const EXPAND_XL = 'navbar-expand-xl';
    public const EXPAND_XXL = 'navbar-expand-xxl';

    private array $collapseOptions = [];
    private ?string $brandText = null;
    private ?string $brandImage = null;
    private array $brandImageAttributes = [];
    private ?string $brandUrl = '/';
    private array $brandOptions = [];
    private string $screenReaderToggleText = 'Toggle navigation';
    private string $togglerContent = '<span class="navbar-toggler-icon"></span>';
    private array $togglerOptions = [];
    private bool $renderInnerContainer = true;
    private array $innerContainerOptions = [];
    private array $options = [];
    private bool $encodeTags = false;
    private ?string $expandSize = self::EXPAND_LG;

    public function getId(?string $suffix = '-navbar'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    public function begin(): string
    {
        parent::begin();

        $options = $this->options;
        $options['id'] = $this->getId();
        $navTag = ArrayHelper::remove($options, 'tag', 'nav');
        $classNames = ['widget' => 'navbar'];

        if ($this->expandSize) {
            $classNames['size'] = $this->expandSize;
        }

        if (empty($options['class'])) {
            $classNames = array_merge($classNames, ['navbar-light', 'bg-light']);
        }

        Html::addCssClass($options, $classNames);

        if (!isset($this->innerContainerOptions['class'])) {
            Html::addCssClass($this->innerContainerOptions, ['innerContainerOptions' => 'container']);
        }

        $htmlStart = Html::openTag($navTag, $options) . "\n";

        if ($this->renderInnerContainer) {
            $htmlStart .= Html::openTag('div', $this->innerContainerOptions) . "\n";
        }

        $htmlStart .= $this->renderBrand() . "\n";

        if ($this->expandSize) {
            $collapseOptions = $this->collapseOptions;
            $collapseTag = ArrayHelper::remove($collapseOptions, 'tag', 'div');

            if (!isset($collapseOptions['id'])) {
                $collapseOptions['id'] = $options['id'] . '-collapse';
            }

            Html::addCssClass($collapseOptions, ['collapse' => 'collapse', 'widget' => 'navbar-collapse']);

            $htmlStart .= $this->renderToggleButton($collapseOptions) . "\n";
            $htmlStart .= Html::openTag($collapseTag, $collapseOptions) . "\n";
        }

        return $htmlStart;
    }

    protected function run(): string
    {
        $htmlRun = '';

        if ($this->expandSize) {
            $tag = ArrayHelper::getValue($this->collapseOptions, 'tag', 'div');
            $htmlRun .= Html::closeTag($tag) . "\n";
        }

        if ($this->renderInnerContainer) {
            $htmlRun .= Html::closeTag('div') . "\n";
        }

        $tag = ArrayHelper::getValue($this->options, 'tag', 'nav');

        $htmlRun .= Html::closeTag($tag);

        return $htmlRun;
    }

    /**
     * Set size before then content will be expanded
     *
     * @param string|null $size
     *
     * @return self
     */
    public function expandSize(?string $size): self
    {
        $new = clone $this;
        $new->expandSize = $size;

        return $new;
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * @param array $value
     *
     * @return self
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function collapseOptions(array $value): self
    {
        $new = clone $this;
        $new->collapseOptions = $value;

        return $new;
    }

    /**
     * The text of the brand or empty if it's not used. Note that this is not HTML-encoded.
     *
     * @param string|null $value
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#text
     */
    public function brandText(?string $value): self
    {
        $new = clone $this;
        $new->brandText = $value;

        return $new;
    }

    /**
     * Src of the brand image or empty if it's not used. Note that this param will override `$this->brandText` param.
     *
     * @param string|null $value
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#image
     */
    public function brandImage(?string $value): self
    {
        $new = clone $this;
        $new->brandImage = $value;

        return $new;
    }

    /**
     * Set attributes for brandImage
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $attributes
     *
     * @return self
     */
    public function brandImageAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->brandImageAttributes = $attributes;

        return $new;
    }

    /**
     * The URL for the brand's hyperlink tag and will be used for the "href" attribute of the brand link. Default value
     * is "/". You may set it to empty string if you want no link at all.
     *
     * @param string|null $value
     *
     * @return self
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#text
     */
    public function brandUrl(?string $value): self
    {
        $new = clone $this;
        $new->brandUrl = $value;

        return $new;
    }

    /**
     * The HTML attributes of the brand link.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function brandOptions(array $value): self
    {
        $new = clone $this;
        $new->brandOptions = $value;

        return $new;
    }

    /**
     * Text to show for screen readers for the button to toggle the navbar.
     *
     * @param string $value
     *
     * @return self
     */
    public function screenReaderToggleText(string $value): self
    {
        $new = clone $this;
        $new->screenReaderToggleText = $value;

        return $new;
    }

    /**
     * The toggle button content. Defaults to bootstrap 4 default `<span class="navbar-toggler-icon"></span>`.
     *
     * @param string $value
     *
     * @return self
     */
    public function togglerContent(string $value): self
    {
        $new = clone $this;
        $new->togglerContent = $value;

        return $new;
    }

    /**
     * The HTML attributes of the navbar toggler button.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function togglerOptions(array $value): self
    {
        $new = clone $this;
        $new->togglerOptions = $value;

        return $new;
    }

    /**
     * This for a 100% width navbar.
     *
     * @return self
     */
    public function withoutRenderInnerContainer(): self
    {
        $new = clone $this;
        $new->renderInnerContainer = false;

        return $new;
    }

    /**
     * The HTML attributes of the inner container.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return self
     */
    public function innerContainerOptions(array $value): self
    {
        $new = clone $this;
        $new->innerContainerOptions = $value;

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

    private function renderBrand(): string
    {
        if (empty($this->brandImage) && empty($this->brandText)) {
            return '';
        }

        $content = '';
        $options = $this->brandOptions;
        $encode = ArrayHelper::remove($options, 'encode', $this->encodeTags);

        Html::addCssClass($options, ['widget' => 'navbar-brand']);

        if (!empty($this->brandImage)) {
            $encode = false;
            $content = Html::img($this->brandImage)->attributes($this->brandImageAttributes);
        }

        if (!empty($this->brandText)) {
            $content .= $this->brandText;
        }
        /** @var Stringable|string $content */
        if (empty($this->brandUrl)) {
            $brand = Html::span($content, $options);
        } else {
            $brand = Html::a($content, $this->brandUrl, $options);
        }

        return $brand->encode($encode)->render();
    }

    /**
     * Renders collapsible toggle button.
     *
     * @throws JsonException
     *
     * @return string the rendering toggle button.
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#toggler
     */
    private function renderToggleButton(array $collapseOptions): string
    {
        $options = $this->togglerOptions;
        $encode = ArrayHelper::remove($options, 'encode', $this->encodeTags);
        Html::addCssClass($options, ['widget' => 'navbar-toggler']);

        return Html::button(
            $this->togglerContent,
            array_merge(
                $options,
                [
                    'type' => 'button',
                    'data' => [
                        'bs-toggle' => 'collapse',
                        'bs-target' => '#' . $collapseOptions['id'],
                    ],
                    'aria-controls' => $collapseOptions['id'],
                    'aria-expanded' => 'false',
                    'aria-label' => $this->screenReaderToggleText,
                ]
            )
        )->encode($encode)->render();
    }
}
