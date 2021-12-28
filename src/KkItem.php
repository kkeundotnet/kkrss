<?php

declare(strict_types=1);

namespace Kkeundotnet\Kkrss;

class KkItem
{
    public string $pub_date;

    public function __construct(
        public readonly string $title,
        public readonly string $link,
        public readonly string $html_description,
        public readonly string $guid,
        int $pub_time,
    ) {
        $this->pub_date = date(DATE_RSS, $pub_time);
    }
}
