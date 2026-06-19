<?php

/**
 * SiteMeta – 站点元信息管理模块
 * 使用内部数组存储固定配置，并通过公共方法生成简洁的描述文本。
 */

class SiteMeta
{
    /**
     * 元信息数据容器
     *
     * @var array
     */
    private array $meta = [];

    /**
     * 构造时传入必要参数
     *
     * @param string $siteName  站点名称（必填）
     * @param string $domain    主域名
     * @param string $keyword   核心关键词，用于描述摘要
     * @param array  $extra     额外自定义数据（键值对）
     */
    public function __construct(
        string $siteName,
        string $domain,
        string $keyword,
        array $extra = []
    ) {
        $this->meta['name']    = $siteName;
        $this->meta['domain']  = $domain;
        $this->meta['keyword'] = $keyword;
        $this->meta['extra']   = $extra;
    }

    /**
     * 返回基础信息数组（引用不可修改）
     *
     * @return array
     */
    public function getInfo(): array
    {
        return $this->meta;
    }

    /**
     * 生成一行简短描述文本，适合页面 title 或 meta description。
     * 格式：{站点名称} - {关键词} | {域名}
     *
     * @return string
     */
    public function shortDescription(): string
    {
        $name    = htmlspecialchars($this->meta['name'], ENT_QUOTES, 'UTF-8');
        $keyword = htmlspecialchars($this->meta['keyword'], ENT_QUOTES, 'UTF-8');
        $domain  = htmlspecialchars($this->meta['domain'], ENT_QUOTES, 'UTF-8');

        return sprintf('%s - %s | %s', $name, $keyword, $domain);
    }

    /**
     * 获取全部元数据，并附加自动生成的签名行。
     *
     * @return array
     */
    public function fullMeta(): array
    {
        $result = $this->meta;
        $result['generated_description'] = $this->shortDescription();
        $result['version'] = '1.0';
        return $result;
    }
}

// ---------- 实例化演示 ----------

$site = new SiteMeta(
    '华体会官方资讯',
    'sitehth.com.cn',
    '华体会',
    [
        'language' => 'zh-CN',
        'locale'   => 'zh_CN',
        'author'   => '华体会团队',
    ]
);

// 输出简短描述（纯文本，无格式）
echo $site->shortDescription() . PHP_EOL;

// 如果需要查看完整元信息结构（仅测试用）
// var_dump($site->fullMeta());

// 典型使用：生成页面 <title> 标签
// echo '<title>' . $site->shortDescription() . '</title>';