<?php

declare(strict_types=1);

use Kkeundotnet\Kkrss\KkItem;
use Kkeundotnet\Kkrss\KkViewer;
use PHPUnit\Framework\TestCase;

class KkViewerInstance extends KkViewer
{
    /** @param KkItem[] $items */
    public function __construct(array $items)
    {
        parent::__construct(
            title: 'My blog',
            link: 'https://my.blog.com/',
            description: 'Latest blog posts',
            is_perma_link_guid: true,
            items: $items,
        );
    }
}

class KkViewerInstanceWithFeedLink extends KkViewer
{
    /** @param KkItem[] $items */
    public function __construct(array $items)
    {
        parent::__construct(
            title: 'My blog',
            link: 'https://my.blog.com/',
            description: 'Latest blog posts',
            is_perma_link_guid: true,
            items: $items,
            feed_link: 'https://my.blog.com/feed.xml',
        );
    }
}

class KkViewerBadUserInstance extends KkViewer
{
    /** @param KkItem[] $items */
    public function __construct(array $items)
    {
        parent::__construct(
            title: '&"\'<>',
            link: 'https://&"\'<>',
            description: '&"\'<>',
            is_perma_link_guid: true,
            items: $items,
        );
    }
}

final class Test extends TestCase
{
    public function testEmptyRss(): void
    {
        $expected = <<<'EXP'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
  <title>My blog</title>
  <link>https://my.blog.com/</link>
  <description>Latest blog posts</description>
</channel>
</rss>

EXP;
        $this->expectOutputString($expected);

        $viewer = new KkViewerInstance([]);
        $viewer->view_for_test();
    }

    public function testItemsRss(): void
    {
        $expected = <<<'EXP'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
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

        $viewer = new KkViewerInstance([
            new KkItem(
                title: 'title1',
                link: 'https://link1',
                html_description: 'description1',
                guid: 'guid1',
                pub_time: strtotime('2020-11-30T00:44:53+09:00'),
            ),
            new KkItem(
                title: 'title2',
                link: 'https://link2',
                html_description: 'description2',
                guid: 'guid2',
                pub_time: strtotime('2020-11-30T00:44:53+09:00'),
            ),
        ]);
        $viewer->view_for_test();
    }

    public function testBadItemRss(): void
    {
        $expected = <<<'EXP'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
  <title>&amp;&quot;&apos;&lt;&gt;</title>
  <link>https://&amp;&quot;&apos;&lt;&gt;</link>
  <description>&amp;&quot;&apos;&lt;&gt;</description>
  <item>
    <title>&amp;&quot;&apos;&lt;&gt;</title>
    <link>https://&amp;&quot;&apos;&lt;&gt;</link>
    <description><![CDATA[&amp;&quot;&apos;&lt;&gt;]]&gt;]]></description>
    <guid isPermaLink="true">&amp;&quot;&apos;&lt;&gt;</guid>
    <pubDate>Sun, 29 Nov 2020 15:44:53 +0000</pubDate>
  </item>
</channel>
</rss>

EXP;
        $this->expectOutputString($expected);

        $viewer = new KkViewerBadUserInstance([
            new KkItem(
                title: '&"\'<>',
                link: 'https://&"\'<>',
                html_description: '&amp;&quot;&apos;&lt;&gt;]]&gt;',
                guid: '&"\'<>',
                pub_time: strtotime('2020-11-30T00:44:53+09:00'),
            ),
        ]);
        $viewer->view_for_test();
    }

    public function testFeeLink(): void
    {
        $expected = <<<'EXP'
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
  <title>My blog</title>
  <link>https://my.blog.com/</link>
  <atom:link href="https://my.blog.com/feed.xml" rel="self" type="application/rss+xml" />
  <description>Latest blog posts</description>
</channel>
</rss>

EXP;
        $this->expectOutputString($expected);
        $viewer = new KkViewerInstanceWithFeedLink([]);
        $viewer->view_for_test();
    }
}
