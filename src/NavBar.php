<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

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
 *        ->brandLabel('My Application Basic')
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
    private array $collapseOptions = [];
    private string $brandLabel = '';
    private string $brandImage = '';
    private string $brandUrl = '/';
    private array $brandOptions = [];
    private string $screenReaderToggleText = 'Toggle navigation';
    private string $togglerContent = '<span class="navbar-toggler-icon"></span>';
    private array $togglerOptions = [];
    private bool $renderInnerContainer = true;
    private array $innerContainerOptions = [];
    private array $options = [];
    private bool $encodeTags = false;

    public function begin(): string
    {
        parent::begin();

        if (!isset($this->options['id'])) {
            $id = $this->getId();
            $this->options['id'] = "{$id}-navbar";
            $this->collapseOptions['id'] = "{$id}-collapse";
        }

        if (empty($this->options['class'])) {
            /** @psalm-suppress InvalidArgument */
            Html::addCssClass($this->options, ['widget' => 'navbar', 'navbar-expand-lg', 'navbar-light', 'bg-light']);
        } else {
            /** @psalm-suppress InvalidArgument */
            Html::addCssClass($this->options, ['widget' => 'navbar']);
        }

        if ($this->encodeTags === false) {
            $this->collapseOptions['encode'] = false;
            $this->brandOptions['encode'] = false;
            $this->options['encode'] = false;
            $this->togglerOptions['encode'] = false;
        }

        $navOptions = $this->options;
        $navTag = ArrayHelper::remove($navOptions, 'tag', 'nav');
        $brand = '';

        if (!isset($this->innerContainerOptions['class'])) {
            Html::addCssClass($this->innerContainerOptions, ['innerContainerOptions' => 'container']);
        }

        if ($this->brandImage !== '') {
            $this->brandLabel = Html::img($this->brandImage);
        }

        if ($this->brandLabel !== '') {
            Html::addCssClass($this->brandOptions, ['widget' => 'navbar-brand']);
            if (empty($this->brandUrl)) {
                $brand = Html::span($this->brandLabel, $this->brandOptions);
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
     * The HTML attributes for the container tag. The following special options are recognized.
     *
     * @param array $value
     *
     * @return $this
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
     * @param string $value
     *
     * @return $this
     *
     * {@see https://getbootstrap.com/docs/4.2/components/navbar/}
     */
    public function brandLabel(string $value): self
    {
        $new = clone $this;
        $new->brandLabel = $value;

        return $new;
    }

    /**
     * Src of the brand image or empty if it's not used. Note that this param will override `$this->brandLabel` param.
     *
     * @param string $value
     *
     * @return $this
     *
     * {@see https://getbootstrap.com/docs/4.2/components/navbar/}
     */
    public function brandImage(string $value): self
    {
        $new = clone $this;
        $new->brandImage = $value;

        return $new;
    }

    /**
     * The URL for the brand's hyperlink tag and will be used for the "href" attribute of the brand link. Default value
     * is '/' will be used. You may set it to `null` if you want to have no link at all.
     *
     * @param string $value
     *
     * @return $this
     */
    public function brandUrl(string $value): self
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
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
     * @return $this
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * Renders collapsible toggle button.
     *
     * @throws JsonException
     *
     * @return string the rendering toggle button.
     */
    private function renderToggleButton(): string
    {
        $options = $this->togglerOptions;

        Html::addCssClass($options, ['widget' => 'navbar-toggler']);

        return Html::button(
            $this->togglerContent,
            ArrayHelper::merge($options, [
                'type' => 'button',
                'data' => [
                    'bs-toggle' => 'collapse',
                    'bs-target' => '#' . $this->collapseOptions['id'],
                ],
                'aria-controls' => $this->collapseOptions['id'],
                'aria-expanded' => 'false',
                'aria-label' => $this->screenReaderToggleText,
            ])
        );
    }
}
