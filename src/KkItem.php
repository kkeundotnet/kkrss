<?php
declare(strict_types=1);

namespace Kkeundotnet\Kkrss;

class KkItem
{
    public string $title;
    public string $link;
    public string $description;
    public string $guid;
    public string $pub_date;

    public function __construct(
        string $title,
        string $link,
        string $description,
        string $guid,
        string $pub_date
    ) {
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
        $this->guid = $guid;
        $this->pub_date = $pub_date;
    }
}
