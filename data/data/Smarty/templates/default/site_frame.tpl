<!--{printXMLDeclaration}--><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--{*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2012 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *}-->

<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" class="<!--{$tpl_page_class_name|h}-->">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<!--{$smarty.const.CHAR_CODE}-->" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link rel="stylesheet" href="<!--{$TPL_URLPATH}-->css/import.css" type="text/css" media="all" />
<link rel="alternate" type="application/rss+xml" title="RSS" href="<!--{$smarty.const.HTTP_URL}-->rss/<!--{$smarty.const.DIR_INDEX_PATH}-->" />
<!--{if $tpl_page_category == "abouts"}-->
<!--{if ($smarty.server.HTTPS != "") && ($smarty.server.HTTPS != "off")}-->
<script type="text/javascript" src="https://maps-api-ssl.google.com/maps/api/js?sensor=false"></script>
<!--{else}-->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<!--{/if}-->
<!--{/if}-->
<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/css.js"></script>
<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/navi.js"></script>
<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/win_op.js"></script>
<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/site.js"></script>
<script type="text/javascript" src="<!--{$smarty.const.ROOT_URLPATH}-->js/jquery-1.4.2.min.js"></script>
<!--{*
<title><!--{$arrSiteInfo.shop_name|h}--><!--{if $tpl_subtitle|strlen >= 1}--> / <!--{$tpl_subtitle|h}--><!--{elseif $tpl_title|strlen >= 1}--> / <!--{$tpl_title|h}--><!--{/if}--></title>
<!--{if $arrPageLayout.author|strlen >= 1}-->
    <meta name="author" content="<!--{$arrPageLayout.author|h}-->" />
<!--{/if}-->
<!--{if $arrPageLayout.description|strlen >= 1}-->
    <meta name="description" content="<!--{$arrPageLayout.description|h}-->" />
<!--{/if}-->
<!--{if $arrPageLayout.keyword|strlen >= 1}-->
    <meta name="keywords" content="<!--{$arrPageLayout.keyword|h}-->" />
<!--{/if}-->
*}-->
<!--{if $tpl_title == "TOPページ" ||  $tpl_title == ""}-->
        <title>トラック用品と物流用品の専門店ルート2通販サイト</title>
        <meta name="keywords" content="トラック用品,物流用品,トラックパーツ,JET,エアホーン,ハンドルカバー,JB,ヤンキーホーン,金華山" />
        <meta name="description" content="トラック用品物流用品の専門店ルート2通販サイトです。日本ボデーパーツやJETイノウエのトラックパーツを豊富に品揃え。エアーホーンをはじめ金華山ハンドルカバーやカーテン、泥除け、タイヤチェーン等も販売しています。" />
<!--{elseif $tpl_title == "商品一覧ページ"}-->
        <title><!--{$tpl_subtitle|escape}-->｜トラック用品と物流用品の専門店ルート2通販サイト</title>
        <meta name="keywords" content="<!--{$tpl_subtitle|escape}-->,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="<!--{$tpl_subtitle|escape}-->の商品一覧です。トラック用品・物流用品店ルート2の通販サイトでは、ボデーパーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等のトラック部品や物流用品を豊富に取り揃えております。" />
<!--{elseif $tpl_mainpage=="shopping/index.tpl"}-->
        <title>ログイン｜トラック用品と物流用品の専門店ルート2通販サイト</title>
        <meta name="keywords" content="ログイン,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="ログインページです。トラック用品・物流用品店ルート2の通販サイトでは、トラック用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{elseif $tpl_mainpage=="shopping/card.tpl"}-->
        <title>クレジットカード決済｜トラック用品や物流用品の専門店ルート2</title>
        <meta name="keywords" content="クレジットカード決済,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="クレジットカード決済ページです。トラック用品・物流用品店ルート2の通販サイトでは、トラック用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{elseif $tpl_mainpage=="shopping/complete.tpl"}-->
        <title>ご注文完了｜トラック用品や物流用品の専門店ルート2</title>
        <meta name="keywords" content="ご注文完了,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="ご注文完了ページです。トラック用品・物流用品店ルート2の通販サイトでは、トラック用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{elseif $tpl_mainpage=="shopping/confirm.tpl"}-->
        <title>ご入力内容のご確認｜トラック用品や物流用品の専門店ルート2</title>
        <meta name="keywords" content="入力内容,ご確認,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="ご入力内容のご確認ページです。トラック用品・物流用品店ルート2の通販サイトでは、トラック用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{elseif $tpl_mainpage=="shopping/convenience.tpl"}-->
        <title>コンビニ決済｜トラック用品や物流用品の専門店ルート2</title>
        <meta name="keywords" content="コンビニ決済,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="コンビニ決済ページです。トラック用品・物流用品店ルート2の通販サイトでは、トラック用用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{elseif $tpl_mainpage=="shopping/deliv.tpl"}-->
        <title>お届け先の指定｜トラック用品や物流用品の専門店ルート2</title>
        <meta name="keywords" content="お届け先の指定,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="お届け先の指定ページ。トラック用品・物流用品店ルート2の通販サイトでは、トラック用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{elseif $tpl_mainpage=="shopping/nonmember_input.tpl"}-->
        <title>お客様情報入力｜トラック用品や物流用品の専門店ルート2</title>
        <meta name="keywords" content="お客様情報入力,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="お客様情報の入力ページです。トラック用品・物流用品店ルート2の通販サイトでは、トラック用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{elseif $tpl_mainpage=="shopping/payment.tpl"}-->
        <title>お支払い方法、お届け時間等の指定｜トラック用品や物流用品の専門店ルート2</title>
        <meta name="keywords" content="お支払い方法,お届け時間,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="お支払い方法、お届け時間等の指定についてです。トラック用品・物流用品店ルート2の通販サイトでは、トラック用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{else}-->
        <title><!--{$tpl_title|escape}-->｜トラック用品や物流用品の専門店ルート2</title>
        <meta name="keywords" content="<!--{$tpl_title|escape}-->,トラック用品,物流用品,通販,販売" />
        <meta name="description" content="<!--{$tpl_title|escape}-->。トラック用品・物流用品店ルート2の通販サイトでは、トラック用パーツやハンドルカバー、エアホーンをはじめ金華山製品や泥除け等、トラック部品や物流用品を豊富に取り揃えております。" />
<!--{/if}-->
<!--{*
<link rel="shortcut icon" href="<!--{$TPL_URLPATH}-->img/common/favicon.ico" />
<link rel="icon" type="image/vnd.microsoft.icon" href="<!--{$TPL_URLPATH}-->img/common/favicon.ico" />
*}-->
<script type="text/javascript">//<![CDATA[
    <!--{$tpl_javascript}-->
    $(function(){
        <!--{$tpl_onload}-->
    });
//]]></script>

<!--{* //update1009 *}-->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-10534560-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<!--{* //update1009 *}-->

<!--{* ▼Head COLUMN*}-->
<!--{if $arrPageLayout.HeadNavi|@count > 0}-->
    <!--{* ▼上ナビ *}-->
    <!--{foreach key=HeadNaviKey item=HeadNaviItem from=$arrPageLayout.HeadNavi}-->
        <!--{* ▼<!--{$HeadNaviItem.bloc_name}--> ここから*}-->
        <!--{if $HeadNaviItem.php_path != ""}-->
            <!--{include_php file=$HeadNaviItem.php_path}-->
        <!--{else}-->
            <!--{include file=$HeadNaviItem.tpl_path}-->
        <!--{/if}-->
        <!--{* ▲<!--{$HeadNaviItem.bloc_name}--> ここまで*}-->
    <!--{/foreach}-->
    <!--{* ▲上ナビ *}-->
<!--{/if}-->
<!--{* ▲Head COLUMN*}-->
</head>

<!-- ▼BODY部 スタート -->
<!--{include file='./site_main.tpl'}-->
<!-- ▲BODY部 エンド -->

</html>
