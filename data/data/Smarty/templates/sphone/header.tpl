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
<!--{*
<header class="global_header clearfix">
    <h1><a rel="external" href="<!--{$smarty.const.ROOT_URLPATH}-->"><img src="<!--{$TPL_URLPATH}-->img/header/logo.png" width="150" height="25" alt="<!--{$arrSiteInfo.shop_name|h}-->" /></a></h1>
    <div class="header_utility">
        <!--{* ▼HeaderInternal COLUMN }-->
        <!--{if $arrPageLayout.HeaderInternalNavi|@count > 0}-->
            <!--{* ▼上ナビ }-->
            <!--{foreach key=HeaderInternalNaviKey item=HeaderInternalNaviItem from=$arrPageLayout.HeaderInternalNavi}-->
                <!-- ▼<!--{$HeaderInternalNaviItem.bloc_name}--> -->
                <!--{if $HeaderInternalNaviItem.php_path != ""}-->
                    <!--{include_php file=$HeaderInternalNaviItem.php_path items=$HeaderInternalNaviItem}-->
                <!--{else}-->
                    <!--{include file=$HeaderInternalNaviItem.tpl_path items=$HeaderInternalNaviItem}-->
                <!--{/if}-->
                <!-- ▲<!--{$HeaderInternalNaviItem.bloc_name}--> -->
            <!--{/foreach}-->
            <!--{* ▲上ナビ }-->
        <!--{/if}-->
        <!--{* ▲HeaderInternal COLUMN }-->
    </div>
</header>
*}-->
<header>
    <h1><a href="<!--{$smarty.const.ROOT_URLPATH}-->"><img src="<!--{$TPL_URLPATH}-->img/header/logo.jpg" alt="トラック用品専門店 ルート2"></a></h1>
    <p><a href="tel:086-281-5568"><img src="<!--{$TPL_URLPATH}-->img/header/head_01.gif" alt="トラック用品のことなら何でもお気軽に！ 電話番号 086-281-5568 10:00〜21:00 年中無休"></a></p>
</header>

