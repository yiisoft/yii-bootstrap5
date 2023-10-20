<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Stringable;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\Tag;

use function array_merge;

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
final class NavBar extends AbstractToggleWidget
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
    protected string|Stringable $toggleLabel = '<span class="navbar-toggler-icon"></span>';
    private bool $renderInnerContainer = true;
    private array $innerContainerOptions = [];
    private array $options = [];
    private bool $encodeTags = false;
    private ?string $expandSize = self::EXPAND_LG;
    private Offcanvas|Collapse|null $widget = null;
    protected bool $renderToggle = false;

    public function getId(?string $suffix = '-navbar'): ?string
    {
        return $this->options['id'] ?? parent::getId($suffix);
    }

    protected function toggleComponent(): string
    {
        if ($this->widget instanceof Offcanvas) {
            return 'offcanvas';
        }

        return 'collapse';
    }

    /**
     * @throws \Yiisoft\Definitions\Exception\CircularReferenceException
     * @throws \Yiisoft\Definitions\Exception\InvalidConfigException
     * @throws \Yiisoft\Definitions\Exception\NotInstantiableException
     * @throws \Yiisoft\Factory\NotFoundException
     * @return string
     */
    public function begin(): string
    {
        /** Run Offcanvas|Collapse::begin before NavBar parent::begin for right stack order */
        if ($this->expandSize && $this->widget === null) {
            $collapseOptions = $this->collapseOptions;
            Html::addCssClass($collapseOptions, ['collapse' => 'collapse', 'widget' => 'navbar-collapse']);

            $this->widget = Collapse::widget()
                ->withOptions($collapseOptions)
                ->withBodyOptions([
                    'tag' => null,
                ]);
        }

        if ($this->widget) {
            [$tagName, $options, $encode] = $this->prepareToggleOptions();
            unset(
                $options['data-bs-target'],
                $options['data']['bs-target'],
                $options['aria-controls'],
                $options['aria']['controls'],
            );

            $widget = $this->widget
                ->withToggle(true)
                ->withToggleLabel($this->toggleLabel)
                ->withToggleOptions(
                    array_merge($options, [
                        'tag' => $tagName,
                        'encode' => $encode,
                    ])
                )
                ->begin();
        } else {
            $widget = '';
        }

        parent::begin();

        $options = $this->options;
        $options['id'] = $this->getId();
        $navTag = ArrayHelper::remove($options, 'tag', 'nav');
        $classNames = ['widget' => 'navbar'];

        if ($this->expandSize) {
            $classNames['size'] = $this->expandSize;
        }

        if ($this->theme) {
            $options['data-bs-theme'] = $this->theme;

            if ($this->theme === self::THEME_DARK) {
                $classNames['theme'] = 'navbar-dark';
            } elseif ($this->theme === self::THEME_LIGHT) {
                $classNames['theme'] = 'navbar-light';
            }
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

        if ($widget) {
            $htmlStart .= $widget;
        } elseif ($this->renderToggle) {
            $htmlStart .= $this->renderToggle();
        }

        return $htmlStart;
    }

    public function render(): string
    {
        $htmlRun = $this->widget ? $this->widget::end() : '';

        if ($this->renderInnerContainer) {
            $htmlRun .= Html::closeTag('div');
        }

        $htmlRun .= Html::closeTag($this->options['tag'] ?? 'nav');

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
     * The HTML attributes for the container tag. The following special options are recognized.
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
     * Set/remove Offcanvas::widget or Collapse::widget
     */
    public function withWidget(Offcanvas|Collapse|null $widget): self
    {
        $new = clone $this;
        $new->widget = $widget;

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

    protected function prepareToggleOptions(): array
    {
        [$tagName, $options] = parent::prepareToggleOptions();

        Html::addCssClass($options, ['widget' => 'navbar-toggler']);
        $options['aria-label'] = $this->screenReaderToggleText;

        return [$tagName, $options, $this->encodeTags];
    }

    /**
     * Renders collapsible toggle button.
     *
     * @return Tag the rendering toggle button.
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#toggler
     */
    public function renderToggle(): Tag
    {
        if ($this->widget) {
            return $this->widget->renderToggle();
        }

        return parent::renderToggle();
    }
}
