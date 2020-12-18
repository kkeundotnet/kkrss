<?php
declare(strict_types=1);

namespace Kkeundotnet\Kkrss;

class KkItem
{
    public string $title;
    public string $link;
    public string $html_description;
    public string $guid;
    public string $pub_date;

    public function __construct(
        string $title,
        string $link,
        string $html_description,
        string $guid,
        int $pub_time
    ) {
        $this->title = $title;
        $this->link = $link;
        $this->html_description = $html_description;
        $this->guid = $guid;
        $this->pub_date = date(DATE_RSS, $pub_time);
    }
}
