<?php
declare(strict_types=1);

use Kkeundotnet\Kkrss\KkItem;
use Kkeundotnet\Kkrss\KkViewer;
use PHPUnit\Framework\TestCase;

class KkViewerInstance extends KkViewer
{
    public function __construct()
    {
        $this->title = 'My blog';
        $this->link = 'https://my.blog.com/';
        $this->description = 'Latest blog posts';
        $this->is_perma_link_guid = true;
        $this->items = [];
    }
}

final class Test extends TestCase
{
    public function testEmptyRss(): void
    {
        $expected = <<<'EXP'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>
  <title>My blog</title>
  <link>https://my.blog.com/</link>
  <description>Latest blog posts</description>
  </channel>
</rss>

EXP;
        $this->expectOutputString($expected);

        $viewer = new KkViewerInstance;
        $viewer->view_for_test();
    }

    public function testItemsRss(): void
    {
        $expected = <<<'EXP'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>
  <title>My blog</title>
  <link>https://my.blog.com/</link>
  <description>Latest blog posts</description>
    <item>
    <title>title1</title>
    <link>https://link1</link>
    <description><![CDATA[description1]]></description>
    <guid isPermaLink="true">guid1</guid>
    <pubDate>Sun, 29 Nov 2020 15:44:53 +0000</pubDate>
  </item>
    <item>
    <title>title2</title>
    <link>https://link2</link>
    <description><![CDATA[description2]]></description>
    <guid isPermaLink="true">guid2</guid>
    <pubDate>Sun, 29 Nov 2020 15:44:53 +0000</pubDate>
  </item>
  </channel>
</rss>

EXP;
        $this->expectOutputString($expected);

        $viewer = new KkViewerInstance;
        $viewer->items[] = new KkItem(
            'title1',
            'https://link1',
            'description1',
            'guid1',
            strtotime('2020-11-30T00:44:53+09:00')
        );
        $viewer->items[] = new KkItem(
            'title2',
            'https://link2',
            'description2',
            'guid2',
            strtotime('2020-11-30T00:44:53+09:00')
        );
        $viewer->view_for_test();
    }
}
