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
 *    <?= NavBar::widget()
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
 *        $currentPath = $request
 *            ->getUri()
 *            ->getPath();
 *        $output = $this->render('index', ['currentPath' => $currentPath]);
 *        $response
 *            ->getBody()
 *            ->write($output);
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

    public const THEME_LIGHT = 'navbar-light';
    public const THEME_DARK = 'navbar-dark';

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
    private ?string $theme = self::THEME_LIGHT;
    private ?Offcanvas $offcanvas = null;

    public function getId(?string $suffix = '-navbar'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    public function begin(): string
    {
        /** Run Offcanvas::begin before NavBar parent::begin for right stack order */
        $offcanvas = $this->offcanvas ? $this->offcanvas->begin() : null;

        parent::begin();

        $options = $this->options;
        $options['id'] = $this->getId();
        $navTag = ArrayHelper::remove($options, 'tag', 'nav');
        $classNames = ['widget' => 'navbar'];

        if ($this->expandSize) {
            $classNames['size'] = $this->expandSize;
        }

        if ($this->theme) {
            $classNames['theme'] = $this->theme;
        }

        Html::addCssClass($options, $classNames);

        if (!isset($this->innerContainerOptions['class'])) {
            Html::addCssClass($this->innerContainerOptions, ['innerContainerOptions' => 'container']);
        }

        $htmlStart = Html::openTag($navTag, $options);

        if ($this->renderInnerContainer) {
            $htmlStart .= Html::openTag('div', $this->innerContainerOptions);
        }

        $htmlStart .= $this->renderBrand();

        if ($offcanvas) {
            $offcanvasId = $this->offcanvas ? $this->offcanvas->getId() : null;
            $htmlStart .= $this->renderToggleButton($offcanvasId);
            $htmlStart .= $offcanvas;
        } elseif ($this->expandSize) {
            $collapseOptions = $this->collapseOptions;
            $collapseTag = ArrayHelper::remove($collapseOptions, 'tag', 'div');

            if (!isset($collapseOptions['id'])) {
                $collapseOptions['id'] = $options['id'] . '-collapse';
            }

            Html::addCssClass($collapseOptions, ['collapse' => 'collapse', 'widget' => 'navbar-collapse']);

            $htmlStart .= $this->renderToggleButton($collapseOptions['id']);
            $htmlStart .= Html::openTag($collapseTag, $collapseOptions);
        } elseif ($this->togglerOptions) {
            $htmlStart .= $this->renderToggleButton(null);
        }

        return $htmlStart;
    }

    protected function run(): string
    {
        $htmlRun = '';

        if ($this->offcanvas) {
            $htmlRun = $this->offcanvas::end();
        } elseif ($this->expandSize) {
            $tag = ArrayHelper::getValue($this->collapseOptions, 'tag', 'div');
            $htmlRun = Html::closeTag($tag);
        }

        if ($this->renderInnerContainer) {
            $htmlRun .= Html::closeTag('div');
        }

        $tag = ArrayHelper::getValue($this->options, 'tag', 'nav');

        $htmlRun .= Html::closeTag($tag);

        return $htmlRun;
    }

    /**
     * Set size before then content will be expanded
     */
    public function expandSize(?string $size): self
    {
        $new = clone $this;
        $new->expandSize = $size;

        return $new;
    }

    /**
     * Set color theme for NavBar
     */
    public function theme(?string $theme): self
    {
        $new = clone $this;
        $new->theme = $theme;

        return $new;
    }

    /**
     * Short method for light navbar theme
     */
    public function light(): self
    {
        return $this->theme(self::THEME_LIGHT);
    }

    /**
     * Short method for dark navbar theme
     */
    public function dark(): self
    {
        return $this->theme(self::THEME_DARK);
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * @param array $value
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
     * Set/remove Offcanvas::widget instead of collapse
     */
    public function offcanvas(?Offcanvas $offcanvas): self
    {
        $new = clone $this;
        $new->offcanvas = $offcanvas;

        return $new;
    }

    /**
     * The text of the brand or empty if it's not used. Note that this is not HTML-encoded.
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
     */
    public function brandOptions(array $value): self
    {
        $new = clone $this;
        $new->brandOptions = $value;

        return $new;
    }

    /**
     * Text to show for screen readers for the button to toggle the navbar.
     */
    public function screenReaderToggleText(string $value): self
    {
        $new = clone $this;
        $new->screenReaderToggleText = $value;

        return $new;
    }

    /**
     * The toggle button content. Defaults to bootstrap 4 default `<span class="navbar-toggler-icon"></span>`.
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
     */
    public function togglerOptions(array $value): self
    {
        $new = clone $this;
        $new->togglerOptions = $value;

        return $new;
    }

    /**
     * This for a 100% width navbar.
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
            $content = Html::img($this->brandImage)->addAttributes($this->brandImageAttributes);
        }

        if (!empty($this->brandText)) {
            $content .= $this->brandText;
        }
        /** @var string|Stringable $content */
        if (empty($this->brandUrl)) {
            $brand = Html::span($content, $options);
        } else {
            $brand = Html::a($content, $this->brandUrl, $options);
        }

        return $brand
            ->encode($encode)
            ->render();
    }

    /**
     * Renders collapsible toggle button.
     *
     * @param string|null $targetId - ID of target element for current button
     *
     * @throws JsonException
     *
     * @return string the rendering toggle button.
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#toggler
     */
    private function renderToggleButton(?string $targetId): string
    {
        $options = $this->togglerOptions;
        $encode = ArrayHelper::remove($options, 'encode', $this->encodeTags);
        Html::addCssClass($options, ['widget' => 'navbar-toggler']);

        $defauts = [
            'type' => 'button',
            'data' => [
                'bs-toggle' => $this->offcanvas ? 'offcanvas' : 'collapse',
            ],
            'aria' => [
                'controls' => $targetId,
                'expanded' => 'false',
                'label' => $this->screenReaderToggleText,
            ],
        ];

        if ($targetId) {
            $defauts['data']['bs-target'] = '#' . $targetId;
        }

        return Html::button(
            $this->togglerContent,
            ArrayHelper::merge($defauts, $options)
        )
            ->encode($encode)
            ->render();
    }
}
