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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.    See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA    02111-1307, USA.
 *}-->

<!--▼HEADER-->
<div id="header_wrap">
    <div id="header" class="clearfix">
        <div id="logo_area">
            <p id="site_description">トラック用品物流用品専門店ルート2のネットショップ通販,メッキパーツやハンドルカバー・エアーホーン・金華山カーテン・泥除け等を販売</p>
            <h1>
                <a href="<!--{$smarty.const.HTTP_URL}-->">
                    <img src="<!--{$TPL_URLPATH}-->img/header/logo.gif" alt="EC-CUBE ONLINE SHOPPING SITE" />
                    <span><!--{$arrSiteInfo.shop_name|h}-->/<!--{$tpl_title|h}--></span>
                </a>
            </h1>
        </div>
        <div id="header_utility">
            <div id="headerInternalColumn">
            <!--{* ▼HeaderInternal COLUMN*}-->
            <!--{if $arrPageLayout.HeaderInternalNavi|@count > 0}-->
                <!--{* ▼上ナビ *}-->
                <!--{foreach key=HeaderInternalNaviKey item=HeaderInternalNaviItem from=$arrPageLayout.HeaderInternalNavi}-->
                    <!-- ▼<!--{$HeaderInternalNaviItem.bloc_name}--> -->
                    <!--{if $HeaderInternalNaviItem.php_path != ""}-->
                        <!--{include_php file=$HeaderInternalNaviItem.php_path items=$HeaderInternalNaviItem}-->
                    <!--{else}-->
                        <!--{include file=$HeaderInternalNaviItem.tpl_path items=$HeaderInternalNaviItem}-->
                    <!--{/if}-->
                    <!-- ▲<!--{$HeaderInternalNaviItem.bloc_name}--> -->
                <!--{/foreach}-->
                <!--{* ▲上ナビ *}-->
            <!--{/if}-->
            <!--{* ▲HeaderInternal COLUMN*}-->
            </div>

            <div id="header_link">
                <a id="twitter" target="_blank" href="https://twitter.com/#!/route2info"><img src="<!--{$TPL_URLPATH}-->img/common/twitter.jpg"></a>
                <a id="facebook" target="_blank" href="http://www.facebook.com/route2info"><img src="<!--{$TPL_URLPATH}-->img/common/facebook.jpg"></a>
            </div>

            <div id="header_navi">
                <ul>
                    <li class="visiter">
                        <img src="<!--{$TPL_URLPATH}-->img/header/h_menu_icon_a.gif" alt="初めての方へ" name="visiter" id="visiter" />
                        <a href="<!--{$smarty.const.HTTP_URL}-->user_data/utility.php">初めての方へ</a>
                    </li>
                    <li class="spacer">|</li>
                    <li class="mypage">
                        <img src="<!--{$TPL_URLPATH}-->img/header/h_menu_icon_b.gif" alt="ログイン" name="mypage" id="mypage" />
                        <!--{if $tpl_login || $TPL_LOGIN }-->
                            <a href="<!--{$smarty.const.HTTP_URL}-->mypage/">マイページ</a>
                        <!--{else}-->
                            <a href="<!--{$smarty.const.HTTP_URL}-->mypage/login.php">ログイン</a>
                        <!--{/if}-->
                   </li>
                    <li class="spacer">|</li>
                    <li class="entry">
                        <!--{if $tpl_login || $TPL_LOGIN }-->
                            <img src="<!--{$TPL_URLPATH}-->img/header/h_menu_icon_c.gif" alt="ログアウト" name="entry" id="entry" /><a href="<!--{$smarty.const.HTTPS_URL}-->frontparts/login_check.php?mode=logout">ログアウト</a>
                        <!--{else}-->
                            <img src="<!--{$TPL_URLPATH}-->img/header/h_menu_icon_c.gif" alt="会員登録" name="entry" id="" />
                            <a href="<!--{$smarty.const.ROOT_URLPATH}-->entry/kiyaku.php">会員登録</a>
                        <!--{/if}-->
                    </li>
                    <li class="spacer">|</li>
                    <li class="contact">
                        <img src="<!--{$TPL_URLPATH}-->img/header/h_menu_icon_d.gif" alt="お問い合わせ" name="contact" id="contact" />
                        <a href="<!--{$smarty.const.HTTP_URL}-->contact/<!--{$smarty.const.DIR_INDEX_PATH}-->">お問い合わせ</a>
                    </li>
                    <!--{*
                    <li class="cartin" <!--{if !$tpl_login && !$TPL_LOGIN}-->id="header_cart"<!--{/if}-->>
                        <a href="<!--{$smarty.const.CART_URLPATH}-->"><img src="<!--{$TPL_URLPATH}-->img/header/h_cart.gif" alt="カートを見る" name="cartin" id="cartin" /></a>
                    </li>
                    *}-->
                </ul>
            </div>
        </div>
        <div id="cartbtn">
            <a href="<!--{$smarty.const.CART_URLPATH}-->">
                <img width="130" height="26" id="h_cart" name="h_cart" alt="ヘッダーカート" src="<!--{$TPL_URLPATH}-->img/header/h_cart.gif">
            </a>
        </div>
    </div>
</div>
<!--▲HEADER-->
