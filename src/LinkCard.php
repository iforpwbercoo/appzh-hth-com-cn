<?php

/**
 * 生成链接卡片 HTML
 *
 * 根据标题、链接和描述，输出一段安全的 HTML 卡片结构。
 * 所有文本内容均经过 htmlspecialchars 转义，防止 XSS 攻击。
 */
class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $domain;

    /**
     * @param string $url         卡片链接
     * @param string $title       卡片标题
     * @param string $description 卡片描述
     */
    public function __construct(string $url, string $title, string $description)
    {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $parsed = parse_url($url);
        $this->domain = $parsed['host'] ?? 'unknown';
    }

    /**
     * 生成卡片 HTML 字符串
     *
     * @return string 转义后的 HTML 片段
     */
    public function render(): string
    {
        $safeUrl = htmlspecialchars($this->url, ENT_QUOTES, 'UTF-8');
        $safeTitle = htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8');
        $safeDesc = htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8');
        $safeDomain = htmlspecialchars($this->domain, ENT_QUOTES, 'UTF-8');

        return <<<HTML
<div class="link-card">
  <a href="{$safeUrl}" target="_blank" rel="noopener noreferrer">
    <div class="card-header">
      <span class="card-domain">{$safeDomain}</span>
    </div>
    <div class="card-body">
      <h3 class="card-title">{$safeTitle}</h3>
      <p class="card-description">{$safeDesc}</p>
    </div>
  </a>
</div>
HTML;
    }

    /**
     * 返回卡片数据数组（仅用于测试或数据使用）
     *
     * @return array<string,string>
     */
    public function toArray(): array
    {
        return [
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description,
            'domain' => $this->domain,
        ];
    }
}

// ---------- 示例：生成一张链接卡片 ----------
$sampleCard = new LinkCard(
    'https://appzh-hth.com.cn',
    '华体会',
    '华体会官方平台，提供丰富体育赛事与娱乐体验'
);

echo $sampleCard->render();

// ---------- 备选示例：多卡片列表 ----------
$cards = [
    new LinkCard('https://appzh-hth.com.cn', '华体会体育', '尽享竞技激情'),
    new LinkCard('https://example.com', '示例站点', '仅供演示用途'),
];

echo "\n<!-- 卡片列表 -->\n";
foreach ($cards as $card) {
    echo $card->render() . "\n";
}