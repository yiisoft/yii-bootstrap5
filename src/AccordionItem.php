<?php

declare(strict_types=1);

namespace Yiisoft\Yii\Bootstrap5;

use InvalidArgumentException;
use Yiisoft\Html\Html;

/**
 * AccordionItem represents a single item in an {@see Accordion} widget.
 *
 * For example:
 *
 * ```php
 * echo Accordion::widget()
 *     ->item(
 *         AccordionItem::widget()
 *             ->header('Collapsible Group Item #1')
 *             ->body('Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.')
 *     )
 *     ->item(
 *         AccordionItem::widget()
 *             ->header('Collapsible Group Item #2')
 *             ->body('Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.')
 *     )
 *     ->render();
 * ```
 */
final class AccordionItem
{
    private const DEFAULT_ID_PREFIX = 'collapse';

    public function __construct(
        private readonly string $header,
        private readonly string $body,
        private readonly bool|string $id = true,
        private readonly bool $encodeHeader = true,
        private readonly bool $encodeBody = true
    ) {
    }

    /**
     * Returns the encoded header content.
     *
     * @return string The encoded header content.
     */
    public function getHeader(): string
    {
        return $this->encodeHeader ? Html::encode($this->header) : $this->header;
    }

    /**
     * Returns the encoded body content.
     *
     * @return string The encoded body content.
     */
    public function getBody(): string
    {
        return $this->encodeBody ? Html::encode($this->body) : $this->body;
    }

    /**
     * Returns the ID of the accordion item.
     *
     * @throws InvalidArgumentException If the "id" property is invalid.
     *
     * @return bool|string The ID of the accordion item.
     */
    public function getId(): bool|string
    {
        return match ($this->id) {
            true => Html::generateId(self::DEFAULT_ID_PREFIX . '-'),
            '', false => throw new InvalidArgumentException('The "id" property must be a non-empty string or `true`.'),
            default => $this->id,
        };
    }
}
