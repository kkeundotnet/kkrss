<?php
declare(strict_types=1);

namespace Kkeundotnet\Kkrss;
?><?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>
  <title><?= htmlspecialchars($this->title) ?></title>
  <link><?= $this->link ?></link>
  <description><?= htmlspecialchars($this->description) ?></description>
  <?php foreach ($this->items as $item): ?>
  <item>
    <title><?= htmlspecialchars($item->title) ?></title>
    <link><?= $item->link ?></link>
    <description><![CDATA[<?= $item->description ?>]]></description>
    <guid isPermaLink="<?= $this->is_perma_link_guid ? 'true' : 'false' ?>"><?= $item->guid ?></guid>
    <pubDate><?= $item->pub_date ?></pubDate>
  </item>
  <?php endforeach; ?>
</channel>
</rss>
