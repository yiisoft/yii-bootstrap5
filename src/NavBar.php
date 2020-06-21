<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use Yiisoft\Arrays\ArrayHelper;

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
 *    <?php NavBar::begin()
 *        ->brandLabel('My Application Basic')
 *        ->brandUrl('/')
 *        ->options([
 *            'class' => 'navbar navbar-dark bg-dark navbar-expand-lg text-white',
 *        ])
 *        ->start();
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
class NavBar extends Widget
{
    private array $collapseOptions = [];

    private ?string $brandLabel = null;

    private ?string $brandImage = null;

    private ?string $brandUrl = '/';

    private array $brandOptions = [];

    private string $screenReaderToggleText = 'Toggle navigation';

    private string $togglerContent = '<span class="navbar-toggler-icon"></span>';

    private array $togglerOptions = [];

    private bool $renderInnerContainer = true;

    private array $innerContainerOptions = [];

    private array $options = [];

    public function start(): string
    {
        if (!isset($this->options['id'])) {
            $id = $this->getId();
            $this->options['id'] = "{$id}-navbar";
            $this->collapseOptions['id'] = "{$id}-collapse";
        }

        if (empty($this->options['class'])) {
            Html::addCssClass($this->options, ['widget' => 'navbar', 'navbar-expand-lg', 'navbar-light', 'bg-light']);
        } else {
            Html::addCssClass($this->options, ['widget' => 'navbar']);
        }

        $navOptions = $this->options;
        $navTag = ArrayHelper::remove($navOptions, 'tag', 'nav');
        $brand = '';

        if (!isset($this->innerContainerOptions['class'])) {
            Html::addCssClass($this->innerContainerOptions, 'container');
        }

        if ($this->brandImage !== null) {
            $this->brandLabel = Html::img($this->brandImage);
        }

        if ($this->brandLabel !== null) {
            Html::addCssClass($this->brandOptions, ['widget' => 'navbar-brand']);
            if (empty($this->brandUrl)) {
                $brand = Html::tag('span', $this->brandLabel, $this->brandOptions);
            } else {
                $brand = Html::a(
                    $this->brandLabel,
                    $this->brandUrl,
                    $this->brandOptions
                );
            }
        }

        Html::addCssClass($this->collapseOptions, ['collapse' => 'collapse', 'widget' => 'navbar-collapse']);
        $collapseOptions = $this->collapseOptions;
        $collapseTag = ArrayHelper::remove($collapseOptions, 'tag', 'div');

        $htmlStart = Html::beginTag($navTag, $navOptions) . "\n";

        if ($this->renderInnerContainer) {
            $htmlStart .= Html::beginTag('div', $this->innerContainerOptions) . "\n";
        }

        $htmlStart .= $brand . "\n";
        $htmlStart .= $this->renderToggleButton() . "\n";

        $htmlStart .= Html::beginTag($collapseTag, $collapseOptions) . "\n";

        return $htmlStart;
    }

    protected function run(): string
    {
        $tag = ArrayHelper::remove($this->collapseOptions, 'tag', 'div');

        $htmlRun = Html::endTag($tag) . "\n";

        if ($this->renderInnerContainer) {
            $htmlRun .= Html::endTag('div') . "\n";
        }

        $tag = ArrayHelper::remove($this->options, 'tag', 'nav');

        $htmlRun .= Html::endTag($tag);

        return $htmlRun;
    }

    /**
     * Renders collapsible toggle button.
     *
     * @return string the rendering toggle button.
     */
    protected function renderToggleButton(): string
    {
        $options = $this->togglerOptions;

        Html::addCssClass($options, ['widget' => 'navbar-toggler']);

        return Html::button(
            $this->togglerContent,
            ArrayHelper::merge($options, [
                'type' => 'button',
                'data' => [
                    'toggle' => 'collapse',
                    'target' => '#' . $this->collapseOptions['id'],
                ],
                'aria-controls' => $this->collapseOptions['id'],
                'aria-expanded' => 'false',
                'aria-label' => $this->screenReaderToggleText,
            ])
        );
    }

    /**
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function collapseOptions(array $value): self
    {
        $this->collapseOptions = $value;

        return $this;
    }

    /**
     * The text of the brand or empty if it's not used. Note that this is not HTML-encoded.
     *
     * {@see https://getbootstrap.com/docs/4.2/components/navbar/}
     */
    public function brandLabel(?string $value): self
    {
        $this->brandLabel = $value;

        return $this;
    }

    /**
     * Src of the brand image or empty if it's not used. Note that this param will override `$this->brandLabel` param.
     *
     * {@see https://getbootstrap.com/docs/4.2/components/navbar/}
     */
    public function brandImage(?string $value): self
    {
        $this->brandImage = $value;

        return $this;
    }

    /**
     * The URL for the brand's hyperlink tag and will be used for the "href" attribute of the brand link. Default value
     * is '/' will be used. You may set it to `null` if you want to have no link at all.
     */
    public function brandUrl(?string $value): self
    {
        $this->brandUrl = $value;

        return $this;
    }

    /**
     * The HTML attributes of the brand link.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function brandOptions(array $value): self
    {
        $this->brandOptions = $value;

        return $this;
    }

    /**
     * Text to show for screen readers for the button to toggle the navbar.
     */
    public function screenReaderToggleText(string $value): self
    {
        $this->screenReaderToggleText = $value;

        return $this;
    }

    /**
     * The toggle button content. Defaults to bootstrap 4 default `<span class="navbar-toggler-icon"></span>`.
     */
    public function togglerContent(string $value): self
    {
        $this->togglerContent = $value;

        return $this;
    }

    /**
     * The HTML attributes of the navbar toggler button.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function togglerOptions(array $value): self
    {
        $this->togglerOptions = $value;

        return $this;
    }

    /**
     * Whether the navbar content should be included in an inner div container which by default adds left and right
     * padding. Set this to false for a 100% width navbar.
     */
    public function renderInnerContainer(bool $value): self
    {
        $this->renderInnerContainer = $value;

        return $this;
    }

    /**
     * The HTML attributes of the inner container.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function innerContainerOptions(array $value): self
    {
        $this->innerContainerOptions = $value;

        return $this;
    }

    /**
     * The HTML attributes for the widget container tag. The following special options are recognized.
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function options(array $value): self
    {
        $this->options = $value;

        return $this;
    }
}
