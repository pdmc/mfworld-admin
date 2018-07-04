<?php

namespace think\paginator\driver;

use think\Paginator;

class Laypage extends Paginator
{
    /**
     * 显示总数
     * @return string
     */
    protected function getTotalButton(){
        $total = $this->total;
        $text = '共'.$total.'条数据';

        return $this->getDisabledTextWrapper($text);
    }

    /**
     * 上一页按钮
     * @param string $text
     * @return string
     */
    protected function getPreviousButton($text = "上一页")
    {

        if ($this->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url(
            $this->currentPage() - 1
        );

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 下一页按钮
     * @param string $text
     * @return string
     */
    protected function getNextButton($text = '下一页')
    {
        if (!$this->hasMore) {
            return '';
            // return $this->getDisabledTextWrapper($text);
        }

        $url = $this->url($this->currentPage() + 1);

        return $this->getPageLinkWrapper($url, $text);
    }

    /**
     * 页码按钮
     * @return string
     */
    protected function getLinks()
    {
        if ($this->simple)
            return '';

        $block = [
            'first'  => null,
            'slider' => null,
            'last'   => null
        ];

        $side   = 3;
        $window = $side * 2;

        if ($this->lastPage > 1) {
            if ($this->lastPage < $window + 6) {
                $block['first'] = $this->getUrlRange(1, $this->lastPage);
            } elseif ($this->currentPage <= $window) {
                $block['first'] = $this->getUrlRange(1, $window + 2);
                $block['last']  = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
            } elseif ($this->currentPage > ($this->lastPage - $window)) {
                $block['first'] = $this->getUrlRange(1, 2);
                $block['last']  = $this->getUrlRange($this->lastPage - ($window + 2), $this->lastPage);
            } else {
                $block['first']  = $this->getUrlRange(1, 2);
                $block['slider'] = $this->getUrlRange($this->currentPage - $side, $this->currentPage + $side);
                $block['last']   = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
            }
        }

        $html = '';

        if (is_array($block['first'])) {
            $html .= $this->getUrlLinks($block['first']);
        }
        if (is_array($block['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['slider']);
        }

        if (is_array($block['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['last']);
        }
        
        return $html;
    }

    /**
     * 渲染分页html
     * @return mixed
     */
    public function render()
    {
        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf(
                    '<div class="layui-box layui-laypage layui-laypage-default">%s %s</div>',
                    $this->getPreviousButton(),
                    $this->getNextButton()
                );
            } else {
                if ($this->currentPage() > 1) {
                    return sprintf(
                        '<div class="layui-box layui-laypage layui-laypage-default">%s %s %s %s</div>',
                        $this->getTotalButton(),
                        $this->getPreviousButton(),
                        $this->getLinks(),
                        $this->getNextButton()
                    );
                } else {
                    return sprintf(
                        '<div class="layui-box layui-laypage layui-laypage-default">%s %s %s</div>',
                        $this->getTotalButton(),
                        $this->getLinks(),
                        $this->getNextButton()
                    );
                }
            }
        } else {
            return sprintf(
                '<div class="layui-box layui-laypage layui-laypage-default">%s</div>',
                $this->getTotalButton()
            );
        }
    }

    /**
     * 生成一个可点击的按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page)
    {
        return '<a href="' . htmlentities($url) . '">' . $page . '</a>';
    }

    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return '<span class="layui-laypage-curr">' . $text . '</span>';
    }

    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>' . $text . '</em></span>';
    }

    /**
     * 生成省略号按钮
     *
     * @return string
     */
    protected function getDots()
    {
        return $this->getDisabledTextWrapper('...');
    }

    /**
     * 批量生成页码按钮.
     *
     * @param  array $urls
     * @return string
     */
    protected function getUrlLinks(array $urls)
    {
        $html = '';
        $currentPage = $this->currentPage;
        foreach ($urls as $page => $url) {
            if ($currentPage > 6) {
                if ($page == 1) {
                    $page = '首页';
                }
            }
            $html .= $this->getPageLinkWrapper($url, $page);
        }

        return $html;
    }

    /**
     * 生成普通页码按钮
     *
     * @param  string $url
     * @param  int    $page
     * @return string
     */
    protected function getPageLinkWrapper($url, $page)
    {
        if ($page == $this->currentPage()) {
            return $this->getActivePageWrapper($page);
        }

        return $this->getAvailablePageWrapper($url, $page);
    }
}