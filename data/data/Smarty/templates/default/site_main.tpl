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

<body>
<!--{$GLOBAL_ERR}-->
<noscript>
    <p>JavaScript を有効にしてご利用下さい.</p>
</noscript>

<div class="frame_outer">
    <a name="top" id="top"></a>

    <!--{* ▼HeaderHeaderTop COLUMN*}-->
    <!--{if $arrPageLayout.HeaderTopNavi|@count > 0}-->
        <div id="headertopcolumn">
            <!--{* ▼上ナビ *}-->
            <!--{foreach key=HeaderTopNaviKey item=HeaderTopNaviItem from=$arrPageLayout.HeaderTopNavi}-->
                <!-- ▼<!--{$HeaderTopNaviItem.bloc_name}--> -->
                <!--{if $HeaderTopNaviItem.php_path != ""}-->
                    <!--{include_php file=$HeaderTopNaviItem.php_path items=$HeaderTopNaviItem}-->
                <!--{else}-->
                    <!--{include file=$HeaderTopNaviItem.tpl_path items=$HeaderTopNaviItem}-->
                <!--{/if}-->
                <!-- ▲<!--{$HeaderTopNaviItem.bloc_name}--> -->
            <!--{/foreach}-->
            <!--{* ▲上ナビ *}-->
        </div>
    <!--{/if}-->
    <!--{* ▲HeaderHeaderTop COLUMN*}-->
    <!--{* ▼HEADER *}-->
    <div id="content_header">
        <div id="siteCap">
            <!--{if $tpl_title == "商品一覧ページ"}-->
                <h1><!--{$tpl_subtitle|escape}-->の商品一覧</h1><p>トラック用品の通販サイト</p>
            <!--{elseif $tpl_title == "TOPページ" ||  $tpl_title == ""}-->
                <h1>トラック用品の通販サイト</h1>
            <!--{elseif $tpl_mainpage=="shopping/index.tpl"}-->
                <h1>ログイン。</h1><p>トラック用品の通販サイト</p>
            <!--{*elseif $tpl_mainpage=="shopping/card.tpl" || $tpl_mainpage=="shopping/complete.tpl" || $tpl_mainpage=="shopping/confirm.tpl" || $tpl_mainpage=="shopping/convenience.tpl" || $tpl_mainpage=="shopping/deliv.tpl" || $tpl_mainpage=="shopping/nonmember_input.tpl" || $tpl_mainpage=="shopping/payment.tpl"*}-->
            <!--{elseif $tpl_mainpage|strpos:"shopping/"}-->
                <h1>購入手続き</h1><p>トラック用品の通販サイト</p>
            <!--{else}-->
                <h1><!--{$tpl_title|escape}--></h1><p>トラック用品の通販サイト</p>
            <!--{/if}-->
        </div>
    </div>
    <!--{if $arrPageLayout.header_chk != 2}-->
        <!--{include file= $header_tpl}-->
    <!--{/if}-->
    <!--{* ▲HEADER *}-->

    <div id="container" class="clearfix">

        <!--{* ▼TOP COLUMN*}-->
        <!--{if $arrPageLayout.TopNavi|@count > 0}-->
            <div id="topcolumn">
                <!--{* ▼上ナビ *}-->
                <!--{foreach key=TopNaviKey item=TopNaviItem from=$arrPageLayout.TopNavi}-->
                    <!-- ▼<!--{$TopNaviItem.bloc_name}--> -->
                    <!--{if $TopNaviItem.php_path != ""}-->
                        <!--{include_php file=$TopNaviItem.php_path items=$TopNaviItem}-->
                    <!--{else}-->
                        <!--{include file=$TopNaviItem.tpl_path items=$TopNaviItem}-->
                    <!--{/if}-->
                    <!-- ▲<!--{$TopNaviItem.bloc_name}--> -->
                <!--{/foreach}-->
                <!--{* ▲上ナビ *}-->
            </div>
        <!--{/if}-->
        <!--{* ▲TOP COLUMN*}-->

        <!--{* ▼LEFT COLUMN *}-->
        <!--{if $arrPageLayout.LeftNavi|@count > 0}-->
            <div id="leftcolumn" class="side_column">
                <!--{* ▼左ナビ *}-->
                <!--{foreach key=LeftNaviKey item=LeftNaviItem from=$arrPageLayout.LeftNavi}-->
                    <!-- ▼<!--{$LeftNaviItem.bloc_name}--> -->
                    <!--{if $LeftNaviItem.php_path != ""}-->
                        <!--{include_php file=$LeftNaviItem.php_path items=$LeftNaviItem}-->
                    <!--{else}-->
                        <!--{include file=$LeftNaviItem.tpl_path items=$LeftNaviItem}-->
                    <!--{/if}-->
                    <!-- ▲<!--{$LeftNaviItem.bloc_name}--> -->
                <!--{/foreach}-->
                <!--{* ▲左ナビ *}-->
            </div>
        <!--{/if}-->
        <!--{* ▲LEFT COLUMN *}-->

        <!--{* ▼CENTER COLUMN *}-->
        <div
            <!--{if $tpl_column_num == 3}-->
                id="three_maincolumn"
            <!--{elseif $tpl_column_num == 2}-->
                <!--{if $arrPageLayout.LeftNavi|@count == 0}-->
                    id="two_maincolumn_left"
                <!--{else}-->
                    id="two_maincolumn_right"
                <!--{/if}-->
            <!--{elseif $tpl_column_num == 1}-->
                id="one_maincolumn"
            <!--{/if}-->
            class="main_column"
        >
            <!--{* ▼メイン上部 *}-->
            <!--{if $arrPageLayout.MainHead|@count > 0}-->
                <!--{foreach key=MainHeadKey item=MainHeadItem from=$arrPageLayout.MainHead}-->
                    <!-- ▼<!--{$MainHeadItem.bloc_name}--> -->
                    <!--{if $MainHeadItem.php_path != ""}-->
                        <!--{include_php file=$MainHeadItem.php_path items=$MainHeadItem}-->
                    <!--{else}-->
                        <!--{include file=$MainHeadItem.tpl_path items=$MainHeadItem}-->
                    <!--{/if}-->
                    <!-- ▲<!--{$MainHeadItem.bloc_name}--> -->
                <!--{/foreach}-->
            <!--{/if}-->
            <!--{* ▲メイン上部 *}-->

            <!-- ▼メイン -->
            <!--{include file=$tpl_mainpage}-->
            <!-- ▲メイン -->

            <!--{* ▼メイン下部 *}-->
            <!--{if $arrPageLayout.MainFoot|@count > 0}-->
                <!--{foreach key=MainFootKey item=MainFootItem from=$arrPageLayout.MainFoot}-->
                    <!-- ▼<!--{$MainFootItem.bloc_name}--> -->
                    <!--{if $MainFootItem.php_path != ""}-->
                        <!--{include_php file=$MainFootItem.php_path items=$MainFootItem}-->
                    <!--{else}-->
                        <!--{include file=$MainFootItem.tpl_path items=$MainFootItem}-->
                    <!--{/if}-->
                    <!-- ▲<!--{$MainFootItem.bloc_name}--> -->
                <!--{/foreach}-->
            <!--{/if}-->
            <!--{* ▲メイン下部 *}-->
        </div>
        <!--{* ▲CENTER COLUMN *}-->

        <!--{* ▼RIGHT COLUMN *}-->
        <!--{if $arrPageLayout.RightNavi|@count > 0}-->
            <div id="rightcolumn" class="side_column">
                <!--{* ▼右ナビ *}-->
                <!--{foreach key=RightNaviKey item=RightNaviItem from=$arrPageLayout.RightNavi}-->
                    <!-- ▼<!--{$RightNaviItem.bloc_name}--> -->
                    <!--{if $RightNaviItem.php_path != ""}-->
                        <!--{include_php file=$RightNaviItem.php_path items=$RightNaviItem}-->
                    <!--{else}-->
                        <!--{include file=$RightNaviItem.tpl_path items=$RightNaviItem}-->
                    <!--{/if}-->
                    <!-- ▲<!--{$RightNaviItem.bloc_name}--> -->
                <!--{/foreach}-->
                <!--{* ▲右ナビ *}-->
            </div>
        <!--{/if}-->
        <!--{* ▲RIGHT COLUMN *}-->

        <!--{* ▼BOTTOM COLUMN*}-->
        <!--{if $arrPageLayout.BottomNavi|@count > 0}-->
            <div id="bottomcolumn">
                <!--{* ▼下ナビ *}-->
                <!--{foreach key=BottomNaviKey item=BottomNaviItem from=$arrPageLayout.BottomNavi}-->
                    <!-- ▼<!--{$BottomNaviItem.bloc_name}--> -->
                    <!--{if $BottomNaviItem.php_path != ""}-->
                        <!--{include_php file=$BottomNaviItem.php_path items=$BottomNaviItem}-->
                    <!--{else}-->
                        <!--{include file=$BottomNaviItem.tpl_path items=$BottomNaviItem}-->
                    <!--{/if}-->
                    <!-- ▲<!--{$BottomNaviItem.bloc_name}--> -->
                <!--{/foreach}-->
                <!--{* ▲下ナビ *}-->
            </div>
        <!--{/if}-->
        <!--{* ▲BOTTOM COLUMN*}-->

    </div>

    <!--{* ▼FOOTER *}-->
    <!--{if $arrPageLayout.footer_chk != 2}-->
        <!--{include file=$footer_tpl}-->
    <!--{/if}-->
    <!--{* ▲FOOTER *}-->
    <!--{* ▼FooterBottom COLUMN*}-->
    <!--{if $arrPageLayout.FooterBottomNavi|@count > 0}-->
        <div id="footerbottomcolumn">
            <!--{* ▼上ナビ *}-->
            <!--{foreach key=FooterBottomNaviKey item=FooterBottomNaviItem from=$arrPageLayout.FooterBottomNavi}-->
                <!-- ▼<!--{$FooterBottomNaviItem.bloc_name}--> -->
                <!--{if $FooterBottomNaviItem.php_path != ""}-->
                    <!--{include_php file=$FooterBottomNaviItem.php_path items=$FooterBottomNaviItem}-->
                <!--{else}-->
                    <!--{include file=$FooterBottomNaviItem.tpl_path items=$FooterBottomNaviItem}-->
                <!--{/if}-->
                <!-- ▲<!--{$FooterBottomNaviItem.bloc_name}--> -->
            <!--{/foreach}-->
            <!--{* ▲上ナビ *}-->
        </div>
    <!--{/if}-->
    <!--{* ▲FooterBottom COLUMN*}-->
</div>
<!--{if $smarty.server.REQUEST_URI == $smarty.const.TOP_URLPATH || $smarty.server.REQUEST_URI == $smarty.const.HTTPS_URL || $smarty.server.REQUEST_URI == $smarty.const.HTTP_URL}-->
<!-- Google Code for &#12522;&#12510;&#12540;&#12465;&#12486;&#12451;&#12531;&#12464; &#12479;&#12464; -->
<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1002882554;
var google_conversion_label = "WQpWCJblhwQQ-oub3gM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1002882554/?value=0&amp;label=WQpWCJblhwQQ-oub3gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!--{/if}-->
</body>
