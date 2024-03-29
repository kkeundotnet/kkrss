<?php

declare(strict_types=1);

namespace Kkeundotnet\Kkrss;

abstract class KkViewer
{
    /** @param KkItem[] $items */
    public function __construct(
        protected readonly string $title,
        protected readonly string $link,
        protected readonly string $description,
        protected readonly bool $is_perma_link_guid,
        protected readonly array $items,
        protected readonly ?string $feed_link = null,
    ) {
    }

    public function view(): void
    {
        header('Content-Type: application/rss+xml; charset=utf-8');
        require('KkTemplate.php');
    }

    public function view_for_test(): void
    {
        require('KkTemplate.php');
    }

    private static function xml_escape(string $unsafe): string
    {
        return htmlspecialchars($unsafe, ENT_XML1 | ENT_QUOTES, 'UTF-8');
    }
}
