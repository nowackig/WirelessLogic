<?php

declare(strict_types=1);

namespace WirelessLogic\Infrastructure\Http\Parsers;

use PHPHtmlParser\Dom;
use PHPHtmlParser\Dom\HtmlNode;
use WirelessLogic\Application\Parsers\ProductHttpSourceMapInterface;
use WirelessLogic\Application\Parsers\ProductParserInterface;

class ProductParser implements ProductParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse(string $content, ProductHttpSourceMapInterface $map): array
    {
        $dom = new Dom;
        $dom->loadStr(
            $content,
            [
                'htmlSpecialCharsDecode' => true,
            ]
        );
        $products = $dom->find(sprintf('.%s', $map->productCssClass()));

        $parsedProducts = [];

        /** @var HtmlNode $product */
        foreach ($products as $product) {
            $parsedProducts[] = $this->productInfo($product);
        }

        return $parsedProducts;
    }

    private function productInfo(HtmlNode $node, array &$parsed = [], string $class = null): ?array
    {
        $node->find('div')->each(function ($elem) use (&$parsed, $class) {
            /** @var HtmlNode $elem */
            if ($elem->hasAttribute('class')) {
                $class = current(explode(' ', $elem->getAttribute('class')));
            }

            $children = null;
            if ($elem->hasChildren()) {
                $children = array_filter($elem->getChildren(), fn ($child) => !$child->isTextNode());
            }

            if (trim($elem->text())) {
                $content = trim($elem->text());
                $parsed[$class] = str_contains($content, '  ')
                    ? explode('  ', trim($elem->text())) : $content;
            }

            if ($children) {
                foreach ($children as $child) {
                    $childChildren = [];
                    if ($child->hasChildren()) {
                        $childChildren = array_filter($child->getChildren(), fn ($child1) => !$child1->isTextNode());
                    }

                    if ($childChildren) {
                        $this->productInfo($child, $parsed, $class);
                    } else {
                        if ($child->hasAttribute('class')) {
                            $class = current(explode(' ', $child->getAttribute('class')));
                        }

                        $value = trim($child->text());

                        if ($value) {
                            if (array_key_exists($class, $parsed)) {
                                if (!is_array($parsed[$class])) {
                                    $parsed[$class] = [$parsed[$class]];
                                }
                                $value = array_merge($parsed[$class], [$value]);
                            }

                            $parsed[$class] = $value;
                        }
                    }
                }
            }
        });

        return $parsed;
    }
}
