<?php
declare(strict_types=1);

namespace Kkeundotnet\Kkrss;

?><?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
  <title><?= self::xml_escape($this->title) ?></title>
  <link><?= self::xml_escape($this->link) ?></link>
<?php if (!is_null($this->feed_link)): ?>
  <atom:link href="<?= self::xml_escape($this->feed_link) ?>" rel="self" type="application/rss+xml" />
<?php endif; ?>
  <description><?= self::xml_escape($this->description) ?></description>
<?php foreach ($this->items as $item): ?>
  <item>
    <title><?= self::xml_escape($item->title) ?></title>
    <link><?= self::xml_escape($item->link) ?></link>
    <description><![CDATA[<?= $item->html_description ?>]]></description>
    <guid isPermaLink="<?= $this->is_perma_link_guid ? 'true' : 'false' ?>"><?= self::xml_escape($item->guid) ?></guid>
    <pubDate><?= self::xml_escape($item->pub_date) ?></pubDate>
  </item>
<?php endforeach; ?>
</channel>
</rss>
